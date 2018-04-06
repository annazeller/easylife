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
        // Set state allows us to match the consent to a specific user
        $client->setState(Auth::id());
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
        session_start();

        $user = Auth::user();

        $gcalendar_integration_active = $user->gcalendar_integration_active;
        $gcalendar_credentials = $user->gcalendar_credentials;



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

            $results = $service->events->listEvents($calendarId);
            return $results->getItems();
        } else {
            return redirect()->route('oauthCallback');
        }

    }
    
    public function oauth(Request $request)
    {
        
        session_start();
        $input = $request->all();

        $user = $request->user();

        if (! isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);

        } else {

            $this->client->authenticate($_GET['code']);
            $accessToken = $this->client->getAccessToken();

            $user->update([
                'gcalendar_credentials' => json_encode($accessToken),
                'gcalendar_integration_active' => true,
            ]);
        

            return redirect()->route('cal.index');
        }

    }

