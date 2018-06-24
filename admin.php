<?php
session_start();
if ($_SESSION['loggued_on_user'] != "root" && $_SESSION['loggued_on_user'] != "admin") {
	header("HTTP/1.0 403");
	exit;
}
function get_categories_for_item() {
	$tab = preg_split('/;/', $_GET["categories"]);
	return array_values(array_diff($tab, [""]));
}
function add_categories() {
	$data = unserialize(file_get_contents("./data/data"));
	$tmp_categories = get_categories_for_item();
	if (!$data["categories"])
		$data["categories"] = array();
	$bad_search = "";
	$good_search = "";
	foreach ($tmp_categories as $key => $value) {
		if (array_search($value, $data["categories"]) !== False)
			$bad_search = $bad_search."(".$value.")";
		else {
			$data["categories"][] = $value;
			$good_search = $good_search."(".$value.")";
		}
	}
	file_put_contents("./data/data", serialize($data));
	if ($good_search)
		$good_search = "'".$good_search."' has been added!<br>";
	if ($bad_search)
		$good_search = $good_search."ERROR! Category '".$bad_search."' is/are exist!";
	return $good_search;
}
function remove_categories() {
	$data = unserialize(file_get_contents("./data/data"));
	$tmp_categories = get_categories_for_item();
	$bad_search = "";
	$good_search = "";
	foreach ($tmp_categories as $key => $value) {
		if (($tmp_key = array_search($value, $data["categories"])) === False)
			$bad_search = $bad_search."(".$value.")";
		else {
			array_splice($data["categories"], $tmp_key, 1);
			$good_search = $good_search."(".$value.")";
			foreach ($data["goods"] as $name => $good) {
				if (($cat_key = array_search($value, $good["categories"])) !== False)
					array_splice($data['goods'][$name]['categories'], $cat_key, 1);
			}
		}
	}
	file_put_contents("./data/data", serialize($data));
	if ($good_search)
	$good_search = "'".$good_search."' has been deleted!<br>";
	if ($bad_search)
	$good_search = $good_search."ERROR! Category '".$bad_search."' is/are not exist!!";
	return $good_search;
}
function add_item() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_GET["product_name"], $data["goods"]))
		return "ERROR! The item is exist!";
	$tmp_categories = get_categories_for_item();
	foreach($tmp_categories as $key => $value) {
		if (array_search($value, $data["categories"]) === False)
			return "Category'".$value."' is not exist!";
	}
	$good["price"] = $_GET["price"];
	$good["categories"] = $tmp_categories;
	$good["url"] = $_GET["url"];
	$data["goods"][$_GET["product_name"]] = $good;
	file_put_contents("./data/data", serialize($data));
	return "'".$_GET["product_name"]."' has been added to items!";;
}

function remove_item() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_GET["product_name"], $data["goods"]) === False)
		return "ERROR! The item is not exist!";
	unset($data["goods"][$_GET["product_name"]]);
	file_put_contents("./data/data", serialize($data));
	return "'".$_GET["product_name"]."'has been deleted!";
}

function update_item() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_GET["product_name"], $data["goods"]) === False)
		return "ERROR! The product not exist!";
	$tmp_name = $_GET["product_name"];
	if ($_GET["new_name"] != NULL) {
		$data["goods"][$_GET["new_name"]] = $data["goods"][$_GET["product_name"]];
		unset($data["goods"][$_GET["product_name"]]);
		$tmp_name = $_GET["new_name"];
		$good_search = "Name has been changed! ";
	}
	if ($_GET["url"] != NULL) {
		$data["goods"][$tmp_name]["url"] = $_GET["url"];
		$good_search = $good_search." URL has been changed!";
	}
	if ($_GET["price"] > 0) {
		$data["goods"][$tmp_name]["price"] = $_GET["price"];
		$good_search = $good_search." Price has been changed!";
	}
	if ($_GET["categories"] != NULL) {
		$tmp_categories = get_categories_for_item();
		foreach($tmp_categories as $key => $value) {
			if ((($tmp_key = array_search($value, $data["goods"][$tmp_name]["categories"])) === False) &&
				(array_search($value, $data["categories"]) !== False)) {
				$data["goods"][$tmp_name]["categories"][] = $value;
				$good_search = $good_search."(".$value.") category has been added! ";
			}
			elseif ($tmp_key !== False) {
				array_splice($data["goods"][$tmp_name]["categories"], $tmp_key, 1);
				$bad_search = $bad_search."(".$value.")";
			}
		}
	}
	file_put_contents("./data/data", serialize($data));
	if ($bad_search)
		$good_search = $good_search." Categories '".$bad_search."' has been deleted!";
	return $good_search;
}

function add_user() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_POST["uname"], $data["users"]) === True)
		return "ERROR! User '".$_POST["uname"]."' exists!";
	$user["login"] = $_POST["uname"];
	$user["passwd"] = hash('whirlpool', $_POST["new_passwd"]);
	$data["users"][$_POST["uname"]] = $user;
	file_put_contents("./data/data", serialize($data));
	return "'".$_POST["uname"]."'has been added!";
}

function remove_user() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_POST["uname"], $data["users"]) === False)
		return "ERROR! User '".$_POST["uname"]."' is not exist!";
	if ($_POST["uname"] != "root" && $_POST["uname"] != "admin") {
		unset($data["users"][$_POST["uname"]]);
		file_put_contents("./data/data", serialize($data));
		return "'".$_POST["uname"]."'has been deleted!";
	}
	else
		return "Ohhh... '".$_POST["uname"]."'can not be deleted!";
}

function update_user() {
	$data = unserialize(file_get_contents("./data/data"));
	if (array_key_exists($_POST["uname"], $data["goods"]) === False)
		return "ERROR! The item is not exist!";
	$tmp_name = $_GET["product_name"];
	if ($_POST["new_name"] != NULL) {
		$data["users"][$_POST["new_name"]] = $data["users"][$_POST["uname"]];
		unset($data["users"][$_POST["uname"]]);
		$tmp_name = $_POST["uname"];
		$search = "Name has been changed! ";
	}
	if ($_POST["new_passwd"] != NULL) {
		if ($_POST["passwd"] == $_POST["new_passwd"]) {
			$data["users"][$tmp_name]["passwd"] = hash("whirlpool", $_POST["new_passwd"]);
			$search = $search." pass has been changed!";
		}
		else
			$search = $search." passwords do not match!";
	}
	file_put_contents("./data/data", serialize($data));
	return $search;
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
			color: darkgrey;
			padding: 10px 10px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<button type="submit">
		<a style="text-decoration:none; color: black" id="home" href="http://localhost:8100/index.php">
			Back to main page
		</a>
	</button>
	<div>
			<h4>Adding/removing categories</h4>
		<form action='./admin.php' method=GET>
		Names of categories: <input type="text" name="categories" value="" placeholder="Format: <one>;<two>;..;..;">
		<br>
		<input type="submit" name="submit" value="Add category">
		<input type="submit" name="submit" value="Delete category">
		<br />
		<p>
			<?php
				if ($_GET["submit"] == "Add category" && $_GET["categories"] != NULL) {
					echo add_categories();
				}
				elseif ($_GET["submit"] == "Delete category" && $_GET["categories"] != NULL) {
					echo remove_categories();
				}
				?>
			</p>
		</form>
	</div>
	<br>
	<div>
		<h4>Adding/removing/updating item</h4>
		<form action='./admin.php' method=GET>
		Name of product*: <input type="text" name="product_name" value="" placeholder="Name">
		<br>
		Price*: <input type="float" name="price" value="" placeholder="Value > 0">
		<br>
		Categories*: <input type="text" name="categories" value="" placeholder="Format: <one>;<two>;..;..;">
			<br>
			Image URL*: <input type="text" name="url" value="" placeholder="http://...">
			<br>
			New name: <input type="text" name="new_name" value="" placeholder="Name">
			<br>
			<input type="submit" name="submit" value="*Add item">
			<input type="submit" name="submit" value="Delete item">
			<input type="submit" name="submit" value="Update item">
			<br />
			<p>
				<?php
			if ($_GET["submit"] == "*Add item" && $_GET["product_name"] != NULL && $_GET["price"] != NULL
			&& $_GET["categories"] != NULL && $_GET["url"] != NULL && $_GET["new_name"] == NULL) {
				if (is_float($_GET["price"]) || is_numeric($_GET["price"]))
					echo add_item();
				else
					echo "Not a number";
			}
			elseif ($_GET["submit"] == "Delete item" && $_GET["product_name"] != NULL && $_GET["new_name"] == NULL) {
				echo remove_item();
			}
			elseif ($_GET["submit"] == "Update item" && $_GET["product_name"] != NULL)
			echo update_item();
			elseif ($_GET["submit"] == "*Add item" && ($_GET["product_name"] == NULL || $_GET["price"] == NULL
			|| $_GET["categories"] == NULL || $_GET["url"] == NULL))
				echo "Some fields are missing";
			?>
		</p>
	</form>
	<br>
	</div>
	<div>
		<h4>Adding/removing/updating user</h4>
		<form action='./admin.php' method=POST>
		Username: <input type="text" name="uname" value="" placeholder="Name">
		<br>
		New username for an exciting user:<input type="text" name="new_uname" value="" placeholder="New name">
		<br>
		New password: <input type="password" name="new_passwd" value="" placeholder="New pass">
		<br>
		Confirm pass: <input type="password" name="passwd" value="" placeholder="Enter again">
		<br>
		<input type="submit" name="submit" value="Add user">
		<input type="submit" name="submit" value="Delete user">
		<input type="submit" name="submit" value="Update user">
		<br />
		<p>
			<?php
				if ($_POST["submit"] == "Add user" && $_POST["uname"] != NULL && $_POST["new_passwd"] != NULL) {
					if ($_POST["new_passwd"] == $_POST["passwd"]) {
						echo add_user();
					}
					else
					echo "Passwords do not match!";
				}
				elseif ($_POST["submit"] == "Delete user") {
					echo remove_user();
				}
				elseif ($_POST["submit"] == "Update user" && $_POST["uname"] != NULL)
				echo update_item();
				?>
		</p>
	</form>
	<div>
	<br>
	<div>
		<table class="orders">
			<?php
				echo "<tr><th>User login</th><th>Basket</th><th>Total price<th></tr>";
				$data = unserialize(file_get_contents("./data/data"));
				foreach ($data["orders"] as $key => $value) {
					echo "<tr><td>".$value["user"]."</td><td>";
					foreach ($value["basket"] as $basket_val) {
						echo "<span>".$basket_val."; </span>";
					}
			 		echo "</td><td>".$value["total_price"]."</td></tr>";
				}
			?>
		</table>
	</div>
</body></html>
