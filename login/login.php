<?php
include "auth.php";

session_start();
if ($_GET['login'] && $_GET['passwd'] && $_GET['submit'] === "OK")
{
	$login = $_GET['login'];
	$passwd = $_GET['passwd'];
	if (auth($login, $passwd) == TRUE)
	{
		$_SESSION['loggued_on_user'] = $login;
		header('Location: ../index.php');
	}
	else
		$_SESSION['loggued_on_user'] = "";
	if ($_SESSION['loggued_on_user'] != "")
		echo $_SESSION['loggued_on_user'].'<form action="logout.php" method=GET>
		<button type="submit" name="logout" value="OK">Logout</button>
	</form>';
}
?>
<html><head>
	<style>
		body {
			background: #ceddad;
			background: -moz-linear-gradient(top, #ceddad 0%, #b4ddb4 100%, #005700 100%);
			background: -webkit-linear-gradient(top, #ceddad 0%,#b4ddb4 100%,#005700 100%);
			background: linear-gradient(to bottom, #ceddad 0%,#b4ddb4 100%,#005700 100%);
		}
		input[type=text], [type=password], [type=float]{
			width: 40%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		input[type=submit] {
			width: 20%;
			background-color: #4CAF50;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}

		div {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
		}
		#home {
			width: 20%;
			color: white;
			padding: 10px 10px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
	</style>
</head><body>
	<form action='login.php' method=GET>
		Username: <input type="text" name="login" value="">
		<br>
		Password: <input type="password" name="passwd" value="">
		<br>
		<input type="submit" name="submit" value="OK">
	</form>
	<button type="submit"><a style="text-decoration:none; color: black" href="http://localhost:8100/index.php">Back to main page</a></button>
</body></html>