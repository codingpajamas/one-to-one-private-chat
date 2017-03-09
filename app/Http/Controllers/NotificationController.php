<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests; 
use Illuminate\Support\Facades\App;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification');
    }

    public function notify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));
        
        // TODO: Get Pusher instance from service container
        $pusher = App::make('pusher');
        
        // TODO: The notification event data should have a property named 'text'
        $objNotifyData = array('text' => $notifyText);
        
        // TODO: On the 'notifications' channel trigger a 'new-notification' event
        $pusher->trigger( 'notifications', 'new-notification', $objNotifyData, $request->input('socket_id'));
    }
}
