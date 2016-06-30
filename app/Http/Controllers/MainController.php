<?php

namespace AntControl\Http\Controllers;

use Illuminate\Http\Request;

use AntControl\Http\Requests;

class MainController extends Controller
{
    public function index(){
		view('index');
	}
}
