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
    <?php
      /*Calculos*/

      //ventas del día
      $query_ventas_del_dia = sprintf("SELECT COUNT(ventas.id_) as cant, SUM(ventas.cantidad_de_articulos*articulos.precio) as total FROM `ventas` INNER JOIN articulos ON articulos.id_ = ventas.articulo_id WHERE DATE(ventas.date_add) = CURRENT_DATE;");
      $sql_ventas_del_dia = mysqli_query($con, $query_ventas_del_dia);
      $array_ventas_del_dia = mysqli_fetch_array($sql_ventas_del_dia);

      //ventas del la semana
      $query_ventas_de_la_semana = sprintf("SELECT COUNT(ventas.id_) as cant, SUM(ventas.cantidad_de_articulos*articulos.precio) as total FROM `ventas` INNER JOIN articulos ON articulos.id_ = ventas.articulo_id WHERE DATE(ventas.date_add) >= CURRENT_DATE-7;");
      $sql_ventas_de_la_semana = mysqli_query($con, $query_ventas_de_la_semana);
      $array_ventas_de_la_semana = mysqli_fetch_array($sql_ventas_de_la_semana);

      //ventas del mes
      $query_ventas_del_mes = sprintf("SELECT COUNT(ventas.id_) as cant, SUM(ventas.cantidad_de_articulos*articulos.precio) as total FROM `ventas` INNER JOIN articulos ON articulos.id_ = ventas.articulo_id WHERE MONTH(ventas.date_add) = MONTH(CURRENT_DATE) AND YEAR(ventas.date_add) = YEAR(CURRENT_DATE);");
      $sql_ventas_del_mes = mysqli_query($con, $query_ventas_del_mes);
      $array_ventas_del_mes = mysqli_fetch_array($sql_ventas_del_mes);

      //ventas totales
      $query_ventas_totales = sprintf("SELECT COUNT(ventas.id_) as cant, SUM(ventas.cantidad_de_articulos*articulos.precio) as total FROM `ventas` INNER JOIN articulos ON articulos.id_ = ventas.articulo_id;");
      $sql_ventas_totales = mysqli_query($con, $query_ventas_totales);
      $array_ventas_totales = mysqli_fetch_array($sql_ventas_totales);


      /**********************************************************************/

      /*Clientes*/
      //clientes del día
      $query_clientes_del_dia = sprintf("SELECT * FROM `clientes` WHERE DATE(clientes.date_add) = CURRENT_DATE");
      $sql_clientes_del_dia = mysqli_query($con, $query_clientes_del_dia);

      //clientes del la semana
      $query_clientes_de_la_semana = sprintf("SELECT * FROM `clientes` WHERE DATE(clientes.date_add) >= CURRENT_DATE-7;");
      $sql_clientes_de_la_semana = mysqli_query($con, $query_clientes_de_la_semana);

      //clientes del mes
      $query_clientes_del_mes = sprintf("SELECT * FROM `clientes` WHERE MONTH(clientes.date_add) = MONTH(CURRENT_DATE) AND YEAR(clientes.date_add) = YEAR(CURRENT_DATE);");
      $sql_clientes_del_mes = mysqli_query($con, $query_clientes_del_mes);

      //clientes totales
      $query_clientes_totales = sprintf("SELECT * FROM `clientes`");
      $sql_clientes_totales = mysqli_query($con, $query_clientes_totales);
    ?>
    <main>
      <div class="row">
        <div class="col s12">
          <h3 class="center-align">Ventas</h3>
        </div>
        <div class="col s12 divider"></div>
        <div class="col s12">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de ventas</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo $array_ventas_totales['cant'];?> ventas</h2>
            <div class="divider"></div>
            <span class="green-text bold center-align">Total: <?php echo number_format($array_ventas_totales['total'], 0, ',', '.')?> Gs</span>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de ventas del día</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo $array_ventas_del_dia['cant'];?> ventas</h2>
            <div class="divider"></div>
            <span class="green-text bold center-align">Total: <?php echo number_format($array_ventas_del_dia['total'], 0, ',', '.')?> Gs</span>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de ventas la semana</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo $array_ventas_de_la_semana['cant'];?> ventas</h2>
            <div class="divider"></div>
            <span class="green-text bold center-align">Total: <?php echo number_format($array_ventas_de_la_semana['total'], 0, ',', '.')?> Gs</span>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de ventas del mes</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo $array_ventas_del_mes['cant'];?> ventas</h2>
            <div class="divider"></div>
            <span class="green-text bold center-align">Total: <?php echo number_format($array_ventas_del_mes['total'], 0, ',', '.')?> Gs</span>
          </div>
        </div>

        <div class="col s12">
          <div class="card">
            <span>Últimas 10 ventas</span>
            <div class="divider"></div>
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
                    $query = sprintf("SELECT ventas.id_, ventas.cliente_id, ventas.articulo_id, ventas.cantidad_de_articulos, ventas.date_add, clientes.nombre, clientes.apellido, articulos.titulo as articulo_title, articulos.precio FROM ventas INNER JOIN clientes on clientes.id_ = ventas.cliente_id INNER JOIN articulos ON articulos.id_ = ventas.articulo_id ORDER BY ventas.date_add DESC LIMIT 0, 10;");
                    $sql = mysqli_query($con, $query);
                    while($rows= mysqli_fetch_array($sql)){
                      echo '<tr>
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
        </div>
        <div class="col s12 divider"></div>




        <div class="col s12">
          <h3 class="center-align">Cientes</h3>
        </div>
        <div class="col s12 divider"></div>
        <div class="col s12">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de clientes</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo mysqli_num_rows($sql_clientes_totales)?> clientes</h2>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de clientes nuevos hoy</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo mysqli_num_rows($sql_clientes_del_dia)?> clientes</h2>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de clientes nuevos de la semana</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo mysqli_num_rows($sql_clientes_de_la_semana)?> clientes</h2>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="card">
            <span style="font-size: 1.3rem;text-align: center;width: 100%;" class="black-text center-align">Cantidad de clientes nuevos del mes</span>
            <div class="divider"></div>
            <h2 class="red-text center-align"><?php echo mysqli_num_rows($sql_clientes_del_mes)?> clientes</h2>
          </div>
        </div>
        <div class="col s12 divider"></div>
      </div>
    </main>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
      document.addEvebtListener('DOMContetnLoaded', function(){
        M.AutoInit();
      })
    </script>
  </body>
</html>