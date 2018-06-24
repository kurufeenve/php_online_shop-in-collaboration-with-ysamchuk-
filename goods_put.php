<?php
session_start();
$data = unserialize(file_get_contents('./data/data'));
$goods = $data['goods'];
$categories = $data['categories'];
$show = $goods;
if (isset($_GET['category']) && $_GET['category'] != "" && array_search($_GET['category'], $categories))
{
	$show = array();
	foreach ($goods as $name => $good)
	{
		if (in_array($_GET['category'], $good['categories']))
		{
			$show[$name] = $good;
		}
	}
}
if ($_SESSION['loggued_on_user'] != "")
echo $_SESSION['loggued_on_user'].'<form action="login/logout.php" method=GET>
<button type="submit" name="logout" value="OK">Logout</button>
</form>';
?>
<html>
<head>
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
		img {
			height: 100%;
		}
		.container {
			position: relative;
			width: 90%;
			height: 90%;
		}
		.button {
			background-color: white;
		}
		.item {
			display: flex;
			max-width: 50%;
			align-content: center;
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
		img {
			height: 100px;
		}
		.container {
			width: 90%;
			margin: auto;
		}
		.button {
			background-color: white;
		}
		.item {
			display: flex;
			width: 80%;
		}
		.good {
			position: relative;
			display: inline-block;
			width: 14%;
			border: 2px solid rgb(6, 140, 180);
			text-align: center;
			margin: 0.5%;
		}
		#basket {
			position: absolute;
			left: 0;
			width: 100%;
			height: 75%;
			bottom: 0;
			float: left;
		}
	</style>
</head>
<body>
	<div class="container">
		<button id="home" type="submit"><a style="text-decoration:none; color: white" href="http://localhost:8100/index.php">Back to main page</a></button>
		<form action='./login/login.php' method=GET>
			<input class="button" type="submit" name="Login" value="Sign in">
		</form>
		<form action='./login/create.php' method=POST>
			<input class="button" type="submit" name="Register" value="Sign up">
		</form>
		<form action='basket.php' method=POST>
			<input class="button" type="submit" name="Register" value="Basket">
		</form>
		<div class="item">
			<table>
			<tr><td>
			<form action="./goods_put.php" method="GET">
			<?php
			foreach ($categories as $val)
				echo '<button type="submit" name="category" value="'.$val.'">'.$val.'</button>';
			?>
			</form>
			</td></tr>
			</table>
			<form id="basket" action="basket.php" method="GET">
			<?php
			foreach ($show as $name => $good)
			{
				echo '<div class="good">
							<h4>'. $name. '</h4>
								<img class="good_img" src="'. $good['url']. '"/><br>
								<strong>'. $good['price']. '$</strong>
								<button type="submit" name="buy" value="'. $name. '">Buy</button>
						</div>';
			}
			?>
			</form>
		</div>
	</div>
</body>
</html>