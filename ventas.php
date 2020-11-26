<?php
  include 'general.php';
?>  
<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body class="grey lighten-3">
    <?php 
      include 'menu.php';
    ?>  
    <main>
     <div style="padding: 1rem;">
        <div class="card">
          <div class="row">
            <div class="col s12">
              <ul class="tabs tabs-fixed-width">
                <li class="tab col s3"><a href="#tab-list-client">Listado</a></li>
                <li class="tab col s3"><a href="#tab-add-new-client">Agregar</a></li>
              </ul>
            </div>
            <div id="tab-list-client" class="col s12">
              <table>
                <thead>
                  <tr>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Articulo</th>
                      <th>Cantidad</th>
                      <th>Total</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    $query = sprintf("SELECT ventas.id_, ventas.cliente_id, ventas.articulo_id, ventas.cantidad_de_articulos, ventas.date_add, clientes.nombre, clientes.apellido, articulos.titulo as articulo_title, articulos.precio FROM ventas INNER JOIN clientes on clientes.id_ = ventas.cliente_id INNER JOIN articulos ON articulos.id_ = ventas.articulo_id ORDER BY ventas.date_add DESC;");
                    $sql = mysqli_query($con, $query);
                    $data = array();
                    while($rows= mysqli_fetch_array($sql)){
                      $data_ = array();
                      $data_['cliente_id'] = $rows['cliente_id'];
                      $data_['article_id'] = $rows['articulo_id'];
                      $data_['cantidad_de_articulos'] = $rows['cantidad_de_articulos'];
                      $data[$rows['id_']] = $data_;
                      echo '<tr class="hoverable" onclick="openModalEdit(\''.$rows['id_'].'\');">
                              <td class="orange-text bold">'.$rows['date_add'].'</td>
                              <td>'.$rows['nombre'].'&nbsp;'.$rows['apellido'].'</td>
                              <td class="bold">'.$rows['articulo_title'].'</td>
                              <td  class="red-text">'.$rows['cantidad_de_articulos'].'</td>
                              <td  class="red-text bold">'.number_format((((int)$rows['cantidad_de_articulos'])*((int)$rows['precio'])), 0, ',', '.').'</td>
                            </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <div id="tab-add-new-client" class="col s12">
              <div class="col s12">
                <div class="row">
                  <div class="input-field col s12">
                    <select id="add-new-sale-client">
                      <?php
                        $query = sprintf("SELECT * FROM clientes ORDER BY nombre ASC;");
                        $sql = mysqli_query($con, $query);
                        while($rows= mysqli_fetch_array($sql)){
                          echo '<option value="'.$rows['id_'].'">'.$rows['nombre'].'&nbsp;'.$rows['apellido'].'</option>';
                        }
                      ?>
                    </select>
                    <label>Cliente</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <select id="add-new-sale-article">
                      <?php
                        $query = sprintf("SELECT * FROM articulos ORDER BY titulo ASC;");
                        $sql = mysqli_query($con, $query);
                        while($rows= mysqli_fetch_array($sql)){
                          echo '<option value="'.$rows['id_'].'">'.$rows['titulo'].'</option>';
                        }
                      ?>
                    </select>
                    <label>Artículo</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input id="add_sale_cant_articles" type="number" class="validate">
                    <label for="add_sale_cant_articles">Cantidad de artículos</label>
                  </div>
                  <div class="divider col s12" style="margin-bottom: 1rem;"></div>
                  <div class="col s12 center-align">
                    <a class="waves-effect waves-light btn green center-align" onclick="addNewSale()"><i class="material-icons left">send</i>Guardar</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
    </main>

    <div id="modal-alert-add" class="modal modal-alert">
      <div class="modal-content">
        <h5>¿Estas seguro que deseas agregar la venta?</h5>
      </div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a class="modal-close waves-effect waves-green btn green" onclick="addNewSale(true);">Agregar</a>
      </div>
    </div>

    <div id="modal-alert-add-edit" class="modal">
      <div class="modal-content">
        <h5>Editar cliente</h5>
        <div class="divider"></div>
        <div class="row">
          <div class="input-field col s12">
            <select id="add-new-sale-client_edit">
              <?php
                $query = sprintf("SELECT * FROM clientes ORDER BY nombre ASC;");
                $sql = mysqli_query($con, $query);
                while($rows= mysqli_fetch_array($sql)){
                  echo '<option value="'.$rows['id_'].'">'.$rows['nombre'].'&nbsp;'.$rows['apellido'].'</option>';
                }
              ?>
            </select>
            <label>Cliente</label>
          </div>
          <div class="input-field col s12 m6">
            <select id="add-new-sale-article_edit">
              <?php
                $query = sprintf("SELECT * FROM articulos ORDER BY titulo ASC;");
                $sql = mysqli_query($con, $query);
                while($rows= mysqli_fetch_array($sql)){
                  echo '<option value="'.$rows['id_'].'">'.$rows['titulo'].'</option>';
                }
              ?>
            </select>
            <label>Artículo</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="add_sale_cant_articles_edit" type="number" class="validate">
            <label for="add_sale_cant_articles_edit">Cantidad de artículos</label>
          </div>
        </div>
      </div>
      <div class="divider"></div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a onclick="deleteSaleMotor();" class="modal-close waves-effect waves-green btn red white-text"><i class="material-icons left white-text">delete</i>Borrar</a>
        <a onclick="editSale();" class="modal-close waves-effect waves-green btn green"><i class="material-icons left white-text">save</i>Guardar</a>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      var actual_edit = '';
      var _ventas_ = <?php echo json_encode($data, true);?>;
      document.addEventListener('DOMContentLoaded', function(){
        M.AutoInit();
      });

      function openModalEdit(id){
        actual_edit = id;
        /*Iinicializar selector de cliente*/
        var select_edit_client_id = document.getElementById('add-new-sale-client_edit');
        var instace_client= M.FormSelect.getInstance(select_edit_client_id);
        instace_client.destroy();
        select_edit_client_id.value = _ventas_[id]['cliente_id'];
        document.getElementById('add_sale_cant_articles_edit').value = _ventas_[id]['cantidad_de_articulos'];
        M.FormSelect.init(select_edit_client_id);
        /***********************************/

        /*Iinicializar selector de articulo*/
        var select_edit_article_id = document.getElementById('add-new-sale-article_edit');
        var instace_article= M.FormSelect.getInstance(select_edit_article_id);
        instace_article.destroy();
        select_edit_article_id.value = _ventas_[id]['article_id'];
        document.getElementById('add_sale_cant_articles_edit').value = _ventas_[id]['cantidad_de_articulos'];
        M.FormSelect.init(select_edit_article_id);
        /***********************************/
        M.Modal.getInstance(document.getElementById('modal-alert-add-edit')).open();
        M.updateTextFields();
      }
    </script>
    <script type="text/javascript">
      function addNewSale(send=false){
        if(!send){
          M.Modal.getInstance(document.getElementById('modal-alert-add')).open();
          return false;
        }
        var cliente = document.getElementById('add-new-sale-client');
        var articulo = document.getElementById('add-new-sale-article');
        var cantidad_de_articulos = document.getElementById('add_sale_cant_articles');
        if(isValid(cliente.value)){
          if(isValid(articulo.value)){
            if(isValid(cantidad_de_articulos.value)){
              if(!isNaN(cantidad_de_articulos.value)){
                addSaleMotor(cliente.value, articulo.value, cantidad_de_articulos.value);
              }else{
                cantidad_de_articulos.focus();
                M.toast({html: 'Cantidad de artículos debe ser un número.', classes: 'rounded'});    
              }
            }else{
              cantidad_de_articulos.focus();
              M.toast({html: 'Cantidad de artículos invalida.', classes: 'rounded'});    
            }
          }else{
            articulo.focus();
            M.toast({html: 'Articulo inválido.', classes: 'rounded'});  
          }
        }else{
          cliente.click();
          M.toast({html: 'Cliente inválido.', classes: 'rounded'});
        }
      }

      function editSale(){
        var cliente = document.getElementById('add-new-sale-client_edit');
        var articulo = document.getElementById('add-new-sale-article_edit');
        var cantidad_de_articulos = document.getElementById('add_sale_cant_articles_edit');
        if(isValid(cliente.value)){
          if(isValid(articulo.value)){
            if(isValid(cantidad_de_articulos.value)){
              if(!isNaN(cantidad_de_articulos.value)){
                editSaleMotor(cliente.value, articulo.value, cantidad_de_articulos.value);
              }else{
                cantidad_de_articulos.focus();
                M.toast({html: 'Cantidad de artículos debe ser un número.', classes: 'rounded'});    
              }
            }else{
              cantidad_de_articulos.focus();
              M.toast({html: 'Cantidad de artículos invalida.', classes: 'rounded'});    
            }
          }else{
            articulo.focus();
            M.toast({html: 'Articulo inválido.', classes: 'rounded'});  
          }
        }else{
          cliente.click();
          M.toast({html: 'Cliente inválido.', classes: 'rounded'});
        }
      }

      function addSaleMotor(cliente, articulo, cantidad_de_articulos){
        var formData = new FormData();
        formData.append('client_id', cliente);
        formData.append('article_id', articulo);
        formData.append('cant_articles', cantidad_de_articulos);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4){
            try{
              var JSONObject_ = JSON.parse(xhr.responseText);
              if(JSONObject_['error']){
                console.error(JSONObject_['error_info']);
                M.toast({html: JSONObject_['error_info'], classes: 'rounded'});
              }else{
                M.toast({html: 'Agregado con éxito!', classes: 'rounded pulse green bold'});
                location.reload();
              }
            }catch(err){
              console.error(err);
              M.toast({html: err, classes: 'rounded'});
            }
          }
        }
        xhr.open('POST', 'motores_ventas/agregarVenta.php');
        xhr.send(formData);
      }

      function editSaleMotor(cliente, articulo, cantidad_de_articulos){
        var formData = new FormData();
        formData.append('id', actual_edit);
        formData.append('client_id', cliente);
        formData.append('article_id', articulo);
        formData.append('cant_articles', cantidad_de_articulos);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4){
            try{
              var JSONObject_ = JSON.parse(xhr.responseText);
              if(JSONObject_['error']){
                console.error(JSONObject_['error_info']);
                M.toast({html: JSONObject_['error_info'], classes: 'rounded'});
              }else{
                M.toast({html: 'Modificado con éxito!', classes: 'rounded pulse orange bold'});
                location.reload();
              }
            }catch(err){
              console.error(err);
              M.toast({html: err, classes: 'rounded'});
            }
          }
        }
        xhr.open('POST', 'motores_ventas/editarVenta.php');
        xhr.send(formData);
      }

      function deleteSaleMotor(){
        var formData = new FormData();
        formData.append('id', actual_edit);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4){
            try{
              var JSONObject_ = JSON.parse(xhr.responseText);
              if(JSONObject_['error']){
                console.error(JSONObject_['error_info']);
                M.toast({html: JSONObject_['error_info'], classes: 'rounded'});
              }else{
                M.toast({html: 'Borrado con éxito!', classes: 'rounded pulse red bold'});
                location.reload();
              }
            }catch(err){
              console.error(err);
              M.toast({html: err, classes: 'rounded'});
            }
          }
        }
        xhr.open('POST', 'motores_ventas/borrarVenta.php');
        xhr.send(formData);
      }

      function isValid(string){
        return string!==undefined&&string!=null&&string!=''&&string!="";
      }
    </script>
  </body>
</html>