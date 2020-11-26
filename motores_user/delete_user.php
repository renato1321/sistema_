<?php
	include '../conection.php';
	if(isset($_POST['id'])){
		$query = sprintf("DELETE FROM usuarios WHERE id_='%s';",				mysqli_real_escape_string($con, $_POST['id']));
		$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
		die('{"error": false}');
	}else{
		die('{"error": true, "error_info": "ID no encontrado."}');
	}
?>