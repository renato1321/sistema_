<?php
	include '../conection.php';
	if(isset($_POST['name'])){
		if(isset($_POST['id'])){
			$query = sprintf("UPDATE usuario set title = '%s' WHERE id_='%s';", mysqli_real_escape_string($con, $_POST['name']), mysqli_real_escape_string($con, $_POST['id']));
			$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
			die('{"error": false}');
		}else{
			die('{"error": true, "error_info": "Id no encontrado."}');
		}
	}else{
		die('{"error": true, "error_info": "No se encontró el título para tipo de usuario."}');
	}
?>