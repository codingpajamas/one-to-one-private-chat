<?php

use Illuminate\Support\Facades\App;

  
Route::get('/bridge', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
                      'test-event', 
                      array('text' => 'Preparing the Pusher Laracon.eu workshop!'));

    return view('welcome');
});




/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();

	Route::get('/home', 'HomeController@index');
	
	Route::get('notifications', 'NotificationController@index');
	Route::post('notifications/notify', 'NotificationController@notify');

	Route::get('activities', 'ActivityController@index');
	Route::post('activities/status', 'ActivityController@status');
	Route::post('activities/like/{id}', 'ActivityController@like');

	Route::get('chat', 'ChatController@index');
	Route::post('chat/message', 'ChatController@message');
	Route::post('chat/auth', 'ChatController@auth');

	Route::get('messenger', 'MessengerController@index');
	Route::get('messenger/messages', 'MessengerController@messages');
	Route::get('messenger/t/{alias_name}', 'MessengerController@conversation');
	Route::post('messenger/send', 'MessengerController@send');
	Route::post('messenger/auth', 'MessengerController@auth');
	Route::post('messenger/history', 'MessengerController@history');
});


