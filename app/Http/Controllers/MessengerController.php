<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

use App\Http\Requests;
use Auth;

use App\Channel as Channel;
use App\Conversation as Conversation;

class MessengerController extends Controller
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

        return view('messenger');
    }

    public function messages()
    {
    	// http://stackoverflow.com/questions/27375125/pusher-one-to-one-chat-structure
    	// http://stackoverflow.com/questions/31266170/pusher-client-events-triggering-for-user
    	
        // check request('rid', '');
        // get Auth::user()->id; 

        $intReceiverId = (int) request('rid', 0); // check if user ID exist, if not display a no user found view
        $intSenderId = Auth::user()->id;

        if($intReceiverId != 0)
        {
            // concatinate IDs to create channel name.
            // look that channel name in the database
            // if it exist, get the alias_name and redirect to 'messenger/t/{alias_name}'
            // if not, create it with receiver_status empty and redirect to 'messenger/t/{alias_name}'
            $channelName = $intReceiverId > $intSenderId ? 'private-chat-'.$intSenderId.'-'.$intReceiverId : 'private-chat-'.$intReceiverId.'-'.$intSenderId;
            
            $channel = Channel::where('channel_name', $channelName)->first();


            if($channel)
            {
                return redirect('messenger/t/'.$channel->alias_name); 
            }
            else
            {
                $newChannel = Channel::create([
                        'channel_name' =>$channelName, 
                        'alias_name' => rand(10000, 99999) . '-' . $intSenderId . '-' . $intReceiverId,
                        'sender_id' => $intSenderId, 
                        'receiver_id' => $intReceiverId, 
                        'sender_status' => 'opened', 
                        'receiver_status' => 'new'
                    ]);

                return redirect('messenger/t/'.$newChannel->alias_name); 
            } 
        }
        else
        {
            // look for database latest channel, 
            if(true)
            {
                //get that name and redirect to 'messenger/t/{channel_name}'
            }
        }

        // if no receiver id, and no latest messages, display no chats available view

        dd($channelName);
 
    }

    public function conversation($alias_name)
    {
    	// check if it exist alias name exist in database
        $channel = Channel::where('alias_name', $alias_name)->first();

        if(!$channel)
        { 
            return redirect('/messenger');
        }

        // check also if auth::user()->id is a sender or receiver
        if(Auth::user()->id != $channel->sender->id && Auth::user()->id != $channel->receiver->id)
        {
            return redirect('/messenger');
        }


        // channel and conversation object
        $objReceiverHere = Auth::user()->id == $channel->sender->id ? $channel->receiver : $channel->sender;
        $conversations = Conversation::where('channel_id', $channel->id)->orderBy('id', 'desc')->limit(10)->with('owner')->get()->reverse();
 

    	// get all channels for this Auth::user() in channels
    	// if Auth::user() is the receiver and receiver_status is empty, remove it
        $arrUserChannels = Channel::where('sender_id', Auth::user()->id)
                                ->orWhere('receiver_id', Auth::user()->id)
                                ->get();
 

        $arrUserChannels->map(function($objChannel, $key){
            $objChannel['talking_to_name'] = Auth::user()->id == $objChannel->sender_id ? $objChannel->receiver->name : $objChannel->sender->name;
            $objChannel['talking_to_id'] = Auth::user()->id == $objChannel->sender_id ? $objChannel->receiver_id : $objChannel->sender_id;
            return $objChannel;
        });


    	// display in view
        return view('messenger-message', ['arrUserChannels'=>$arrUserChannels, 'channel'=>$channel, 'objReceiverHere'=>$objReceiverHere, 'conversations'=>$conversations]);
    }

    public function send(Request $request)
    {
        // 'an' = alias_name;
        // 'm' = message;
        // 'rid' = receiver_id
        $channel = Channel::where('alias_name', $request->input('an', ''))->first();
        
        if($channel)
        {
            // create new conversation
            $conversation = Conversation::create([
                    'channel_id'=>$channel->id,
                    'user_id'=>Auth::user()->id,
                    'body'=>$request->input('m')
                ]);

            // if created send trigger to pusher
            if($conversation)
            { 
                $message = [
                    'message' => $conversation->body,
                    'un' => $this->user->name,
                    'ui' => $this->user->id,
                    'timestamp' => (time()*1000)
                ];
                $this->pusher->trigger($channel->channel_name, 'new-message', $message);

                $this->pusher->trigger('notifications-'.$request->input('rid', 'null'), 'new-message-alert', $message);
            }
        } 
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

        if($channelName == 'presence-chat')
        { 
        	$presenceData = array('name' => $this->user->name, 'uid' => $this->user->id);
        	$auth = $this->pusher->presence_auth($channelName, $socketId, $this->user->id, $presenceData);
        }
        else
        {
        	$auth = $this->pusher->socket_auth($channelName, $socketId);
        }


        echo $auth;
	}

    public function history(Request $request)
    {
        $strChannelId = $request->input('chid');
        $intEndId = $request->input('cnid');

        $conversations = Conversation::where('channel_id', $strChannelId)
                                ->where('id', '<', $intEndId)
                                ->orderBy('id', 'desc')
                                ->limit(10)
                                ->with('owner')
                                ->get()
                                ->toJson(); 

        return $conversations;
    }
}
