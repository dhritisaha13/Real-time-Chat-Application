<?php 

include('db.php');

switch ($_REQUEST['action']) {
	case "sendMessage":

		session_start();
		$query = $db -> prepare("INSERT INTO messages SET user=?, message=?");
		$run = $query->execute([$_SESSION['username'], $_REQUEST['message']]);

		if ($run){
			echo 1;
			exit();
		}

		break;

	case "getMessage":

		session_start();
			
		$query = $db -> prepare("SELECT * FROM messages");
		$run = $query -> execute();

		$rs = $query->fetchAll(PDO::FETCH_OBJ);

		$chat = '';
		foreach ($rs as $message) {

			$chat .= '<div class = "single-message '.(($_SESSION['username']==$message->user)?'right ':'left').'" style = "padding: 5px 10px 5px 10px; border: 1px solid #b3b3b3; border-radius:5px; max-width:400px; margin:5px 0px 5px 0px; ">
						<strong>'.$message->user.': </strong><br /> <p> '.$message->message.'</p>
						<br />
						<span style = "float: right; font-size:12px;">'.date('m-d-Y h:i a', strtotime($message->date)).'</span>
						</div>
						<div class="clear"></div>';
		}

		
		echo $chat;

		break;	
	
}



 ?>