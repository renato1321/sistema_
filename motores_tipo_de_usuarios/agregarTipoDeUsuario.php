<?php
	include '../conection.php';
	if(isset($_POST['name'])){
		$query = sprintf("INSERT INTO tipos_de_usuarios(title) VALUES('%s');", mysqli_real_escape_string($con, $_POST['name']));
		$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
		die('{"error": false}');
	}else{
		die('{"error": true, "error_info": "No se encontró el título para tipo de usuario."}');
	}
?>