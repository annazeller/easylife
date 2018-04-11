<?php
/**
 * Created by PhpStorm.
 * User: Pia
 * Date: 11.04.2018
 * Time: 10:33
 */

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class easyLifeQuestionController
{
    public function setEasyLifequestions(Request $r){
        //$user = Auth::user();

        $user = User::find(2);

        $sleephours = ($r->sleepHours_h * 60 ) + $r->sleepHours_min;
        $user->sleephours = $sleephours;

        $morningtime= ($r->morningTime_h * 60 ) + $r->morningTime_min;
        $user->morningTime = $morningtime;

        $eveningTime= ($r->eveningTime_h * 60 ) + $r->eveningTime_min;
        $user->eveningTime = $eveningTime;

        $workingHours = ($r->workingHours_h * 60 ) + $r->workingHours_min;
        $user->workingHours = $workingHours;

        $breakfast = ($r->breakfast_h * 60 ) + $r->breakfast_min;
        $user->breakfast = $breakfast;

        $dinner = ($r->dinner_h * 60 ) + $r->dinner_min;
        $user->dinner = $dinner;

        $drive = ($r->drive_h * 60 ) + $r->drive_min;
        $user->drive = $drive;

        $user->workingBegin = $r->workingBegin_h . ':' . $r->workingBegin_min . ':00';
        $user->dinnertime =  $r->dinner_time_h . ':' . $r->dinner_time_min . ':00';

        $user->save();
        return response()->json();
    }
}