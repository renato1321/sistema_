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
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    $query = sprintf("SELECT * FROM articulos ORDER BY titulo ASC;");
                    $sql = mysqli_query($con, $query);
                    $data = array();
                    while($rows= mysqli_fetch_array($sql)){
                      $data_ = array();
                      $data_['title'] = $rows['titulo'];
                      $data_['description'] = $rows['descripcion'];
                      $data_['precio'] = $rows['precio'];
                      $data[$rows['id_']] = $data_;
                      echo '<tr class="hoverable" onclick="openModalEdit(\''.$rows['id_'].'\');">
                              <td>'.$rows['titulo'].'</td>
                              <td>'.$rows['descripcion'].'</td>
                              <td>'.$rows['precio'].'</td>
                            </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <div id="tab-add-new-client" class="col s12">
              <div class="col s12">
                <div class="row">
                  <div class="input-field col s12 m6">
                    <i class="material-icons prefix red-text">account_circle</i>
                    <input id="add_article_title" type="text" class="validate">
                    <label for="add_article_title">Título</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <i class="material-icons prefix orange-text">account_circle</i>
                    <input id="add_artitcle_description" type="text" class="validate">
                    <label for="add_artitcle_description">Descripción</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <i class="material-icons prefix orange-text">account_circle</i>
                    <input id="add_artitcle_price" type="number" class="validate">
                    <label for="add_artitcle_price">Precio</label>
                  </div>
                  <div class="divider col s12" style="margin-bottom: 1rem;"></div>
                  <div class="col s12 center-align">
                    <a class="waves-effect waves-light btn green center-align" onclick="addNewArticle()"><i class="material-icons left">send</i>Guardar</a>
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
        <h5>¿Estas seguro que deseas agregar el articulo?</h5>
      </div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a class="modal-close waves-effect waves-green btn green" onclick="addNewArticle(true);">Agregar</a>
      </div>
    </div>

    <div id="modal-alert-add-edit" class="modal">
      <div class="modal-content">
        <h5>Editar cliente</h5>
        <div class="divider"></div>
          <div class="row">
            <div class="input-field col s12 m6">
              <i class="material-icons prefix red-text">account_circle</i>
              <input id="add_article_title_edit" type="text" class="validate">
              <label for="add_article_title_edit">Título</label>
            </div>
            <div class="input-field col s12 m6">
              <i class="material-icons prefix orange-text">account_circle</i>
              <input id="add_artitcle_description_edit" type="text" class="validate">
              <label for="add_artitcle_description_edit">Descripción</label>
            </div>
            <div class="input-field col s12 m6">
              <i class="material-icons prefix orange-text">account_circle</i>
              <input id="add_artitcle_price_edit" type="number" class="validate">
              <label for="add_artitcle_price_edit">Precio</label>
            </div>
          </div>
      <div class="divider"></div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a onclick="deleteArticleMotor();" class="modal-close waves-effect waves-green btn red white-text"><i class="material-icons left white-text">delete</i>Borrar</a>
        <a onclick="editArticle();" class="modal-close waves-effect waves-green btn green"><i class="material-icons left white-text">save</i>Guardar</a>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      var actual_edit = '';
      var _articles_ = <?php echo json_encode($data, true);?>;
      document.addEventListener('DOMContentLoaded', function(){
        M.AutoInit();
      });

      function openModalEdit(id){
        actual_edit = id;
        document.getElementById('add_article_title_edit').value = _articles_[id]['title'];
        document.getElementById('add_artitcle_description_edit').value = _articles_[id]['description'];
        document.getElementById('add_artitcle_price_edit').value = _articles_[id]['precio'];
        M.Modal.getInstance(document.getElementById('modal-alert-add-edit')).open();
        M.updateTextFields();
      }
    </script>
    <script type="text/javascript">
      function addNewArticle(send=false){
        if(!send){
          M.Modal.getInstance(document.getElementById('modal-alert-add')).open();
          return false;
        }
        var title = document.getElementById('add_article_title');
        var description = document.getElementById('add_artitcle_description');
        var price = document.getElementById('add_artitcle_price');
        if(isValid(title.value)){
          if(isValid(description.value)){
            if(!isNaN(price.value)){
              addArticleMotor(title.value, description.value, price.value);
            }else{
              price.focus();
              M.toast({html: 'Precio invalido.', classes: 'rounded'});
            }
          }else{
            description.focus();
            M.toast({html: 'Descripción invalida.', classes: 'rounded'});  
          }
        }else{
          title.click();
          M.toast({html: 'Título invalido.', classes: 'rounded'});
        }
      }

      function editArticle(){
        var title = document.getElementById('add_article_title_edit');
        var description = document.getElementById('add_artitcle_description_edit');
        var price = document.getElementById('add_artitcle_price_edit');
        if(isValid(title.value)){
          if(isValid(description.value)){
            if(!isNaN(price.value)){
              editArticleMotor(title.value, description.value, price.value);
            }else{
              price.focus();
              M.toast({html: 'Precio invalido.', classes: 'rounded'});
            }
          }else{
            description.focus();
            M.toast({html: 'Descripción invalida.', classes: 'rounded'});  
          }
        }else{
          title.click();
          M.toast({html: 'Título invalido.', classes: 'rounded'});
        }
      }

      function addArticleMotor(title, description, precio){
        var formData = new FormData();
        formData.append('title', title);
        formData.append('descripcion', description);
        formData.append('precio', precio);
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
        xhr.open('POST', 'motores_articulos/agregar_articulos.php');
        xhr.send(formData);
      }

      function editArticleMotor(title, description, precio){
        var formData = new FormData();
        formData.append('id', actual_edit);
        formData.append('title', title);
        formData.append('descripcion', description);
        formData.append('precio', precio);
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
        xhr.open('POST', 'motores_articulos/editar_articulos.php');
        xhr.send(formData);
      }

      function deleteArticleMotor(){
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
        xhr.open('POST', 'motores_articulos/eliminar_articulos.php');
        xhr.send(formData);
      }

      function isValid(string){
        return string!==undefined&&string!=null&&string!=''&&string!="";
      }
    </script>
  </body>
</html>