<?php
	include '../conection.php';
	if(isset($_POST['client_id'])){
		if(isset($_POST['article_id'])){
			if(isset($_POST['cant_articles'])){
				if(isset($_POST['id'])){
					$query = sprintf("UPDATE ventas set cliente_id='%s', articulo_id='%s',	cantidad_de_articulos='%s' WHERE id_='%s';", mysqli_real_escape_string($con, $_POST['client_id']),
						mysqli_real_escape_string($con, $_POST['article_id']),
						mysqli_real_escape_string($con, $_POST['cant_articles']),mysqli_real_escape_string($con, $_POST['id']));
					$sql = mysqli_query($con, $query) or die('{"error": true, "error_info": "No se pudo procesar, intente nuevamente. Si el problema persiste pague más dinero."}');
					die('{"error": false}');
				}else{
					die('{"error": true, "error_info": "ID no encontrado."}');	
				}
			}else{
				die('{"error": true, "error_info": "No se encontró la cantidad de articulos."}');
			}
		}else{
			die('{"error": true, "error_info": "No se encontró el ID del articulo."}');
		}
	}else{
		die('{"error": true, "error_info": "No se encontró el ID del cliente."}');
	}
?>