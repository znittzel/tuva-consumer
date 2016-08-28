<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Http\Request;

Route::get('/', function() {
	return view('welcome');
});

Route::get('/connect', function () {
	echo 'was here';

	$query = http_build_query([
			'client_id' => 7,
			'redirect_uri' => 'http://localhost:81/callback',
			'response_type' => 'code',
			'scope' => ''
		]);

	return redirect('http://192.168.1.68:8000/oauth/authorize?'.$query);
});


Route::get('/callback', function(Request $request) {
	$http = new GuzzleHttp\Client;

	var_dump($request->code);

	$response = $http->post('http://192.168.1.68:8000/oauth/token', [
			'form_params' => [
				'grant_type' => 'authorization_code',
				'client_id' => 7,
				'client_secret' => '0KeJsMGCSh2yme2HmhnYzn0lDvK4GY2XduIdlrVu',
				'redirect_uri' => 'http://localhost:81/callback',
				'code' => $request->code
			]
		]);

	return json_decode((string) $response->getBody(), true);
});