<!DOCTYPE html>
<html>
<head>
	<!--Import Google Icon Font-->
  <?php
    include 'db_config.php';
    $con = mysqli_connect($SERVER,$DB_USER,$PASS,$DB_NAME)or die('{"error":true,"error_info":"Imposible to connect with database","error_number":4}');
  ?>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Iniciar Sesión</title>
</head>
<body>
	<div class="container valign-wrapper center-align cont-card">
      <div class="card login center hoverable" id="card-login" style="padding-left: 2%;padding-right: 2%;">
        <div style="width: 100%;font-size: 2rem;">Bienvenido</div>
        <div class="divider" style="margin-bottom: 5px;"></div>
        <div class="row">
            <div class="input-field col s12">
              <input id="password" type="password" class="validate">
              <label for="password">Contraseña</label>
            </div>
        </div>
         <a class="btn-floating btn-large waves-effect waves-light green center" id="login-btn" style="margin-bottom: -28px;"><i class="material-icons">check</i></a>
      </div>    
    </div>
    <style type="text/css">
      .login{
        min-width: 100px;
        min-height: 100px;
        width: 70%;
        margin-left: 14.5%;
      }
      .cont-card{
        height: 95vh;
      }
      .card{
        border-radius: .7rem;
      }
      body{
        background-color: #0b1003b0 !important;
      }
    </style>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function(){
        M.AutoInit();
      });
    </script>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded',function(){
        document.getElementsByTagName('body')[0].className='';
        document.getElementById('login-btn').addEventListener('click', function(){
        	var pass=document.getElementById('password').value;
	        if(isInValid(pass))
	        {
            M.toast({html : "Error, contraseña invalida", displayLength : 3000});
	        }else{
            login(pass);
	        }
        });

      });
      function isInValid(value)
      {
        return value===undefined||value==null||value==""||value=="null";
      }
      function login(pass)
      {
        var formData = new FormData();
          formData.append('code_send', pass);
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4){
                try {
                  if(xhr.responseText=="pass")
                  {
                    window.location.href = '<?php echo '/renato/'?>';
                  } 
                  else
                  {
                    console.log(xhr.responseText);
                    M.toast({html : xhr.responseText, displayLength : 3000}); 
                  } 
                }
                catch (err) {
                  console.log(xhr.responseText)
                  console.log(err);
                  M.toast({html : err, displayLength : 3000});
                }
              }
          };
          xhr.open('POST', 'login_wall.php');
          xhr.send(formData);
      }
    </script>
</body>
</html>