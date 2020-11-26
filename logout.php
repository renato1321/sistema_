<?php
	session_start();
	unset($_SESSION['user_id_']);
	header("Location:login.php");
?>