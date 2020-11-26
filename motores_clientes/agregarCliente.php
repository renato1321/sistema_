<?php
	include '../conection.php';
	if(isset($_POST['name'])){
		if(isset($_POST['last_name'])){
			if(isset($_POST['ci'])){
				if(isset($_POST['phone'])){
					$query = sprintf("INSERT INTO clientes(nombre, apellido, ci_o_ruc, telefono) VALUES('%s', '%s', '%s', '%s');", mysqli_real_escape_string($con, $_POST['name']),
						mysqli_real_escape_string($con, $_POST['last_name']),
						mysqli_real_escape_string($con, $_POST['ci']),
						mysqli_real_escape_string($con, $_POST['phone']));
					$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
					die('{"error": false}');
				}else{
					die('{"error": true, "error_info": "No se encontró el número de telefono del cliente."}');
				}
			}else{
				die('{"error": true, "error_info": "No se encontró la cedula o RUC del cliente."}');
			}
		}else{
			die('{"error": true, "error_info": "No se encontró el apellido del cliente."}');
		}
	}else{
		die('{"error": true, "error_info": "No se encontró el nombre del cliente."}');
	}
?>