<?php
include "install.php";

session_start();
install();
$data = unserialize(file_get_contents('./data/data'));
$show[] = $data["goods"]['Duck'];
$show[] = $data["goods"]['My Little Pony'];
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
		.hat {
			background: #909090;
			position: relative;
			width: 100%;
			max-width: 900px;
			min-width: 650px;
			height: 50px;
			box-shadow: 8px 8px 8px;
		}
		img {
			height: 150px;
		}
		.items {
			position: relative;
			vertical-align: center;
			margin-top: 20px;
			margin-left: auto;
			float:left;
			display: flex;
			align: center;
			color: white;
		}
		.button {
			background-color: #4CAF50;
			position: relative;
			color: white;
			font-family: fantasy;
			font-size: 16px;
			margin-left: 10px;
			min-width: 120px;
			margin-top: 10px;
			border: none;
		}
		.right {
			float: right;
		}
		.header {
			position: relative;
			max-width: 900px;
			min-width: 650px;
			min-height: 40px;
			margin-left: 2px;
			background-color: #4CAF50;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
		}
	</style>
</head>
<body>
	<div class="hat">
		<div class="header">
			<a href="http://localhost:8100/index.php" class="button">Home</a>
			<a href="http://localhost:8100/basket.php" class="button">Basket</a>
			<a href="http://localhost:8100/goods_put.php" class="button">Goods</a>
			<a href="http://localhost:8100/goods_put.php" class="button">All</a>
			<a href="http://localhost:8100/login/login.php?Login=Sign+in" class="button">Sign in</a>
			<a href="http://localhost:8100/login/create.php" class="button">Sign up</a>
			<?php
			if ($_SESSION['loggued_on_user'] != "")
			{
				echo '<a href="http://localhost:8100/login/logout.php" class="button right">Logout: '.$_SESSION['loggued_on_user'].'</a>';
			
			}
			if ($_SESSION['loggued_on_user'] == 'root' || $_SESSION['loggued_on_user'] == 'admin')
				echo '<a href="http://localhost:8100/admin.php" class="button right">Admin Page</a>'
			?>
		</div>
	</div>
	<center>
	<div class="items">
		<table>
			<tr>
				<form action="goods_put.php" method="GET">
					<?php
						foreach ($show as $name => $good) {
							echo '<td><button type="submit" name="buy" value="'.$name.'"><img src="'.$good["url"].'"></button></td>';
						}
					?>
				</form>
			</tr>
		</table>
	</div>
		</center>
</body>
</html>
