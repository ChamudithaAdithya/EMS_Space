<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Eventformcontroller extends Controller
{
    public function event()
    {
        return view('pages.space_event_type.space_eventform');
    }

    public function setting(){

        return view('user_profile.settings');
        
    }

}
