<?php

	session_start();
	require("connection.php");

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> PHP Advanced Assignment (Basic 4)</title>
	<link rel="stylesheet" type="text/css" href="basic4.css">
</head>
<body>
<?php

	if(isset($_SESSION["loginerrors"]))
	{
		echo "-".$_SESSION["loginerrors"]."<br>";
	}
	// if(isset($_SESSION["loggedin"]))
	// {
	// 	echo "-".$_SESSION["loggedin"]."<br>";
	// }
	// if(isset($_SESSION['id']['firstname']))
	// {
	// 	echo "-".$_SESSION['id']['firstname']."<br>";
	// }
	// if(isset($_SESSION['id']['lastname']))
	// {
	// 	echo "-".$_SESSION['id']['lastname']."<br>";
	// }
	// if(isset($_SESSION['id']['email']))
	// {
	// 	echo "-".$_SESSION['id']['email']."<br>";
	// }
	if(isset($_SESSION['loginerror']))
	{
		foreach($_SESSION['loginerror'] as $loginerror)
		{
		echo "-".$loginerror."<br>";
		}
	}

	unset($_SESSION['loginerrors']);
	// unset($_SESSION['loggedin']);
	// unset($_SESSION['id']['firstname']);
	// unset($_SESSION['id']['lastname']);
	// unset($_SESSION['id']['email']);
	unset($_SESSION['loginerror']);

?>
	Login:
	<form action="process.php" method="post">
	<input type="hidden" name="action" value="login">
	Email:	<input type="email" name="emaillogin">
	Password:	<input type="password" name="pwlogin">
	<input type="submit" value="Login">
	</form>
	<br>

	OR register:
	<?php

	if(isset($_SESSION["empty"]))
	{
		echo "-".$_SESSION["empty"]."<br>";
	}
	if(isset($_SESSION["empty2"]))
	{
		echo "-".$_SESSION["empty2"]."<br>";
	}
	if(isset($_SESSION["invalid"]))
	{
		echo "-".$_SESSION["invalid"]."<br>";
	}
	if(isset($_SESSION["special"]))
	{
		echo "-".$_SESSION["special"]."<br>";
	}
	if(isset($_SESSION['pw']))
	{
		echo "-".$_SESSION['pw']."<br>";
	}
	if(isset($_SESSION['pwcheck']))
	{
		echo "-".$_SESSION['pwcheck']."<br>";
	}
	if(isset($_SESSION['thanks']))
	{
		echo $_SESSION['thanks'];
	}
	unset($_SESSION['empty']);
	unset($_SESSION['empty2']);
	unset($_SESSION['invalid']);
	unset($_SESSION['special']);
	unset($_SESSION['pw']);
	unset($_SESSION['pwcheck']);
	unset($_SESSION['thanks']);
?>
	<form action="process.php" method="post">
		<input type="hidden" name="action" value="register">
		Email:<br><input type="email" name="email">*<br>
		First Name:<br><input type="text" name="firstname">*<br>
		Last Name:<br><input type="text" name="lastname">*<br>
		Password:<br><input type="password" name="pw">*<br>
		Confirm Password:<br><input type="password" name="pwcheck">*<br>
		Birthdate: <br><input type="date" name="birthday"><br>
		* Required Fields <br>
		<input type="submit" value="Register Now!">
	</form>

</body>
</html>