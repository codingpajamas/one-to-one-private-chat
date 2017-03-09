<html>
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title>Pusher Messenger</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<style>
		.chat-onlines {
			border-top: 1px solid rgba(0,0,0,0.1);
		}
		.chat-onlines li a {
			padding: 5px 10px;
			border-bottom: 1px solid rgba(0,0,0,0.1);
			color: #999; 
			text-decoration: none !important;
			display: block;
		} 
	</style>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.rawgit.com/samsonjs/strftime/master/strftime-min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    <script src="/bootstrap.min.js"></script>

    <script> 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-9 col-md-10">
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						Dropdown
						<span class="caret"></span>
					</button>
					<ul id="notificationDropDown" class="dropdown-menu" aria-labelledby="dropdownMenu1"></ul>
				</div>
			</div>
			<div class="col-sm-3 col-md-2">
				<ul class="list-unstyled chat-onlines" id="chatOnlineBox"></ul>
			</div>
		</div>
	</div>

	<!-- Create the template for who's online -->
	<script id="chat_online_template" type="text/template">
	    <li><a href="messenger/messages"></a></li>
	</script>

	<!-- Create the template for new chat notification -->
	<script id="notif_chat_template" type="text/template">
	    <li><a href></a></li> 
	</script>

	<script>
		var pusher = new Pusher('{{env("PUSHER_KEY")}}', {
	                    cluster: 'ap1',
	                    authEndpoint: '/messenger/auth',
	                    auth: {
	                        headers: {
	                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                        }
	                    }
	                });
	    
		// global presence 
	    var chatChannel = pusher.subscribe('presence-chat'); 

	    chatChannel.bind('pusher:subscription_succeeded', listOnlineMember);
	    chatChannel.bind('pusher:member_added', newOnlineMember);
	    chatChannel.bind('pusher:member_removed', removeOnlineMember);

	    function listOnlineMember(data){ 
        	$.each(data.members, function(key, member){ 
        		if(member.uid != data.myID){ 
			    	addOnlineMember(member.name, member.uid);
	        	}
        	}) 
	    }

	    function addOnlineMember(strUname, intUid){
	    	var strTemplate = $('#chat_online_template').text();
        	var elList = $(strTemplate);

    		elList.attr('id', 'user-online-'+intUid);
    		elList.find('a').attr('href', '/messenger/messages?rid='+intUid);
    		elList.find('a').text(strUname);
    		$('#chatOnlineBox').append(elList); 
	    }

	    function newOnlineMember(data){ 
	    	addOnlineMember(data.info.name, data.info.uid);
	    }

	    function removeOnlineMember(data){
	    	$('#user-online-'+data.id).remove();
	    }

	    // chat notifications alert
	    var notifications = pusher.subscribe( 'notifications-{{Auth::user()->id}}' );
	    notifications.bind('new-message-alert', newMessageReceived);

	    function newMessageReceived(data){
	    	var elChatAlert = $('#user-chat-alert-'+data.ui);
	    	 
	    	if(elChatAlert.length){
	    		// update timestamp in elChatAlert
	    	}else{
	    		console.log('new')
	    		var strTemplate = $('#notif_chat_template').text();
	        	var elNewChatAlert = $(strTemplate);

	    		elNewChatAlert.attr('id', 'user-chat-alert-'+data.ui);
	    		elNewChatAlert.find('a').attr('href', '/messenger/messages?rid='+data.ui);
	    		elNewChatAlert.find('a').text(data.un + ' has a new message');
	    		$('#notificationDropDown').append(elNewChatAlert); 
	    	}

	    	// update bell and display red exclamation
	    }
	    
	</script>
</body>
</html>