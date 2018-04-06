<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Auth;
use App\User;

class gCalendarController extends Controller
{

    protected $client;

    public function __construct()
    {

        //Initialise the client
        $client = new Google_Client();
        // Set the application name, this is included in the User-Agent HTTP header.
        $client->setApplicationName('easyLife Calendar');
        // Set the authentication credentials we downloaded from Google.
        $client->setAuthConfig('client_id.json');
        // Setting offline here means we can pull data from the user's calendar when they are not actively using the site.
        $client->setAccessType("offline");
        // This will include any other scopes (Google APIs) previously granted by the user
        $client->setIncludeGrantedScopes(true);
        // Set this to force to consent form to display.
        $client->setApprovalPrompt('force');
        // Add the Google Calendar scope to the request.
        $client->addScope(Google_Service_Calendar::CALENDAR);
        // Set the redirect URL back to the site to handle the OAuth2 response. This handles both the success and failure journeys.
        $rurl = action('gCalendarController@oauth');
        $client->setRedirectUri($rurl);
        // The Google Client gives us a method for creating the 
        $client->createAuthUrl();

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);

        $this->client = $client;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            $calendarId = 'primary';

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


            // Check if we have any events returned
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
        

            return redirect()->route('cal.index');
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
}
