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

    public function store(){
        if(Auth::check()) {
            $rules = array(
                'title' => 'required',
                'priority' => 'required',
                'duration' => 'required',
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::to('/index.php/home/create')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                $user = Auth::user();

                $todo = new ToDoModel();
                $todo->title = Input::get('title');
                $todo->description = Input::get('description');
                $todo->location = Input::get('location');
                $todo->priority = Input::get('priority');
                $todo->duration = Input::get('duration');;

                $todo->userId = $user->id;
                $todo->save();

                return Redirect::to('home');
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

    public function update($id)
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
                $todo->title = Input::get('title');
                $todo->description = Input::get('description');
                $todo->location = Input::get('location');
                $todo->priority = Input::get('priority');
                $todo->duration = Input::get('duration');
                $todo->save();

                return Redirect::to('home');
            }
        }
    }

    public function destroy($id)
    {
        if(Auth::check()) {
            $todo = ToDoModel::find($id);
            $todo->delete();

            return Redirect::to('home');
        }
    }

    public function ajaxDelete(Request $r)
    {
        $elementid = $r->id;
        ToDoModel::find ( $elementid )->delete();

        return response()->json();
    }
}

