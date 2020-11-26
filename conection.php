<?php
	session_start();
	if(!isset($_SESSION['user_id_'])){
		header('Location:login.php');
	}
	include 'db_config.php';
	$con = mysqli_connect($SERVER,$DB_USER,$PASS,$DB_NAME)or die('{"error":true,"error_info":"Imposible to connect with database","error_number":4}');
?>