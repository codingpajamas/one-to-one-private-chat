<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Auth;

class ActivityController extends Controller
{
    public $pusher;
    public $user;

    public function __construct()
    {
    	$this->pusher = App::make('pusher');
    	$this->user = Auth::user();
    }

    public function index()
    {
    	// If there is no user, redirect to login
    	if(!$this->user)
        {
        	return redirect('login');
        }

        // TODO: provide some useful text
        $activity = [
            'text' => $this->user->name . ' has visited the Activities page',
            'username' => $this->user->name,
            'id' => str_random()
        ];

        // TODO: trigger event
        $this->pusher->trigger('activities', 'user-visit', $activity);

        return view('activities');
    }

    public function status(Request $request)
    {
    	$statusText = e($request->input('status_text'));

    	// TODO: provide some useful text
        $status = [
            'text' => $statusText,
            'username' => $this->user->name,
            'id' => str_random()
        ];
      
        // TODO: trigger event
        $this->pusher->trigger('activities', 'new-status-update', $status);
    }

    public function like($id)
    {
    	// TODO: provide some useful text
        $liked = [ 
        	'text' => $this->user->name . ' liked a status update',
            'username' => $this->user->name,
            'id' => str_random(),
            'likedActivityId' => $id
        ];

    	// TODO: trigger event
    	$this->pusher->trigger('activities', 'status-update-liked', $liked);
    }

}
