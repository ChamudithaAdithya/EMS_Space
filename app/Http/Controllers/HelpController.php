<?php

// @ DESCRIPTION      => help 
// @ ENDPOINT         => helpDoc.php
// @ ACCESS           => all members in space section
// @ CREATED BY       => Harindu Ashen
// @ CREATED DATE     => 2024/06/26 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function help(){
        return view('pages.Help.helpDoc');
    }
    
}