<!DOCTYPE html>
<html>
<head>
	<title>Real-time Chat System</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>

	<div id="wrapper">
		<h1><center>Welcome <?php session_start(); echo $_SESSION['username']; ?> to Chatbox</center></h1>
		<div class="chat_wrapper">
			<div id="abc"></div>
			<div id="chat" style="color: white; height: 500px; overflow: auto;">
			</div>
			<form method="POST" id="messageForm">
				<textarea name="message" cols="30" rows="7" class="textarea" placeholder="Please Type a message to send"></textarea>
			</form>
		</div>
	</div>
	<script>

		LoadChat();

		setInterval(function(){
			LoadChat();
		}, 1000);

		function LoadChat(){
			$.post('messages.php?action=getMessage', function(response){

				var scrollpos = $('#chat').scrollTop();
				var scrollpos = parseInt(scrollpos) + 520;
				var scrollHeight = $('#chat').prop('scrollHeight');

				$('#chat').html(response);

				if(scrollpos < scrollHeight){

				}else{
					$('#chat').scrollTop($('#chat').prop('scrollHeight'));
				}

			});
		}

		$('.textarea').keyup(function(e){
			if (e.which == 13){
				$('form').submit();
			}
		});

		$('form').submit(function(){

			var message = $('.textarea').val();

			$.post('messages.php?action=sendMessage&message='+message, function(response){
				if (response == 1){
					LoadChat();
					document.getElementById('messageForm').reset();
				}
			});
			
			return false;
		});

	</script>

</body>
</html>