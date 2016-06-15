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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/home', 'HomeController@index');


Route::get('/summoner','SummonerController@mySummoner');


//DEV 
Route::get('/flush', function(){ //FLUSHES SESSIONS
	Session::flush();
	return redirect()->back();
});

Route::get('/static/seed/champions', function(){
	$url = 'https://global.api.pvp.net/api/lol/static-data/lan/v1.2/champion?api_key=844dbefd-2dcc-420c-9f3a-4095fde86813';
	$response = file_get_contents($url);
    $champions =  json_decode($response);

   // dd($champions->data);

    foreach ($champions->data as $champion) {
    	$insert = new \App\Champion;
    	$insert->id = $champion->id;
    	$insert->name = $champion->name;
    	$insert->save();
    }
    return redirect()->to('/');
});