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
                <li class="tab col s3"><a href="#tab-list-user-type">Listado</a></li>
                <li class="tab col s3"><a href="#tab-add-new-user-type">Agregar</a></li>
              </ul>
            </div>
            <div id="tab-list-user-type" class="col s12">
              <table>
                <thead>
                  <tr>
                    <th>Título</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    $query = sprintf("SELECT * FROM tipos_de_usuarios ORDER BY title ASC;");
                    $sql = mysqli_query($con, $query);
                    $data = array();
                    while($rows= mysqli_fetch_array($sql)){
                      $data_ = array();
                      $data_['title'] = $rows['title'];
                      $data[$rows['id_']] = $data_;
                      echo '<tr class="hoverable" onclick="openModalEdit(\''.$rows['id_'].'\');">
                              <td>'.$rows['title'].'</td>
                            </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <div id="tab-add-new-user-type" class="col s12">
              <div class="col s12">
                <div class="row">
                  <div class="input-field col s12">
                    <i class="material-icons prefix red-text">account_circle</i>
                    <input id="add_new_usuer_type_title" type="text" class="validate">
                    <label for="add_new_usuer_type_title">Título</label>
                  <div class="divider col s12" style="margin-bottom: 1rem;"></div>
                  <div class="col s12 center-align">
                    <a class="waves-effect waves-light btn green center-align" onclick="addNewUserType()"><i class="material-icons left">send</i>Guardar</a>
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
        <h5>¿Estas seguro que deseas agregar el tipo de usuario?</h5>
      </div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a class="modal-close waves-effect waves-green btn green" onclick="addNewUserType(true);">Agregar</a>
      </div>
    </div>

    <div id="modal-alert-add-edit" class="modal">
      <div class="modal-content">
        <h5>Editar tipo de usuario</h5>
        <div class="divider"></div>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix red-text">account_circle</i>
            <input id="add_new_usuer_type_title_edit" type="text" class="validate">
            <label for="add_new_usuer_type_title_edit">Título</label>
          </div>
        </div>
      </div>
      <div class="divider"></div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a onclick="deleteUserTypeMotor();" class="modal-close waves-effect waves-green btn red white-text"><i class="material-icons left white-text">delete</i>Borrar</a>
        <a onclick="edituserType();" class="modal-close waves-effect waves-green btn green"><i class="material-icons left white-text">save</i>Guardar</a>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      var actual_edit = '';
      var _tipos_de_usuarios_ = <?php echo json_encode($data, true);?>;
      document.addEventListener('DOMContentLoaded', function(){
        M.AutoInit();
      });

      function openModalEdit(id){
        actual_edit = id;
        document.getElementById('add_new_usuer_type_title_edit').value = _tipos_de_usuarios_[id]['title'];
        M.Modal.getInstance(document.getElementById('modal-alert-add-edit')).open();
        M.updateTextFields();
      }
    </script>
    <script type="text/javascript">
      function addNewUserType(send=false){
        if(!send){
          M.Modal.getInstance(document.getElementById('modal-alert-add')).open();
          return false;
        }
        var name = document.getElementById('add_new_usuer_type_title');
        if(isValid(name.value)){
          addUserTypeMotor(name.value);
        }else{
          name.click();
          M.toast({html: 'Nombre del tipo de usuario inválido.', classes: 'rounded'});
        }
      }

      function edituserType(){
        var name = document.getElementById('add_new_usuer_type_title_edit');
        if(isValid(name.value)){
          editUserTypeMotor(name.value, actual_edit);
        }else{
          name.click();
          M.toast({html: 'Nombre del tipo de usuario inválido.', classes: 'rounded'});
        }
      }

      function addUserTypeMotor(name){
        var formData = new FormData();
        formData.append('name', name);
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
        xhr.open('POST', 'motores_tipo_de_usuarios/agregarTipoDeUsuario.php');
        xhr.send(formData);
      }

      function editUserTypeMotor(name, id){
        var formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
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
        xhr.open('POST', 'motores_tipo_de_usuarios/editarTipoDeUsuario.php');
        xhr.send(formData);
      }

      function deleteUserTypeMotor(){
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
        xhr.open('POST', 'motores_tipo_de_usuarios/borrarTipoDeUsuario.php');
        xhr.send(formData);
      }

      function isValid(string){
        return string!==undefined&&string!=null&&string!=''&&string!="";
      }
    </script>
  </body>
</html>