<?php

namespace AntControl\Http\Controllers;

use Illuminate\Http\Request;

use AntControl\Http\Requests;

class IndexController extends Controller
{
    public function index(){
		return view('index');
	}


}
