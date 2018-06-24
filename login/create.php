<?php
if ($_POST['login'] && $_POST['passwd'] && $_POST['copasswd'] && $_POST['submit'] === "OK")
{
	if ($_POST['passwd'] != $_POST['copasswd'])
		echo "passwords does not match";
	else
	{
		$data = unserialize(file_get_contents('../data/data'));
		$users = $data['users'];
		$account['login'] = $_POST['login'];
		$account['passwd'] = hash('whirlpool', $_POST['passwd']);
		if (array_key_exists($_POST['login'], $users) != FALSE)
		{
			echo "<html><body>
			<p>This login is already in use.</p>
			</html></body>";
		}
		else
		{
			$users[$account['login']] = $account;
			$data['users'] = $users;
			file_put_contents('../data/data', serialize($data));
			echo "<html><body>
			<p>You have been registered with login: $_POST[login]</p>
			</html></body>";
		}
	}
}
?>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Magazik</title>
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
			min-width: 125px;
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
			min-width: 125px;
			color: white;
			user-select: none;
			text-decoration: none;
			background-color: #45a049;
			padding: 10px 10px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
	</style>
</head><body>
    <form action='create.php' method=POST>
        Username: <input type="text" name="login" value="">
        <br>
		Password: <input type="password" name="passwd" value="">
		<br>
		Confirm Pasword: <input type="password" name="copasswd" value="">
        <br>
		<input type="submit" name="submit" value="OK">
	</form>
	<button type="submit"><a style="text-decoration:none; color:black" href="http://localhost:8100/index.php">Back to main page</a></button>
</body></html>