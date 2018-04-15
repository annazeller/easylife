<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\GoogleClientHelper;
use Google_Client;
use Google_Service_Calendar;
use Google_CalendarService;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_FreeBusyRequest;
use Google_Service_Calendar_EventSource;
use Google_Service_Calendar_FreeBusyRequestItem;
use Auth;
use App\User;
use App\Calendar;
use App\ToDoModel;

class gCalendarController extends Controller
{

    protected $client;

    public function __construct(GoogleClientHelper $googleClientHelper)
    {

        $this->client = $googleClientHelper->client();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //DEPRECATED aber vielleicht brauchen wir sie noch für irgendwas
    public function index()
    {

        $user_id = Auth::id();
        $user = Auth::user();
        if ($user->gcalendar_integration_active) {

            $this->client->setAccessToken(Auth::user()->gcalendar_credentials);

            $calendar = new Calendar;
            $calendars = $calendar
                ->where('user_id', '=', $user_id)->get();

            $page_data = [
                'calendars' => $calendars
            ];

            return view('calendar.index', $page_data);
        } else {
            return redirect()->route('oauthCallback');
        }

    }

    public function dashboard(Request $request)
   { 
        $user = Auth::user();

        if ($user->gcalendar_integration_active) {
            
            $this->client->setAccessToken($user->gcalendar_credentials);
            if ($this->client->isAccessTokenExpired()) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update([
                    'gcalendar_credentials' => json_encode($accessToken),
                ]);
            }
            return view('dashboard');
        } else {
            return redirect()->route('oauthCallback');
        }
   }
    
    public function oauth(Request $request)
    {

        $input = $request->all();

        $user = Auth::user();

        if (! isset($input['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);

        } elseif (isset($input['code'])) {

            $this->client->authenticate($input['code']);
            $accessToken = $this->client->getAccessToken();

            $user->update([
                'gcalendar_credentials' => json_encode($accessToken),
                'gcalendar_integration_active' => true,
            ]);

            $this->savePrimaryCalendar();
            $this->saveLifestyle();

            return redirect()->route('dashboard');
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($title,$desc,$start,$end,$calendar_id)
    {
        $user = Auth::user();
        if ($user->gcalendar_integration_active) {
            
            $this->client->setAccessToken($user->gcalendar_credentials);
            if ($this->client->isAccessTokenExpired()) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update([
                    'gcalendar_credentials' => json_encode($accessToken),
                ]);
            }

            $user_id = Auth::id();
            $user = Auth::user();
            $transparency = "opaque";

            $start_datetime = $start;
            $end_datetime = $end;

            $cal = new \Google_Service_Calendar($this->client);
            $event = new \Google_Service_Calendar_Event();
            $event->setSummary($title);
            $event->setDescription($desc);

            $start = new \Google_Service_Calendar_EventDateTime();
            $start->setDateTime($start_datetime->toAtomString());
            $event->setStart($start);

            $end = new \Google_Service_Calendar_EventDateTime();
            $end->setDateTime($end_datetime->toAtomString());
            $event->setEnd($end);

            $event->setTransparency($transparency);

            $created_event = $cal->events->insert($calendar_id, $event);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        if ($user->gcalendar_integration_active) {
            
            $this->client->setAccessToken($user->gcalendar_credentials);
            if ($this->client->isAccessTokenExpired()) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update([
                    'gcalendar_credentials' => json_encode($accessToken),
                ]);
            }

            $service = new Google_Service_Calendar($this->client);
            $event = $service->events->get('primary', $eventId);
            if (!$event) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'data' => $event]);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->gcalendar_integration_active) {
            
            $this->client->setAccessToken($user->gcalendar_credentials);
            if ($this->client->isAccessTokenExpired()) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update([
                    'gcalendar_credentials' => json_encode($accessToken),
                ]);
            }

            $service = new Google_Service_Calendar($this->client);

            $startDateTime = Carbon::parse($request->start_date)->toRfc3339String();
            $eventDuration = 30; //minutes if no EndDate is set

            if ($request->has('end_date')) {
                $endDateTime = Carbon::parse($request->end_date)->toRfc3339String();
            } else {
                $endDateTime = Carbon::parse($request->start_date)->addMinutes($eventDuration)->toRfc3339String();
            }
            // retrieve the event from the API.
            $event = $service->events->get('primary', $eventId);

            $event->setSummary($request->title);
            $event->setDescription($request->description);
            //start time
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime($startDateTime);
            $event->setStart($start);
            //end time
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime($endDateTime);
            $event->setEnd($end);
            $updatedEvent = $service->events->update('primary', $event->getId(), $event);

            if (!$updatedEvent) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }

            return response()->json(['status' => 'success', 'data' => $updatedEvent]);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->gcalendar_integration_active) {
            
            $this->client->setAccessToken($user->gcalendar_credentials);
            if ($this->client->isAccessTokenExpired()) {
                $accessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update([
                    'gcalendar_credentials' => json_encode($accessToken),
                ]);
            }

            $service = new Google_Service_Calendar($this->client);

            $service->events->delete('primary', $eventId);

        } else {
            return redirect()->route('oauthCallback');
        }
    }

   //  public function createCalendar(Request $request)
   // {
   //      $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
   //      return view('calendar.create_calendar');
   // }


   // public function doCreateCalendar(Request $request, Calendar $calendar)
   // {
   //      $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
   //      $this->validate($request, [
   //          'title' => 'required|min:4'
   //      ]);

   //      $title = $request->input('title');
   //      $timezone = env('APP_TIMEZONE');

   //      $cal = new \Google_Service_Calendar($this->client);

   //      $google_calendar = new \Google_Service_Calendar_Calendar($this->client);
   //      $google_calendar->setSummary($title);
   //      $google_calendar->setTimeZone($timezone);

   //      $created_calendar = $cal->calendars->insert($google_calendar);

   //      $calendar_id = $created_calendar->getId();

   //      $calendar->user_id = Auth::id();
   //      $calendar->title = $title;
   //      $calendar->calendar_id = $calendar_id;
   //      $calendar->sync_token = '';
   //      $calendar->save();

   //      return redirect('/calendar/create')
   //          ->with('message', [
   //              'type' => 'success', 'text' => 'Calendar was created!'
   //          ]);
   // }

   public function savePrimaryCalendar()
   {
        $gServiceCal = new \Google_Service_Calendar($this->client);
        $gCalendarId = $gServiceCal->calendars->get("primary")->getId();
        $calendar = new Calendar;
        $calendar->user_id = Auth::id();
        $calendar->title = 'Primärkalender';
        $calendar->calendar_id = $gCalendarId;
        $calendar->sync_token = '';
        $calendar->save();

   }


   public function createEvent(Calendar $calendar, Request $request)
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $user_id = Auth::id();
        $calendars = $calendar
            ->where('user_id', '=', $user_id)->get();
        $page_data = [
            'calendars' => $calendars
        ];
        return view('calendar.create_event', $page_data);
   }


   public function doCreateEvent(ToDoModel $evt, Request $request)
   {
        $user_id = Auth::id();
        $user = Auth::user();
        $this->client->setAccessToken($user->gcalendar_credentials);
        $this->validate($request, [
            'title' => 'required',
            'calendar_id' => 'required',
            'datetime_start' => 'required|date|before:datetime_end',
            'datetime_end' => 'required|date|after:datetime_start'
        ]);

        $title = $request->input('title');
        $calendar_id = $request->input('calendar_id');
        $start = $request->input('datetime_start');
        $end = $request->input('datetime_end');
        $description = $request->input('description');
        $location = $request->input('location');
        $priority = $request->input('priority');
        $transparency = "opaque";


        $start_datetime = Carbon::createFromFormat('d.m.Y H:i', $start);
        $end_datetime = Carbon::createFromFormat('d.m.Y H:i', $end);

        $cal = new \Google_Service_Calendar($this->client);
        $event = new \Google_Service_Calendar_Event();
        $event->setSummary($title);

        $start = new \Google_Service_Calendar_EventDateTime();
        $start->setDateTime($start_datetime->toAtomString());
        $event->setStart($start);
        $end = new \Google_Service_Calendar_EventDateTime();
        $end->setDateTime($end_datetime->toAtomString());
        $event->setEnd($end);
        $event->setTransparency($transparency);

        $created_event = $cal->events->insert($calendar_id, $event);

        $evt->userId = $user_id;
        $evt->title = $title;
        $evt->description = $description;
        $evt->location = $location;
        $evt->priority = $priority;
        $evt->duration = $end_datetime->diffInMinutes($start_datetime);
        $evt->calendar_id = $calendar_id;
        $evt->event_id = $created_event->id;
        $evt->datetime_start = $start_datetime->toDateTimeString();
        $evt->datetime_end = $end_datetime->toDateTimeString();
        $evt->save();

        return redirect('/event/create')
                    ->with('message', [
                        'type' => 'success',
                        'text' => 'Event was created!'
                    ]);
   }


   public function syncCalendar(Calendar $calendar)
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $user_id = Auth::id();
        $calendars = $calendar->where('user_id', '=', $user_id)
            ->get();

        $page_data = [
            'calendars' => $calendars
        ];
        return view('calendar.sync_calendar', $page_data);
   }


   public function doSyncCalendar(Request $request) 
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $user_id = Auth::id();
        $base_timezone = env('APP_TIMEZONE');
        
        $calendar = Calendar::where('user_id', $user_id)->first();
        $calendar_id = $calendar->calendar_id;            
        $sync_token = $calendar->sync_token;
        $gCalendarId = $calendar_id;


        $gServiceCal = new \Google_Service_Calendar($this->client);
        $gCalendar = $gServiceCal->calendars->get($gCalendarId);
        $calendar_timezone = $gCalendar->getTimeZone();

        $termine = ToDoModel::where('calendar_id', $gCalendarId)
            ->pluck('event_id')
            ->toArray();
        
        if (!empty($sync_token)) {
            $params = array(
                'syncToken' => $sync_token
            );
        } else {
            $params = array(
                'showDeleted' => true,
                'timeMin' => Carbon::now()
                    ->setTimezone($calendar_timezone)
                    ->toAtomString()
            );
        }

        $googlecalendar_events = $gServiceCal->events->listEvents($gCalendarId, $params);
        
        while (true) {

            foreach ($googlecalendar_events->getItems() as $g_event) {

                $g_event_id = $g_event->id;
                $g_event_title = $g_event->getSummary();
                $g_status = $g_event->status;

                if ($g_status != 'cancelled') {

                    if (!$g_event->getStart()->getDateTime()) {
                        $g_datetime_start = Carbon::parse($g_event->getStart()->getDate())
                            ->tz($calendar_timezone)
                            ->setTimezone($base_timezone)
                            ->format('Y-m-d H:i');
                        $allday = 1;
                    } else {
                        $g_datetime_start = Carbon::parse($g_event->getStart()->getDateTime())
                            ->tz($calendar_timezone)
                            ->setTimezone($base_timezone)
                            ->format('Y-m-d H:i');
                        $allday=0;

                    }

                    if (!$g_event->getEnd()->getDateTime()) {
                        $g_datetime_end = Carbon::parse($g_event->getEnd()->getDate())
                            ->tz($calendar_timezone)
                            ->setTimezone($base_timezone)
                            ->format('Y-m-d H:i');
                    } else {
                        $g_datetime_end = Carbon::parse($g_event->getEnd()->getDateTime())
                            ->tz($calendar_timezone)
                            ->setTimezone($base_timezone)
                            ->format('Y-m-d H:i');
                    }

                    $start_datetime = Carbon::createFromFormat('Y-m-d H:i', $g_datetime_start);
                    $end_datetime = Carbon::createFromFormat('Y-m-d H:i', $g_datetime_end);
                    $duration = $end_datetime->diffInMinutes($start_datetime);

                    //check if event id is already in the events table
                    if (in_array($g_event_id, $termine)) {
                        //update event

                        $event = ToDoModel::where('event_id', $g_event_id)->first();
                        $event->title = $g_event_title;
                        $event->calendar_id = $gCalendarId;
                        $event->event_id = $g_event_id;
                        $event->datetime_start = $g_datetime_start;
                        $event->datetime_end = $g_datetime_end;
                        $event->duration = $duration;
                        $event->allday = $allday;
                        $event->scheduled = 1;
                        $event->completed = 2;
                        $event->save();
                    } else {
                        //add event
                        $event = new ToDoModel;
                        $event->userId = $user_id;
                        $event->title = $g_event_title;
                        $event->calendar_id = $gCalendarId;
                        $event->event_id = $g_event_id;
                        $event->datetime_start = $g_datetime_start;
                        $event->datetime_end = $g_datetime_end;
                        $event->duration = $duration;
                        $event->allday = $allday;
                        $event->scheduled = 1;
                        $event->completed = 2;

                        if (strpos($g_event_title, "(easyLife)") !== false)
                        {
                            $event->recurring = 1;
                        }

                        $event->save();
                    }

                } else {
                    //delete event
                    if (in_array($g_event_id, $termine)) {
                        ToDoModel::where('event_id', $g_event_id)->first()->delete();
                    }
                }

            }

            $page_token = $googlecalendar_events->getNextPageToken();

            if ($page_token) {
                $params['pageToken'] = $page_token;
                $googlecalendar_events = $gServiceCal->events->listEvents('primary', $params);

            } else {
                $next_synctoken = str_replace('=ok', '', $googlecalendar_events->getNextSyncToken());
                //update next sync token
                $calendar = Calendar::where('calendar_id', $gCalendarId)->first();
                $calendar->sync_token = $next_synctoken;
                $calendar->save();

                break;
            }

        }
        
        $message = [
                    'type' => 'success',
                    'text' => 'Kalender synchronisiert.'
                ];
        return response()->json($message);
        
        /**
        return redirect('/calendar/sync')
            ->with('message',
                [
                    'type' => 'success',
                    'text' => 'Calendar was synced.'
                ]);
        **/

   }


   public function listEvents()
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $user_id = Auth::id();
        $calendar_ids = Calendar::where('user_id', $user_id)
            ->pluck('calendar_id')
            ->toArray();
        $termine = ToDoModel::whereIn('calendar_id', $calendar_ids)
            ->get();


        $data = [];
            foreach ($termine as $event) {
                if($event->allday == 1) { 
                    $allday = true; } else { $allday = false; }
                $subArr=[
                    'id'=>$event->event_id,
                    'title'=>$event->title,
                    'start'=>$event->datetime_start,
                    'end'=>$event->datetime_end,
                    'allDay'=>$allday
                ];
                if ($event->recurring == 1) {
                    if (strpos($event->title, "Arbeit (easyLife)") !== false) {
                        $subArr['dow']=[1, 2, 3, 4, 5];
                    } else {
                        $subArr['dow']=[0,1,2,3,4,5,6];
                    }
                }
                array_push($data,$subArr);
            }

        $page_data = [
            'events' => $termine
        ];

        return $data;
   }

   public function getFreeBusy(Request $request)
   {
        /*
        $calendarService = new Google_Service_Calendar_FreeBusyRequest();
        $item = new Google_Service_Calendar_FreeBusyRequestItem();

        $calendarId = Calendar::where('user_id', $userId)->first()->calendar_id;
        //$freeBusyClient->setId($calendarId);

        $item->setId($calendarId);
        $result = $calendarService->freebusy->query($freebusy_req);*/
        $service = new Google_Service_Calendar($this->client);
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $userId = Auth::id();
        $calendarId = Calendar::where('user_id', $userId)->first()->calendar_id;

        $date_from = Carbon::now()->toRfc3339String();
        $date_to = Carbon::now()->addDays(7)->toRfc3339String();

        $freebusy_req = new Google_Service_Calendar_FreeBusyRequest();
        $freebusy_req->setTimeMin($date_from);
        $freebusy_req->setTimeMax($date_to);
        $freebusy_req->setTimeZone(env('APP_TIMEZONE'));

        //dd($freebusy_req);

        $item = new Google_Service_Calendar_FreeBusyRequestItem();
        $item->setId($calendarId);

        $freebusy_req->setItems(array($item));

        $query = $service->freebusy->query($freebusy_req);

        $response_calendar = $query->getCalendars();

        //$busy = $response_calendar->$calendarId;

        $response_calendar = $service->freebusy->query($freebusy_req)->getCalendars();

        $busy = $response_calendar[$calendarId]->getBusy();
        //dd($busy);

        $freeTime = array();
        $freeTimeStart = array();

        $busyStart = Carbon::parse($busy[0]->getStart());
        $queryStart = Carbon::parse($date_from);

        if ($busyStart > $queryStart) {
            $ft = $busyStart->diffInMinutes($queryStart);
            array_push($freeTime,$ft);
            array_push($freeTimeStart,$queryStart);
        }

        for ($i=1; $i < count($busy) ; $i++) { 
            $end = Carbon::parse($busy[$i]->getStart());
            $start = Carbon::parse($busy[$i-1]->getEnd());
            $ft = $end->diffInMinutes($start);
            array_push($freeTime,$ft);
            array_push($freeTimeStart,$start);
        }

        

        for ($i=0; $i < count($freeTime); $i++) { 

            $collection = $this->plan($freeTime[$i]);
            $timeSpent = 0;
            foreach ($collection as $todo) {
                $title = $todo->title;
                $desc = $todo->description;
                $start = Carbon::parse($freeTimeStart[$i])->addMinutes($timeSpent);
                //$duration = $todo->duration;
                $end = Carbon::parse($start)->addMinutes($todo->duration);
                //dd($start,$end);
                $calendar = $calendarId;

                $this->store($title,$desc,$start,$end,$calendar);
                $timeSpent+=$todo->duration;
                
            }
        }

        return response()->json();
   }

   public function plan($freeTime) 
   {
        $id = Auth::id();

        $todos = ToDoModel::where('userId', $id)->get();

        $nichtgeplanteTodos = $todos->where('scheduled', 0)->where('completed', 0)->where('allday',0);
        $title = $nichtgeplanteTodos->pluck('title')->toArray();
        $duration = $nichtgeplanteTodos->pluck('duration')->toArray();
        //$prio = $nichtgeplanteTodos->pluck('priority')->toArray();
        $prio = $nichtgeplanteTodos->pluck('priority')->map(function ($item) {
           return 5-$item;
        })->toArray();
        $id = $nichtgeplanteTodos->pluck('id')->toArray();
        

        $i = count($duration) -1;
        $memo = array();

        $pickedItems = array();

        list ($res,$pickedItems) = $this->doPlan($duration, $prio, $i, $freeTime, $memo);
         
        $collection = collect();
        foreach ($pickedItems as $item) {
            $todo = ToDoModel::where('id', $id[$item])->first();
            $todo->scheduled = 1;
            $todo->save();
            $collection->push($todo);
        }
        return $collection;
   }

   public function doPlan($duration, $prio, $i, $freeTime, $memo) 
   {
        if (isset($memo[$i][$freeTime])) {
            return array($memo[$i][$freeTime], $m['picked'][$i][$freeTime]);
        } else {

            if ($i == 0) {
                if ($duration[$i] <= $freeTime) {
                    $memo[$i][$freeTime] = $prio[$i];
                    $m['picked'][$i][$freeTime] = array($i);
                    return array($prio[$i],array($i));
                } else {
                    $memo[$i][$freeTime] = 0;
                    $m['picked'][$i][$freeTime] = array();
                    return array(0,array());
                }
            }

            list($without_i, $without_PI) = $this->doPlan($duration, $prio, $i-1, $freeTime, $memo);
            
            if ($duration[$i] > $freeTime) {
                $memo[$i][$freeTime] = $without_i;
                $memo['picked'][$i][$freeTime] = $without_PI;
                return array($without_i, $without_PI);
            } else {
                list($with_i,$with_PI) = $this->doPlan($duration, $prio, ($i-1), ($freeTime - $duration[$i]), $memo);
                $with_i += $prio[$i];

                if ($with_i > $without_i) {
                    $res = $with_i;
                    $picked = $with_PI;
                    array_push($picked,$i);
                } else {
                    $res = $without_i;
                    $picked = $without_PI;
                }

                $memo[$i][$freeTime] = $res;
                $memo['picked'][$i][$freeTime] = $picked;

                return array($res,$picked);
            }
        }

    }

    public function saveLifestyle()
    {
        $user = Auth::user();
        $service = new Google_Service_Calendar($this->client);
        $this->client->setAccessToken($user->gcalendar_credentials);
        $calendar_id = Calendar::where('user_id', $user->id)->first()->calendar_id;
        $cal = new \Google_Service_Calendar($this->client);
        $transparency = "opaque";
        $recurrenceDaily = array("RRULE:FREQ=DAILY");
        $recurrenceWeekdays = array("RRULE:FREQ=WEEKLY;BYDAY=MO,TU,WE,TH,FR");
        $base_timezone = env('APP_TIMEZONE');
        $today = Carbon::now();
        //work

            $work = new \Google_Service_Calendar_Event();

            $work->setSummary("Arbeit (easyLife)");
            $work->setTransparency($transparency);
            $work->setRecurrence($recurrenceWeekdays);

            $workBegin = Carbon::createFromFormat("H:i:s", $user->workingBegin)->nextWeekday();
            $workEnd = Carbon::parse($workBegin)->addMinutes($user->workingHours);
            
            $startWork = new \Google_Service_Calendar_EventDateTime();
            $startWork->setDateTime($workBegin->toRfc3339String());
            $startWork->setTimeZone($base_timezone);
            $work->setStart($startWork);
            //dd($work);

            $endWork = new \Google_Service_Calendar_EventDateTime();
            $endWork->setDateTime($workEnd->toRfc3339String());
            $endWork->setTimeZone($base_timezone);
            $work->setEnd($endWork);
            //dd($work);

            $cal->events->insert($calendar_id, $work);


        //drive to work

            $driveTW = new \Google_Service_Calendar_Event();

            $driveTW->setSummary("Fahrt zur Arbeit (easyLife)");
            $driveTW->setTransparency($transparency);
            $driveTW->setRecurrence($recurrenceWeekdays);

            $driveTWEnd = $workBegin;
            $driveTWBegin = Carbon::parse($workBegin)->subMinutes($user->drive);

            $startDriveTW = new \Google_Service_Calendar_EventDateTime();
            $startDriveTW->setDateTime($driveTWBegin->toRfc3339String());
            $startDriveTW->setTimeZone($base_timezone);
            $driveTW->setStart($startDriveTW);

            $endDriveTW = new \Google_Service_Calendar_EventDateTime();
            $endDriveTW->setDateTime($driveTWEnd->toRfc3339String());
            $endDriveTW->setTimeZone($base_timezone);
            $driveTW->setEnd($endDriveTW);
            
            $cal->events->insert($calendar_id, $driveTW);

        //drive from work

            $driveFW = new \Google_Service_Calendar_Event();

            $driveFW->setSummary("Fahrt von der Arbeit (easyLife)");
            $driveFW->setTransparency($transparency);
            $driveFW->setRecurrence($recurrenceWeekdays);

            $driveFWBegin = $workEnd;
            $driveFWEnd = Carbon::parse($workEnd)->addMinutes($user->drive);

            $startDriveFW = new \Google_Service_Calendar_EventDateTime();
            $startDriveFW->setDateTime($driveFWBegin->toRfc3339String());
            $startDriveFW->setTimeZone($base_timezone);
            $driveFW->setStart($startDriveFW);

            $endDriveFW = new \Google_Service_Calendar_EventDateTime();
            $endDriveFW->setDateTime($driveFWEnd->toRfc3339String());
            $endDriveFW->setTimeZone($base_timezone);
            $driveFW->setEnd($endDriveFW);

            $cal->events->insert($calendar_id, $driveFW);


        //breakfast

            $breakfast = new \Google_Service_Calendar_Event();

            $breakfast->setSummary("Frühstück (easyLife)");
            $breakfast->setTransparency($transparency);
            $breakfast->setRecurrence($recurrenceDaily);

            $breakfastEnd = Carbon::parse($driveTWBegin);
            $breakfastBegin = Carbon::parse($driveTWBegin)->subMinutes($user->breakfast);

            $startBreakfast = new \Google_Service_Calendar_EventDateTime();
            $startBreakfast->setDateTime($breakfastBegin->toRfc3339String());
            $startBreakfast->setTimeZone($base_timezone);
            $breakfast->setStart($startBreakfast);

            $endBreakfast = new \Google_Service_Calendar_EventDateTime();
            $endBreakfast->setDateTime($breakfastEnd->toRfc3339String());
            $endBreakfast->setTimeZone($base_timezone);
            $breakfast->setEnd($endBreakfast);

            $cal->events->insert($calendar_id, $breakfast);


        //morningtime

            $morningTime = new \Google_Service_Calendar_Event();

            $morningTime->setSummary("Morgenroutine (easyLife)");
            $morningTime->setTransparency($transparency);
            $morningTime->setRecurrence($recurrenceDaily);

            $morningTimeEnd = Carbon::parse($breakfastBegin);
            $morningTimeBegin = Carbon::parse($breakfastBegin)->subMinutes($user->morningTime);

            $startMorningTime = new \Google_Service_Calendar_EventDateTime();
            $startMorningTime->setDateTime($morningTimeBegin->toRfc3339String());
            $startMorningTime->setTimeZone($base_timezone);
            $morningTime->setStart($startMorningTime);

            $endMorningTime = new \Google_Service_Calendar_EventDateTime();
            $endMorningTime->setDateTime($morningTimeEnd->toRfc3339String());
            $endMorningTime->setTimeZone($base_timezone);
            $morningTime->setEnd($endMorningTime);

            $cal->events->insert($calendar_id, $morningTime);

        //sleep

            $sleep = new \Google_Service_Calendar_Event();

            $sleep->setSummary("Schlaf (easyLife)");
            $sleep->setTransparency($transparency);
            $sleep->setRecurrence($recurrenceDaily);

            $sleepEnd = Carbon::parse($morningTimeBegin);
            $sleepBegin = Carbon::parse($morningTimeBegin)->subMinutes($user->sleephours);

            $startSleep = new \Google_Service_Calendar_EventDateTime();
            $startSleep->setDateTime($sleepBegin->toRfc3339String());
            $startSleep->setTimeZone($base_timezone);
            $sleep->setStart($startSleep);

            $endSleep = new \Google_Service_Calendar_EventDateTime();
            $endSleep->setDateTime($sleepEnd->toRfc3339String());
            $endSleep->setTimeZone($base_timezone);
            $sleep->setEnd($endSleep);

            $cal->events->insert($calendar_id, $sleep);

        //eveningtime

            $eveningTime = new \Google_Service_Calendar_Event();

            $eveningTime->setSummary("Abendroutine (easyLife)");
            $eveningTime->setTransparency($transparency);
            $eveningTime->setRecurrence($recurrenceDaily);

            $eveningTimeEnd = Carbon::parse($sleepBegin);
            $eveningTimeBegin = Carbon::parse($sleepBegin)->subMinutes($user->eveningTime);

            $startEveningTime = new \Google_Service_Calendar_EventDateTime();
            $startEveningTime->setDateTime($eveningTimeBegin->toRfc3339String());
            $startEveningTime->setTimeZone($base_timezone);
            $eveningTime->setStart($startEveningTime);

            $endEveningTime = new \Google_Service_Calendar_EventDateTime();
            $endEveningTime->setDateTime($eveningTimeEnd->toRfc3339String());
            $endEveningTime->setTimeZone($base_timezone);
            $eveningTime->setEnd($endEveningTime);

            $cal->events->insert($calendar_id, $eveningTime);

        //dinner
            $dinner = new \Google_Service_Calendar_Event();

            $dinner->setSummary("Abendessen (easyLife)");
            $dinner->setTransparency($transparency);
            $dinner->setRecurrence($recurrenceDaily);

            $dinnerBegin = Carbon::createFromFormat("H:i:s", $user->dinnertime);
            $dinnerEnd = Carbon::parse($dinnerBegin)->addMinutes($user->dinner);

            $dinnerDuration = $user->dinner;
            $availableDinnerTime = $dinnerBegin->diffInMinutes($eveningTimeBegin);

            if ($availableDinnerTime < $dinnerDuration) {
                $dinnerBegin = $dinnerBegin->subMinutes($dinnerDuration-$availableDinnerTime);
                $dinnerEnd = $dinnerEnd->subMinutes($dinnerDuration-$availableDinnerTime);
            }

            $startDinner = new \Google_Service_Calendar_EventDateTime();
            $startDinner->setDateTime($dinnerBegin->toRfc3339String());
            $startDinner->setTimeZone($base_timezone);
            $dinner->setStart($startDinner);

            $endDinner = new \Google_Service_Calendar_EventDateTime();
            $endDinner->setDateTime($dinnerEnd->toRfc3339String());
            $endDinner->setTimeZone($base_timezone);
            $dinner->setEnd($endDinner);

            $cal->events->insert($calendar_id, $dinner);
    }
}
