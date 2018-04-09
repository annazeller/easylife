<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ToDoModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function googleLineChart()
    {
        $userId = Auth::id();
        $todos = ToDoModel::where('userId', $userId)->get();
        $anzahlErledigt = $todos->where('completed', 1)->count();
        $anzahlOffen = $todos->where('completed', 0)->count();
        $anzahlGeplant = $todos->where('scheduled', 1)->count();
        $anzahlUngeplant = $todos->where('scheduled', 0)->count();


        $result = array(
            'Erledigt' => $anzahlErledigt,
            'Offen' => $anzahlOffen,
            'Geplant' => $anzahlGeplant,
            'Ungeplant' => $anzahlUngeplant
        );

        return view('google-line-chart')
                ->with('result',json_encode($result));
    }
}