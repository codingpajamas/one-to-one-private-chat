<html>
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title>Pusher Messenger</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<style>
		html,body {
		    height:100%;
		}
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
		



		 #custom-search-input {
  background: #e8e6e7 none repeat scroll 0 0;
  margin: 0;
  padding: 10px;
}
   #custom-search-input .search-query {
   background: #fff none repeat scroll 0 0 !important;
   border-radius: 4px;
   height: 33px;
   margin-bottom: 0;
   padding-left: 7px;
   padding-right: 7px;
   }
   #custom-search-input button {
   background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
   border: 0 none;
   border-radius: 3px;
   color: #666666;
   left: auto;
   margin-bottom: 0;
   margin-top: 7px;
   padding: 2px 5px;
   position: absolute;
   right: 0;
   z-index: 9999;
   }
   .search-query:focus + button {
   z-index: 3;   
   }
   .all_conversation button {
   background: #f5f3f3 none repeat scroll 0 0;
   border: 1px solid #dddddd;
   height: 38px;
   text-align: left;
   width: 100%;
   }
   .all_conversation i {
   background: #e9e7e8 none repeat scroll 0 0;
   border-radius: 100px;
   color: #636363;
   font-size: 17px;
   height: 30px;
   line-height: 30px;
   text-align: center;
   width: 30px;
   }
   .all_conversation .caret {
   bottom: 0;
   margin: auto;
   position: absolute;
   right: 15px;
   top: 0;
   }
   .all_conversation .dropdown-menu {
   background: #f5f3f3 none repeat scroll 0 0;
   border-radius: 0;
   margin-top: 0;
   padding: 0;
   width: 100%;
   }
   .all_conversation ul li {
   border-bottom: 1px solid #dddddd;
   line-height: normal;
   width: 100%;
   }
   .all_conversation ul li a:hover {
   background: #dddddd none repeat scroll 0 0;
   color:#333;
   }
   .all_conversation ul li a {
  color: #333;
  line-height: 30px;
  padding: 3px 20px;
}
   .member_list .chat-body {
   margin-left: 47px;
   margin-top: 0;
   }
   .top_nav {
   overflow: visible;
   }
   .member_list .contact_sec {
   margin-top: 3px;
   }
   .member_list li {
   padding: 6px;
   }
   .member_list ul {
   border: 1px solid #dddddd;
   }
   .chat-img img {
   height: 34px;
   width: 34px;
   }
   .member_list li {
   border-bottom: 1px solid #dddddd;
   padding: 6px;
   }
   .member_list li:last-child {
   border-bottom:none;
   }
   .member_list {
   height: 380px;
   overflow-x: hidden;
   overflow-y: auto;
   }
   .sub_menu_ {
  background: #e8e6e7 none repeat scroll 0 0;
  left: 100%;
  max-width: 233px;
  position: absolute;
  width: 100%;
}
.sub_menu_ {
  background: #f5f3f3 none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  display: none;
  left: 100%;
  margin-left: 0;
  max-width: 233px;
  position: absolute;
  top: 0;
  width: 100%;
}
.all_conversation ul li:hover .sub_menu_ {
  display: block;
}
.new_message_head button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
}
.new_message_head {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  font-size: 13px;
  font-weight: 600;
  padding: 18px 10px;
  width: 100%;
}
.message_section {
  border: 1px solid #dddddd;
}
.chat_area {
  float: left;
  height: 300px;
  overflow-x: hidden;
  overflow-y: auto;
  width: 100%;
}
.chat_area li {
  padding: 14px 14px 0;
}
.chat_area li .chat-img1 img {
  height: 40px;
  width: 40px;
}
.chat_area .chat-body1 {
  margin-left: 50px;
}
.chat-body1 p {
  background: #fbf9fa none repeat scroll 0 0;
  padding: 10px;
}
.chat_area .admin_chat .chat-body1 {
  margin-left: 0;
  margin-right: 50px;
}
.chat_area li:last-child {
  padding-bottom: 10px;
}
.message_write {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  padding: 15px;
  width: 100%;
}

.message_write textarea.form-control {
  height: 70px;
  padding: 10px;
}
.chat_bottom {
  float: left;
  margin-top: 13px;
  width: 100%;
}
.upload_btn {
  color: #777777;
}
.sub_menu_ > li a, .sub_menu_ > li {
  float: left;
  width:100%;
}
.member_list li:hover {
  background: #428bca none repeat scroll 0 0;
  color: #fff;
  cursor:pointer;
}


	</style>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.rawgit.com/samsonjs/strftime/master/strftime-min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

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






				<script src="https://use.fontawesome.com/45e03a14ce.js"></script>

						<h1>My name is {{Auth::user()->name}}</h1>
					 
					      <div class="chat_container">
					         <div class="col-sm-3 chat_sidebar">
					    	 <div class="row">
					            <div id="custom-search-input">
					               <div class="input-group col-md-12">
					                  <input type="text" class="  search-query form-control" placeholder="Conversation" />
					                  <button class="btn btn-danger" type="button">
					                  <span class=" glyphicon glyphicon-search"></span>
					                  </button>
					               </div>
					            </div>
					            <div class="dropdown all_conversation">
					               <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					               <i class="fa fa-weixin" aria-hidden="true"></i>
					               All Conversations 
					               </button>
					                
					            </div>
					            <div class="member_list">
					               <ul class="list-unstyled">


									 <li class="left clearfix">
					                  	<a href="{{url('/messenger/messages?rid='.$objReceiverHere->id)}}">
					                     <span class="chat-img pull-left">
					                     <img src="" alt="User Avatar" class="img-circle">
					                     </span>
					                     <div class="chat-body clearfix">
					                        <div class="header_sec">
					                           <strong class="primary-font">{{$objReceiverHere->name}}</strong> <strong class="pull-right">
					                           09:45AM</strong>
					                        </div>
					                        <div class="contact_sec">
					                           <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
					                        </div>
					                     </div>
					                    </a>
					                  </li> 


					               	@foreach($arrUserChannels as $uChannel)
					               		@if($uChannel->talking_to_id != $objReceiverHere->id)
						                  <li class="left clearfix">
						                  	<a href="{{url('/messenger/messages?rid='.$uChannel->talking_to_id)}}">
						                     <span class="chat-img pull-left">
						                     <img src="" alt="User Avatar" class="img-circle">
						                     </span>
						                     <div class="chat-body clearfix">
						                        <div class="header_sec">
						                           <strong class="primary-font">{{$uChannel->talking_to_name}}</strong> <strong class="pull-right">
						                           09:45AM</strong>
						                        </div>
						                        <div class="contact_sec">
						                           <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
						                        </div>
						                     </div>
						                    </a>
						                  </li>
						                @endif 
					                 @endforeach




					               </ul>
					            </div></div>
					         </div>
					         <!--chat_sidebar-->
							 
							 
					         <div class="col-sm-9 message_section">
							 <div class="row"> 
							 	<div class="new_message_head">
									<div class="pull-left">
										<button><i class="fa fa-user" aria-hidden="true"></i> {{$objReceiverHere->name}}</button>
									</div> 
								</div>
							 <div class="chat_area" id="chatAreaWrap">
							 <ul class="list-unstyled" id="chatMessageList" data-chid="{{$channel->id}}">
							
									  
									<!-- chat items here -->
									@foreach($conversations as $conversation)
									<li class="left clearfix admin_chat" data-cnid="{{$conversation->id}}">
										<span class="chat-img1 pull-right">
											<img src="" alt="User Avatar" class="img-circle">
										</span>
										<div class="chat-body1 clearfix">
											<p>{{$conversation->body}}</p>
											<div class="chat_time pull-left">{{$conversation->owner->name}}</div>
										</div>
									</li>
									@endforeach
							 
							 
							 </ul>
							 </div><!--chat_area-->
					          <form class="message_write" id="chatForm">
					    	 	<textarea id="chatMessageField" class="form-control" placeholder="type a message"></textarea>
							 	<div class="clearfix"></div>
							 	<div class="chat_bottom">
							 		<a href="#" class="pull-left upload_btn">
							 			<i class="fa fa-cloud-upload" aria-hidden="true"></i>Add Files
							 		</a>
					 				<button type="submit" class="pull-right btn btn-success">Send</button>
					 			</div>
							 </form>
							 </div>
					         </div> <!--message_section-->
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
	
	<script id="chat_message_template" type="text/template">
		<li class="left clearfix admin_chat"  data-cnid="">
			<span class="chat-img1 pull-right">
				<img src="" alt="User Avatar" class="img-circle">
			</span>
			<div class="chat-body1 clearfix">
				<p></p>
				<div class="chat_time pull-left"></div>
			</div>
		</li>
	</script>

	<script>
		/***************************************************/
		/*****************Sending Chat Message**************/
		/***************************************************/
		$('#chatForm').on('submit', function(){
			var messageText = $.trim($('#chatMessageField').val());
	        if(messageText.length < 1) {
	            return false;
	        }
	        
	        // Build POST data and make AJAX request
	        var data = {m: messageText, an: '{{$channel->alias_name}}', rid: '{{$objReceiverHere->id}}'};
	        $.post('/messenger/send', data).success(sendMessageSuccess);
	        
	        // Ensure the normal browser event doesn't take place
	        return false;
		});

		function sendMessageSuccess(){
			$('#chatMessageField').focus().val('');
        	console.log('message sent successfully');
		}

		// send with enter key
		$('#chatMessageField').keypress(function(e){
			if (e.keyCode === 13) {
				$('#chatForm').submit();
			}
		}) 


		/***************************************************/
		/******************Global Presence******************/
		/***************************************************/
		var pusher = new Pusher('{{env("PUSHER_KEY")}}', {
	                    cluster: 'ap1',
	                    authEndpoint: '/messenger/auth',
	                    auth: {
	                        headers: {
	                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                        }
	                    }
	                });
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




	    /***************************************************/
		/******************One to One Chat******************/
		/***************************************************/ 

		// listen to new message  
		var privateChat = pusher.subscribe( '{{$channel->channel_name}}' );
		privateChat.bind('new-message', newChat);
		chatScrollDown();

		function newChat(data){
			var strTemplate = $('#chat_message_template').text();
        	var elList = $(strTemplate);
        	var elChatMessageList = $('#chatMessageList');
 
    		elList.find('.chat-body1 p').text(data.message);
    		elList.find('.chat_time').text(data.un);
    		elChatMessageList.append(elList);  
			chatScrollDown();
		}

		function chatScrollDown(){
			var elChatArea = $('#chatAreaWrap');
			elChatArea.scrollTop(elChatArea.prop("scrollHeight"));
		} 

		// loading more chat history
		var boolIsLoaded = true;
	    var boolIsEnded = false;
	    var intHeightAdded = 0;
	    var intLimit = 10;

		$('#chatAreaWrap').scroll(function (event) {
		    var intScrollTopVal = $('#chatAreaWrap').scrollTop(); 
		     
		    if(intScrollTopVal == 0 && boolIsLoaded == true && boolIsEnded == false){
		    	fetchHistory();
		    }
		});

		function fetchHistory(){  
			boolIsLoaded = false;

			var data = {
						cnid: $('#chatMessageList li').first().data('cnid'), 
						chid: '{{$channel->id}}'
					};

	        $.post('/messenger/history', data).success(loadHistory);
		}

		function loadHistory(data){ 
			var jsonMessages = JSON.parse(data);
			$.each(jsonMessages, function(key, message){
				addChatHistory(message); 
			});

			var elChatArea = $('#chatAreaWrap');
			elChatArea.scrollTop(intHeightAdded);
			console.log(intHeightAdded);
			intHeightAdded = 0;

			boolIsLoaded = true;
			boolIsEnded = jsonMessages.length < intLimit ? true : false;
		}

		function addChatHistory(message){
			var strTemplate = $('#chat_message_template').text();
        	var elList = $(strTemplate);
        	var elChatMessageList = $('#chatMessageList');
 			
 			elList.data('cnid', message.id);
    		elList.find('.chat-body1 p').text(message.body);
    		elList.find('.chat_time').text(message.owner.name);
    		elChatMessageList.prepend(elList);
    		intHeightAdded += elList.outerHeight();
		}
	    
	</script>
</body>
</html>