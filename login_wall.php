<?php
	if (isset($_POST['code_send'])) {
		if(sha1($_POST['code_send'])==file_get_contents("secure/3645"))
		{
			session_start();
			$_SESSION['user_id_']=session_id();
			echo "pass";
		}
	}
?>