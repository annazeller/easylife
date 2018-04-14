<?php
/**
 * Created by Pia Freilinger.
 * Date: 05.04.2018
 */
namespace App\Http\Controllers;

use App\ToDoModel;
use Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ToDoController extends Controller
{
    public function index(){

        if(Auth::check()) {
            $user = Auth::user();
            $uid = $user->id;

            $todos = ToDoModel::where('userid', $uid)->get();

            return View::make('aufgaben')->with('todos', $todos);
        }
        else
        {
            return Redirect::to('/');
        }

    }

    public function create()
    {
        if(Auth::check()) {
            return View::make('create');
        }
    }

    public function store(Request $r){
        if(Auth::check()) {
            $rules = array(
                'title' => 'required',
                'priority' => 'required',
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($r->duration_h == '00' && $r->duration_min == '00') {
                return Redirect::to('/home');
            }

            if ($validator->fails()) {
                return Redirect::to('/home')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                $user = Auth::user();

                $todo = new ToDoModel();
                $todo->title = $r->title;
                $todo->description = $r->description;
                $todo->location = $r->location;
                $todo->priority = $r->priority;

                $stunden = $r->duration_h;
                $minuten = $r->duration_min;

                $dauer = ($stunden * 60 ) + $minuten;

                $todo->duration = $dauer;

                $todo->userId = $user->id;
                $todo->save();

                return response()->json($todo);
            }
        }
    }

    public function update(Request $r, $id)
    {
        if(Auth::check()) {
            $rules = array(
                'title' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($r->duration_h == '00' && $r->duration_min == '00') {
                return Redirect::to('/home');
            }

            if ($validator->fails()) {
                return Redirect::to('/home')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                $todo = ToDoModel::find($id);
                $todo->title = $r->title;
                $todo->description = $r->description;
                $todo->location = $r->location;
                $todo->priority = $r->priority;
                $stunden = $r->duration_h;
                $minuten = $r->duration_min;

                $dauer = ($stunden * 60 ) + $minuten;

                $todo->duration = $dauer;
                $todo->save();

                return response()->json($todo);
            }
        }
    }

    public function destroy(Request $r)
    {
        $elementid = $r->id;
        ToDoModel::find ( $elementid )->delete();

        return response()->json();
    }

    public function welcome()
    {
        if(Auth::check()) {
            return redirect()->route('index');
        }
        else
        {
            return View::make('welcome');
        }
    }

    public function ajaxDelete(Request $r)
    {
        $elementid = $r->id;
        ToDoModel::find ( $elementid )->delete();

        return response()->json();
    }

    public function checkToDo(Request $r)
    {
        $elementid = $r->id;
        $todo = ToDoModel::find($elementid);

        $currentstate = $todo->completed;

        if($currentstate == 0) {
            $todo->completed = 1;
        }
        elseif ($currentstate == 1)
        {
            $todo->completed = 0;
        }

        $todo->save();

        return response()->json($todo);
    }
}

