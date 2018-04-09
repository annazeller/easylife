<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\GoogleClientHelper;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
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
            $calendarId = Auth::user()->default_calendar; //to do: default calendar field setzen
            $calendarId = 'primary'; //to do: löschen, testing

            $optParams = array(
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => '2017-06-03T10:00:00-07:00',
                'timeMax' => '2019-06-03T10:00:00-23:00',
            );

            // fullcalendar construction
            $result=$service->events->listEvents($calendarId, $optParams);
            $events=$result->getItems();
            $data =[];
            foreach ($events as $event) {
                $subArr=[
                    'id'=>$event->id,
                    'title'=>$event->getSummary(),
                    'start'=>$event->getStart()->getDateTime(),
                    'end'=>$event->getEnd()->getDateTime(),
                ];
                array_push($data,$subArr);
            }


            // Check ob es Events gibt
            if (count($result->getItems()) > 0) {
                //Return wenn es Einträge gibt, die den Params entsprechen
                return $data;
            } else {
                // TO DO: Return wenn es keine Einträge gibt
                return dd($user); 
            }
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

            //$this->savePrimaryCalendar();

            return redirect()->route('dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.createEvent');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session_start();
        $startDateTime = $request->start_date;
        $endDateTime = $request->end_date;

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
            
            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $request->title,
                'description' => $request->description,
                'start' => ['dateTime' => $startDateTime],
                'end' => ['dateTime' => $endDateTime],
                'reminders' => ['useDefault' => true],
            ]);
            $results = $service->events->insert($calendarId, $event);
            if (!$results) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
            return response()->json(['status' => 'success', 'message' => 'Event Created']);

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

    public function createCalendar(Request $request)
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        return view('calendar.create_calendar');
   }


   public function doCreateCalendar(Request $request, Calendar $calendar)
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $this->validate($request, [
            'title' => 'required|min:4'
        ]);

        $title = $request->input('title');
        $timezone = env('APP_TIMEZONE');

        $cal = new \Google_Service_Calendar($this->client);

        $google_calendar = new \Google_Service_Calendar_Calendar($this->client);
        $google_calendar->setSummary($title);
        $google_calendar->setTimeZone($timezone);

        $created_calendar = $cal->calendars->insert($google_calendar);

        $calendar_id = $created_calendar->getId();

        $calendar->user_id = Auth::id();
        $calendar->title = $title;
        $calendar->calendar_id = $calendar_id;
        $calendar->sync_token = '';
        $calendar->save();

        return redirect('/calendar/create')
            ->with('message', [
                'type' => 'success', 'text' => 'Calendar was created!'
            ]);
   }

   public function savePrimaryCalendar()
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $title = "Primärkalender";

        $service = new Google_Service_Calendar($this->client);
        $primaryCalendar = $service->calendarList->get('primary');

        $calendar_id = $primaryCalendar->getId();

        $calendar = new Calendar;
        $calendar->user_id = Auth::id();
        $calendar->title = $title;
        $calendar->calendar_id = $calendar_id;
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


   public function doCreateEvent(Event $evt, Request $request)
   {
        $this->client->setAccessToken(Auth::user()->gcalendar_credentials);
        $this->validate($request, [
            'title' => 'required',
            'calendar_id' => 'required',
            'datetime_start' => 'required|date',
            'datetime_end' => 'required|date'
        ]);

        $title = $request->input('title');
        $calendar_id = $request->input('calendar_id');
        $start = $request->input('datetime_start');
        $end = $request->input('datetime_end');

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

        //attendee
        if ($request->has('attendee_name')) {
            $attendees = [];
            $attendee_names = $request->input('attendee_name');
            $attendee_emails = $request->input('attendee_email');

            foreach ($attendee_names as $index => $attendee_name) {
                $attendee_email = $attendee_emails[$index];
                if (!empty($attendee_name) && !empty($attendee_email)) {
                    $attendee = new \Google_Service_Calendar_EventAttendee();
                    $attendee->setEmail($attendee_email);
                    $attendee->setDisplayName($attendee_name);
                    $attendees[] = $attendee;
                }
            }

            $event->attendees = $attendees;
        }

        $created_event = $cal->events->insert($calendar_id, $event);

        $evt->title = $title;
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
        $this->validate($request, [
            'calendar_id' => 'required'
        ]);

        $user_id = Auth::id();
        $calendar_id = $request->input('calendar_id');    

        $calendar_ids = Calendar::where('user_id', $user_id)
            ->pluck('calendar_id')
            ->toArray();   
        
        $base_timezone = env('APP_TIMEZONE');

        $calendars = Calendar::whereIn('calendar_id', $calendar_ids)->get();

        foreach($calendars as $calendar) {
            
            $sync_token = $calendar->sync_token;

            $gCalendarId = $calendar->calendar_id;

            $gServiceCal = new \Google_Service_Calendar($this->client);
            $gCalendar = $gServiceCal->calendars->get($gCalendarId);
            $calendar_timezone = $gCalendar->getTimeZone();

            $termine = ToDoModel::where('calendar_id', $calendar_id)
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

                        if (!$g_event->getStart()->getDateTime) {
                            $g_datetime_start = Carbon::parse($g_event->getStart()->getDate())
                                ->tz($calendar_timezone)
                                ->setTimezone($base_timezone)
                                ->format('Y-m-d H:i:s');
                        } else {
                            $g_datetime_start = Carbon::parse($g_event->getStart()->getDateTime())
                                ->tz($calendar_timezone)
                                ->setTimezone($base_timezone)
                                ->format('Y-m-d H:i:s');
                        }

                        if (!$g_event->getEnd()->getDateTime) {
                            $g_datetime_end = Carbon::parse($g_event->getEnd()->getDate())
                                ->tz($calendar_timezone)
                                ->setTimezone($base_timezone)
                                ->format('Y-m-d H:i:s');
                        } else {
                            $g_datetime_end = Carbon::parse($g_event->getEnd()->getDateTime())
                                ->tz($calendar_timezone)
                                ->setTimezone($base_timezone)
                                ->format('Y-m-d H:i:s');
                        }

                        //check if event id is already in the events table
                        if (in_array($g_event_id, $termine)) {
                            //update event

                            $event = ToDoModel::where('event_id', $g_event_id)->first();
                            $event->title = $g_event_title;
                            $event->calendar_id = $gCalendarId;
                            $event->event_id = $g_event_id;
                            $event->datetime_start = $g_datetime_start;
                            $event->datetime_end = $g_datetime_end;
                            $event->save();
                        } else {
                            //add event
                            $event = new Event;
                            $event->title = $g_event_title;
                            $event->calendar_id = $gCalendarId;
                            $event->event_id = $g_event_id;
                            $event->datetime_start = $g_datetime_start;
                            $event->datetime_end = $g_datetime_end;
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
                    $calendar = Calendar::where('calendar_id', $calendar_id)->first();
                    $calendar->sync_token = $next_synctoken;
                    $calendar->save();

                    break;
                }

            }
        }
        $message = [
                    'type' => 'success',
                    'text' => 'Calendar was synced.'
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


        $data =[];
            foreach ($termine as $event) {
                $subArr=[
                    'id'=>$event->event_id,
                    'title'=>$event->title,
                    'start'=>$event->datetime_start,
                    'end'=>$event->datetime_end,
                ];
                array_push($data,$subArr);
            }

        $page_data = [
            'events' => $termine
        ];

        return $data;
   }
}
