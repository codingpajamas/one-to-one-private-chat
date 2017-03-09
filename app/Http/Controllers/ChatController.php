<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

use App\Http\Requests;
use Auth;


class ChatController extends Controller
{
    public $pusher;
    public $user;
    public $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'private-chat';

    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->user = Auth::user();
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
    }

    public function index()
    {
        if(!$this->user)
        {
            return redirect('login');
        }
        return view('chat', ['chatChannel' => $this->chatChannel]);
    }

    public function message(Request $request)
    {
        $message = [
            'text' => e($request->input('chat_text')),
            'username' => $this->user->name,
            'timestamp' => (time()*1000)
        ];
        $this->pusher->trigger($this->chatChannel, 'new-message', $message);
    }

    public function auth(Request $request)
	{
		if(!$this->user)
        {
            header('', true, 403);
  			echo "Forbidden";
        }

        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name'); 
        $auth = $this->pusher->socket_auth($channelName, $socketId);

        echo $auth;
	}
}
