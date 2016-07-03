<?php

	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register all of the routes for an application.
	| It's a breeze. Simply tell Laravel the URIs it should respond to
	| and give it the controller to call when that URI is requested.
	|
	*/

	Route::group(['middleware' => 'auth.basic', 'as' => 'auth::'], function () {
		Route::get('/', ['uses' => 'IndexController@index', 'as' => 'index']);

		Route::get('miners', ['uses' => 'MinersController@index', 'as' => 'miners']);
		Route::get('miners/refreshHost', ['uses' => 'MinersController@refreshHosts', 'as' => 'miners.refresh.host']);

		Route::any('miners/refreshInfo', ['uses' => 'MinersController@refreshInfo', 'as' => 'miners.refresh.info'])->where(['id' => '[0-9]+']);
		
		Route::get('miners/switchHost', ['uses' => 'MinersController@switchHost', 'as' => 'miners.switch']);

	});


