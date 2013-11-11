<?php

session_start();
require("connection.php");
// if(isset($_SESSION["loggedin"]))
// 	{
// 		echo "-".$_SESSION["loggedin"]."<br>";
// 	}
	// if(isset($_SESSION['user']['firstname']))
	// {
	// 	echo "-".$_SESSION['user']['firstname']."<br>";
	// }
	// if(isset($_SESSION['user']['lastname']))
	// {
	// 	echo "-".$_SESSION['user']['lastname']."<br>";
	// }
	// if(isset($_SESSION['user']['email']))
	// {
	// 	echo "-".$_SESSION['user']['email']."<br>";
	// }
	// unset($_SESSION['user']['loggedin']);
	// unset($_SESSION['user']['firstname']);
	// unset($_SESSION['user']['lastname']);
	// unset($_SESSION['user']['email']);


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Wall</title>
</head>
<body>
	<h1>The Wall</h1>
	<form action="process.php" method="post">
		<input type="hidden" name="action" value="logoff">
		<input type="submit" value="Log Off">
	</form>

<form action="process.php" method="post">
	<input type="hidden" name="action" value="message">
	<textarea name="message" cols="80" rows="5"></textarea><br>
	<input type="submit" value="Post Message">
</form>
<?php
	if(isset($_SESSION['loggedin']) AND isset($_SESSION['user']['email']))
	{

		echo "Welcome ".$_SESSION['user']['email']."!";
;
	}

	$messages_query = 	"SELECT messages.id as message_id, users.first_name, users.last_name, messages.message, messages.created_at, messages.user_id 
						FROM messages
						LEFT JOIN users ON users.id = messages.user_id
						ORDER BY created_at DESC";
	$messages = fetch_all($messages_query);

	// if(isset($_SESSION['wallpost']))
	// {
		// echo "<pre>";
		// var_dump($_SESSION['wallpost']);
		// echo "</pre>";
		foreach($messages as $message)
		{
		echo "<br>".$message['first_name']. " ".$message['last_name'].": ".$message['message']."<br>(".$message['created_at'].")";
	?>		<form action="process.php" method="post">
			<input type="hidden" name="action" value="comment">
			<input type="hidden" name="message_id" value="<?= $message['message_id']?>">
			<textarea name="comment" cols="10" rows="2"></textarea><br>	
			<input type="submit" value="Post Comment">
			</form><br>


<?php
			$comments_query = "SELECT comments.id as comment_id, users.first_name, users.last_name, comments.comment, comments.created_at, comments.users_id as user_id FROM comments
				LEFT JOIN users ON users.id = comments.users_id
				WHERE comments.messages_id= {$message['message_id']} ";
				// echo $comments_query;
				// die();
			$comments= fetch_all($comments_query);

			foreach($comments as $comment)
			{
				echo $comment['first_name']." ".$comment['last_name']."<br>";
				echo $comment['comment']."<br>";
				echo $comment['created_at'];

			if($_SESSION['user']['userid']== $comment['user_id'])
			{
			 
?>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="delete">
				<input type="hidden" name="comment_id" value="<?= $comment['comment_id']?>">
				<input type="hidden" name="user_id" value="<? $comment['user_id']?>">
				<input type="submit" value="Delete">
			</form>
<?php
			
			}

			}
	}
?>




</body>
</html>