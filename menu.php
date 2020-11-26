<style type="text/css">
      header, main, footer, nav {
        padding-left: 300px;
      }

      @media only screen and (max-width : 992px) {
        header, main, footer, nav {
          padding-left: 0;
        }
      }
      .bold{
        font-weight: bold !important;
      }
      main{
        padding-top: 2rem;
      }
      .card, .modal-alert, .modal{
        padding: .5rem;
        border-radius: .6rem;
      }
      .modal-alert{
        max-width: 300px !important;
      }
      .hoverable{
        cursor: pointer;
      }
    </style>
    <nav class="blue">
      <div class="nav-wrapper">
        <a href="#" data-target="slide-out" class="sidenav-trigger left"><i class="material-icons">menu</i></a>
        <a class="brand-logo center bold white-text">Logo</a>
      </div>
    </nav>
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li class="subheader"><a class="subheader center">Panel</a></li>
      <li class="divider"></li>
      <li><a href="index.php"><i class="material-icons left grey-text">home</i>Inicio</a></li>
      <li class="divider"></li>
      <li><a href="ventas.php"><i class="material-icons black-text left">attach_money</i>Ventas</a></li>
      <li class="divider"></li>
      <li><a href="clientes.php"><i class="material-icons purple-text left">account_circle</i>Clientes</a></li>
      <li class="hide"><a href="#!"><i class="material-icons orange-text left">account_box</i>Usuarios</a></li>
      <li class="hide"><a href="tipos_de_usuarios.php"><i class="material-icons blue-text left">group</i>Tipos de usuarios</a></li>
      <li><a href="articulos.php"><i class="material-icons red-text left">assignment</i>Articulos</a></li>
      <li class="divider"></li>
      <li><a href="logout.php"><i class="material-icons teal-text left">exit_to_app</i>Cerrar Sesión</a></li>
    </ul>