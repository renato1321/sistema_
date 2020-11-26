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
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>C.I / R.U.C</th>
                      <th>Telefono</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                    $query = sprintf("SELECT * FROM clientes ORDER BY nombre ASC;");
                    $sql = mysqli_query($con, $query);
                    $data = array();
                    while($rows= mysqli_fetch_array($sql)){
                      $data_ = array();
                      $data_['nombre'] = $rows['nombre'];
                      $data_['apellido'] = $rows['apellido'];
                      $data_['ci_o_ruc'] = $rows['ci_o_ruc'];
                      $data_['telefono'] = $rows['telefono'];
                      $data[$rows['id_']] = $data_;
                      echo '<tr class="hoverable" onclick="openModalEdit(\''.$rows['id_'].'\');">
                              <td>'.$rows['nombre'].'</td>
                              <td>'.$rows['apellido'].'</td>
                              <td>'.$rows['ci_o_ruc'].'</td>
                              <td>'.$rows['telefono'].'</td>
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
                    <input id="add_new_client_name" type="text" class="validate">
                    <label for="add_new_client_name">Nombre</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <i class="material-icons prefix orange-text">account_circle</i>
                    <input id="add_new_client_lat_name" type="text" class="validate">
                    <label for="add_new_client_lat_name">Apellido</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <i class="material-icons prefix green-text">account_box</i>
                    <input id="add_new_client_ci" type="text" class="validate">
                    <label for="add_new_client_ci">C.I / R.U.C</label>
                    <span class="helper-text">Ejemplo: 13245678 o 12345678-9</span>
                  </div>
                  <div class="input-field col s12 m6 blue-text">
                    <i class="material-icons prefix">phone</i>
                    <input id="add_new_client_phone_number" type="text" class="validate">
                    <label for="add_new_client_phone_number">Telefono</label>
                    <span class="helper-text">Ejemplo: +595971123456</span>
                  </div>
                  <div class="divider col s12" style="margin-bottom: 1rem;"></div>
                  <div class="col s12 center-align">
                    <a class="waves-effect waves-light btn green center-align" onclick="addNewClient()"><i class="material-icons left">send</i>Guardar</a>
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
        <h5>¿Estas seguro que deseas agregar el cliente?</h5>
      </div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a class="modal-close waves-effect waves-green btn green" onclick="addNewClient(true);">Agregar</a>
      </div>
    </div>

    <div id="modal-alert-add-edit" class="modal">
      <div class="modal-content">
        <h5>Editar cliente</h5>
        <div class="divider"></div>
        <div class="row">
          <div class="input-field col s12 m6">
            <i class="material-icons prefix red-text">account_circle</i>
            <input id="add_new_client_name_edit" type="text" class="validate">
            <label for="add_new_client_name_edit">Nombre</label>
          </div>
          <div class="input-field col s12 m6">
            <i class="material-icons prefix orange-text">account_circle</i>
            <input id="add_new_client_lat_name_edit" type="text" class="validate">
            <label for="add_new_client_lat_name_edit">Apellido</label>
          </div>
          <div class="input-field col s12 m6">
            <i class="material-icons prefix green-text">account_box</i>
            <input id="add_new_client_ci_edit" type="text" class="validate">
            <label for="add_new_client_ci_edit">C.I / R.U.C</label>
            <span class="helper-text">Ejemplo: 13245678 o 12345678-9</span>
          </div>
          <div class="input-field col s12 m6 blue-text">
            <i class="material-icons prefix">phone</i>
            <input id="add_new_client_phone_number_edit" type="text" class="validate">
            <label for="add_new_client_phone_number_edit">Telefono</label>
            <span class="helper-text">Ejemplo: +595971123456</span>
          </div>
        </div>
      </div>
      <div class="divider"></div>
      <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a onclick="deleteClientMotor();" class="modal-close waves-effect waves-green btn red white-text"><i class="material-icons left white-text">delete</i>Borrar</a>
        <a onclick="editClient();" class="modal-close waves-effect waves-green btn green"><i class="material-icons left white-text">save</i>Guardar</a>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      var actual_edit = '';
      var _clientes_ = <?php echo json_encode($data, true);?>;
      document.addEventListener('DOMContentLoaded', function(){
        M.AutoInit();
      });

      function openModalEdit(id){
        actual_edit = id;
        document.getElementById('add_new_client_name_edit').value = _clientes_[id]['nombre'];
        document.getElementById('add_new_client_lat_name_edit').value = _clientes_[id]['apellido'];
        document.getElementById('add_new_client_ci_edit').value = _clientes_[id]['ci_o_ruc'];
        document.getElementById('add_new_client_phone_number_edit').value = _clientes_[id]['telefono'];
        M.Modal.getInstance(document.getElementById('modal-alert-add-edit')).open();
        M.updateTextFields();
      }
    </script>
    <script type="text/javascript">
      function addNewClient(send=false){
        if(!send){
          M.Modal.getInstance(document.getElementById('modal-alert-add')).open();
          return false;
        }
        var name = document.getElementById('add_new_client_name');
        var last_name = document.getElementById('add_new_client_lat_name');
        var ci = document.getElementById('add_new_client_ci');
        var phone_number = document.getElementById('add_new_client_phone_number');
        if(isValid(name.value)){
          if(isValid(last_name.value)){
            if(isValidCIOrRUC(ci.value)){
              if(isValidPhoneNumber(phone_number.value)){
                addClientMotor(name.value, last_name.value, ci.value, phone_number.value);
              }else{
                phone_number.focus();
                M.toast({html: 'Número de telefono inválido. Debe seguir el formato de ejemplo.', classes: 'rounded'});
              }
            }else{
              ci.focus();
              M.toast({html: 'Número de cedula o RUC inválido.', classes: 'rounded'});    
            }
          }else{
            last_name.focus();
            M.toast({html: 'Apellido del cliente inválido.', classes: 'rounded'});  
          }
        }else{
          name.click();
          M.toast({html: 'Nombre del cliente inválido.', classes: 'rounded'});
        }
      }

      function editClient(){
        var name = document.getElementById('add_new_client_name_edit');
        var last_name = document.getElementById('add_new_client_lat_name_edit');
        var ci = document.getElementById('add_new_client_ci_edit');
        var phone_number = document.getElementById('add_new_client_phone_number_edit');
        if(isValid(name.value)){
          if(isValid(last_name.value)){
            if(isValidCIOrRUC(ci.value)){
              if(isValidPhoneNumber(phone_number.value)){
                editClientMotor(name.value, last_name.value, ci.value, phone_number.value, actual_edit);
              }else{
                phone_number.focus();
                M.toast({html: 'Número de telefono inválido. Debe seguir el formato de ejemplo.', classes: 'rounded'});
              }
            }else{
              ci.focus();
              M.toast({html: 'Número de cedula o RUC inválido.', classes: 'rounded'});    
            }
          }else{
            last_name.focus();
            M.toast({html: 'Apellido del cliente inválido.', classes: 'rounded'});  
          }
        }else{
          name.click();
          M.toast({html: 'Nombre del cliente inválido.', classes: 'rounded'});
        }
      }

      function addClientMotor(name, last_name, ci, phone){
        var formData = new FormData();
        formData.append('name', name);
        formData.append('last_name', last_name);
        formData.append('ci', ci);
        formData.append('phone', phone);
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
        xhr.open('POST', 'motores_clientes/agregarCliente.php');
        xhr.send(formData);
      }

      function editClientMotor(name, last_name, ci, phone, id){
        var formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('last_name', last_name);
        formData.append('ci', ci);
        formData.append('phone', phone);
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
        xhr.open('POST', 'motores_clientes/editarCliente.php');
        xhr.send(formData);
      }

      function deleteClientMotor(){
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
        xhr.open('POST', 'motores_clientes/borrarCliente.php');
        xhr.send(formData);
      }

      function isValidCIOrRUC(value){
        if(Number.isInteger(parseInt(value))){
          return true;
        }else{
          return value.match('[0-9]{1,8}-[0-9]{1}')!=null;
        }
        return false;
      }

      function isValidPhoneNumber(value){
        if(!isValid(value)){
          return false;
        }
        return value.match("\\+5959[6-9][0-9]{7}")!=null;
      }

      function isValid(string){
        return string!==undefined&&string!=null&&string!=''&&string!="";
      }
    </script>
  </body>
</html>