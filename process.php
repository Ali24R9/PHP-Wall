<?php
session_start();
// var_dump($_POST);
// die;
require("connection.php");

if(isset($_POST['action']) AND $_POST['action']== "register")
{
	register();
}
if(isset($_POST['action']) AND $_POST['action']== "login")
{
	login();
}
if(isset($_POST['action']) AND $_POST['action']=="message")
{
	message();
}
if(isset($_POST['action']) AND $_POST['action']== "logoff")
{
	logoff();
}
if(isset($_POST['action']) AND $_POST['action']=="comment")
{
	comment();
}
if(isset($_POST['action']) AND $_POST['action']=="delete")
{
	delete();
}
function login()
{
	$errors= array();

	if(isset($_POST['email']) and filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors[] = "Please enter a valid email address";
	}
	if(count($errors)>0)
	{
		$_SESSION['loginerrors']= $errors;
		header('location:index(basic4).php');
	}
	else
	{
		$email=mysql_real_escape_string($_POST['emaillogin']);
		$password=mysql_real_escape_string($_POST['pwlogin']);
		$query= "SELECT * FROM users WHERE email = '$email' and password = '$password'";
// echo $query;
// die();
		$users = fetch_all($query);

		if(count($users)>0)
		{
			$_SESSION['loggedin']= true;
			$_SESSION['user']['firstname'] = $users[0]['first_name'];
			$_SESSION['user']['lastname'] = $users[0]['last_name'];
			$_SESSION['user']['email'] = $users[0]['email'];
			$_SESSION['user']['userid'] = $users[0]['id'];
			header("location: success(basic4).php");		
		}
		else
		{
			$errors[]= "Invalid login input, please try again or register a new account.";
			$_SESSION['loginerror']= $errors;
			header("location: index(basic4).php");
		}


	}
}
function register()
{
		$errors= NULL;


	if(isset($_POST['email']))
	{	
		if(empty($_POST["email"]))
		{
			$errors[]=1;
			 $_SESSION["empty"]= "Email address can't be blank. Please enter a valid email.";
		}
		else if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
		{
			$errors[]=2;
			$_SESSION["invalid"]= "The email address you entered: <h4>".$_POST['email']. "</h4> is not a valid email. Please enter a valid email.";
		}
	}
	if(isset($_POST['firstname']))
	{
		if(empty($_POST["firstname"]))
		{
			$errors[]=3;
			 $_SESSION["empty2"]= "Name field(s) cannot be blank. Please enter a name.";
		}
		else if(!ctype_alpha($_POST['firstname']))
		{
			$errors[]=4;
			$_SESSION["special"]= "Name field(s) cannot have any special characters.";
		}
	}
	if(isset($_POST['lastname']))
	{
		if(empty($_POST["lastname"]))
		{
			$errors[]=5;
			 $_SESSION["empty2"]= "Name field(s) cannot be blank. Please enter a name.";
		}
		else if(!ctype_alpha($_POST['lastname']))
		{
			$errors[]=6;
			$_SESSION["special"]= "Name field(s) cannot have any special characters.";
		}
	}
	if(isset($_POST['pw']))
	{
		if(empty($_POST["pw"]))
		{
			$errors[]=7;
			 $_SESSION["pw"]= "Password can't be blank. Please enter a valid password.";
		}
		if(strlen($_POST['pw'])< 6)
		{

			$errors[]=8;
			$_SESSION['pw']= "Password length must be at least 6 characters.";
		}
	}
	if(isset($_POST['pwcheck']))
	{
		if(empty($_POST["pwcheck"]))
		{
			$errors[]=9;
			 $_SESSION["empty"]= "Password confirmation field can't be blank. Please enter a valid password confirmation.";
		}
		if($_POST['pwcheck'] !== $_POST['pw'])
		{
			$errors[]=10;
			$_SESSION['pwcheck']= "Passwords don't match.";
		}
		
	}

	if ($errors==NULL)
	{
		$email=$_POST['email'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$password=$_POST['pw'];
	$query= "INSERT INTO users(email, first_name, last_name, password, created_at) VALUES ('$email', '$firstname', '$lastname','', NOW()) ";
		// var_dump($query);
		
	mysql_query($query);
	$_SESSION['thanks']="Thanks for submitting your information {$_POST['email']}!";

	}
	if(isset($_POST) AND $_POST['action']== "login")
	{

	}

header("location:index(basic4).php");
}

function message()
{
	$user_id= $_SESSION['user']['userid'];
	$message= $_POST['message'];
	$query = "INSERT INTO messages(user_id, message, created_at, updated_at) VALUES($user_id,'$message', NOW(), NOW())";
	// echo $query;
	// die();
	mysql_query($query);


	// $query = "SELECT * FROM messages WHERE user_id = '{$_SESSION['user']['userid']}' AND message = '{$_POST['message']}' AND created_at = NOW()";
	// $query = "SELECT message, created_at, user_id FROM messages ORDER BY created_at DESC";
	// $record = fetch_all($query);
	// if(!empty($record))
	// {
	// 	$_SESSION['wallpost']= $record;
	// }
	header("location:success(basic4).php");
		
}
function comment()
{
	$user_id= $_SESSION['user']['userid'];
	$message_id=$_POST['message_id'];
	$comment=$_POST['comment'];

	$query= "INSERT INTO comments(users_id, messages_id, comment, created_at) VALUES ($user_id, $message_id, '$comment', NOW())";
	// echo($query);
	// die();
	mysql_query($query);
	header("location:success(basic4).php");
}
function logoff()
{
	session_destroy();
	// unset($_SESSION['loggedin']);
	header("location:index(basic4).php");

}
function delete()
{	
	$delete_query="DELETE FROM comments
				   WHERE comments.id= {$_POST['comment_id']}";
	mysql_query($delete_query);
	header("location:success(basic4).php");
}
// array(1) { [0]=> array(5) { ["id"]=> string(2) "37" ["user_id"]=> string(1) "4" ["message"]=> string(4) "asdf" ["created_at"]=> string(19) "2013-09-30 14:51:01" ["updated_at"]=> string(19) "2013-09-30 14:51:01" } }




?>