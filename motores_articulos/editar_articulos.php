<?php
	include '../conection.php';
	if(isset($_POST['title'])){
		if(isset($_POST['id'])){
			if(isset($_POST['descripcion'])){
				if(isset($_POST['precio'])){
					$query = sprintf("UPDATE articulos set titulo = '%s', descripcion='%s', precio='%s' WHERE id_='%s';", mysqli_real_escape_string($con, $_POST['title']),mysqli_real_escape_string($con, $_POST['descripcion']),mysqli_real_escape_string($con, $_POST['precio']), mysqli_real_escape_string($con, $_POST['id']));
					$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
					die('{"error": false}');
				}else{
					die('{"error": true, "error_info": "Precio no encontrado"}');
				}
			}else{
				die('{"error": true, "error_info": "Descripción no encontrada."}');
			}
		}else{
			die('{"error": true, "error_info": "Id no encontrado."}');
		}
	}else{
		die('{"error": true, "error_info": "No se encontró el título para el artículo"}');
	}
?>