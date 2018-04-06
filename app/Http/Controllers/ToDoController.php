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
                'duration' => 'required',
            );

            $validator = Validator::make(Input::all(), $rules);

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
                $todo->duration = $r->duration;

                $todo->userId = $user->id;
                $todo->save();

                return response()->json($todo);
            }
        }
    }

    public function edit($id)
    {
        if(Auth::check()) {
            $todo = ToDoModel::find($id);

            return View::make('edit')
                ->with('todo', $todo);
        }
    }

    public function update(Request $r, $id)
    {
        if(Auth::check()) {
            $rules = array(
                'title' => 'required',
                'priority' => 'required',
                'duration' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::to('/home/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                $todo = ToDoModel::find($id);
                $todo->title = $r->title;
                $todo->description = $r->description;
                $todo->location = $r->location;
                $todo->priority = $r->priority;
                $todo->duration =  $r->duration;
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

    public function ajaxDelete(Request $r)
    {
        $elementid = $r->id;
        ToDoModel::find ( $elementid )->delete();

        return response()->json();
    }
}

