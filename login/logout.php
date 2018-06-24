<?php
session_start();
$_SESSION[loggued_on_user] = "";
header('Location: http://localhost:8100/index.php');
?>