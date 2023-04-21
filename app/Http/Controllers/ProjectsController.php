<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('createproject');
    }

    public function create(Request $request)
    {
        $input = [
            'name' => $request->name,
        ];
        
        $rules = [
            'name' => 'required|min:4',
            
        ];

        $messages = [

            'min' => 'Project name must be at least 4 characters long',
            'required' => ' Project name is required',
            
        ];
        $validator = Validator::make($input, $rules, $messages);
        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $path = "projects/" . rand(1,10) . ".png";
        $project = Project::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'profile' => $path,
            
            ]);
        return redirect('/home');
   
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('editproject')->with('project', $project);
    }

    public function delete($id)
    {
        
        $deleted = Project::find($id);
        if ($deleted->user_id == Auth::user()->id)
        {$deleted->delete();}
        return redirect('/home');
    }

    public function gui($id)
    {
        $project = Project::find($id);
        return view('gui')->with('project', $project);
    }
    public function guie()
    {
          return view('engine');
    }

    public function simulate()
    {
        
        return view('controlsys');
    }

    public function design()
    {
        
        return view('simpleDesign');
    }


    public function simple()
    {
        
        return view('transferFunction');
    }
    public function update($id, Request $request)
    {
        $input = [
            'name' => $request->name,
        ];
        
        $rules = [
            'name' => 'required|min:4',
            
        ];

        $messages = [

            'min' => 'Project name must be at least 4 characters long',
            'required' => ' Project name is required',
            
        ];
        $validator = Validator::make($input, $rules, $messages);
        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }


        Project::where('id', $id)->update(['name' => $request->name]);
        return Redirect::back();
    }
}
