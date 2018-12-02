<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller{
    public function index(){
        return view('welcome', ['text'=>'Tarek']);
    }

    public function welcome(){
        return "Hello, Json";
    }
}
