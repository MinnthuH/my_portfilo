<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    // home route
    public function homePage(){
        return view('frontend.index');
    }
}
