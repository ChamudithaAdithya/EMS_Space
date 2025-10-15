<?php

// @ DESCRIPTION      => reports
// @ ENDPOINT         => invitations.blade.php
// @ ACCESS           => all members in space section
// @ CREATED BY       => Harindu Ashen
// @ CREATED DATE     => 2024/06/27 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvitationController extends Controller
{
    public function invitation(){
        return view('pages.reports.invitations');
    }

    
}