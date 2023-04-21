<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home() {
        $id = Auth::user()->id;
        $projects = User::find($id)->projects;         
        return view('home')->with(compact('projects'));
        
    }

    public function profile() 
    {
        $projectnum = User::find(Auth::user()->id)->projects->count();
        
        return view('profile')->with(compact('projectnum'));
    }
}
