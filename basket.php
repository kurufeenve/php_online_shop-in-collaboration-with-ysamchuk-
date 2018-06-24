<?php
session_start();
$data = unserialize(file_get_contents('./data/data'));
$goods = $data['goods'];
$basket = $data['basket'];
$orders = $data['orders'];
if ($_GET['buy'] !== NULL)
{
	$basket[] = $_GET['buy'];
	header('Location: http://localhost:8100/basket.php');
}
if ($_GET['delete'] !== NULL)
{
	unset($basket[array_search($_GET['delete'], $basket)]);
	header('Location: http://localhost:8100/basket.php');
}
$data['basket'] = $basket;
$total = 0;
foreach ($basket as $name)
	$total += $goods[$name]['price'];
if ($_SESSION['loggued_on_user'] != "" && isset($basket) && $basket[0] != NULL && $_GET['validate'] === 'Validate')
{
	$order["user"] = $_SESSION['loggued_on_user'];
	$order["basket"] = $basket;
	$order["total_price"] = $total;
	$orders[] = $order;
	$data['orders'] = $orders;
	$data['basket'] = array();
	echo "Your order is confirmed. Thank you for choosing our online shop Mr./Mrs. ";
}
file_put_contents('./data/data', serialize($data));
if ($_SESSION['loggued_on_user'] != "")
	echo $_SESSION['loggued_on_user'].'<form action="./login/logout.php" method=GET>
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
			height: 200px;
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
		<form action='./goods_put.php' method=GET>
			<input class="button" type="submit" name="goods" value="Goods">
		</form>
		<form action='./basket.php' method=GET>
			<input class="button" type="submit" name="validate" value="Validate">
		</form>
		<h3>Total value = <?php echo $total; ?>$</h3>
		<div class="item" align="center">
			<table>
			<form action="basket.php" method="GET">
			<?php
			foreach ($basket as $name)
			{
				echo '<tr><td><img src='.$goods[$name]['url'].'><br>
				<p>'.$name.' '.$goods[$name]['price'].'$</p>
				<button type="submit" name="delete" value="'.$name.'">Delete</button><td></tr>';
			}
			?>
			</form>
			</table>
		</div>
	</div>
</body>
</html>