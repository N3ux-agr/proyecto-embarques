 
<?php
// Inicializa la sesión si no está iniciada
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, redirige al usuario al formulario de inicio de sesión
    header("Location: /Proyecto%20empaque/index.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="Emmanuel" content="">

  <title> Agros Produce </title>
    <link rel="icon" type="image/png" href="iconos/agros.png">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="vendor/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="vendor/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">   
  
  
    <style> 


.navbar-nav .nav-item .nav-link {
    color: #fff; /* Cambia el color del texto de los enlaces en la barra de navegación */
}
        .icono-caja {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/caja.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}

        .icono-tarea {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/ss.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}
.icono-empleo {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/empleo.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}
.icono-empleoo {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/asis.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}
.icono-nuevo {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/hecho.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}
.icono-cv {
    display: inline-block;
    width: 35px; /* ajusta el ancho según sea necesario */
    height: 35px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/cv.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
}

.icono-agros {
    display: inline-block;
    width: 90px; /* ajusta el ancho según sea necesario */
    height: 90px; /* ajusta la altura según sea necesario */
    background-image: url('iconos/agros.png');
    background-size: cover; /* para ajustar el tamaño de la imagen */
} 

  /* Estilo para cambiar el fondo de la barra lateral del menú */
  .bg-gradient-primaryy.sidebar {
    background-color: #D33513; /* Cambia este valor al color deseado */
  }
  .navbar-navv {
    background-color: #D33513; /* Cambia este valor al color deseado */
} 
.navbar-nav .nav-item .nav-link {
    font-size: 25px; /* Cambia este valor al tamaño deseado */
    /* Puedes agregar otros estilos aquí si es necesario */
}

 
.sidebar-brand {
    display: flex;
    flex-direction: column;
    align-items: center;
 
    margin-top: 50px; /* ajusta el espacio vertical superior de toda la marca lateral */
    margin-bottom: 50px; /* ajusta el espacio vertical inferior de toda la marca lateral */
}

.sidebar-brand-icon {
    margin-bottom: 20px; /* ajusta el espacio vertical inferior del icono */
}

.sidebar-brand-text {
    margin-top: 20px; /* ajusta el espacio vertical superior del texto */
}
 
</style> 

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primaryy sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
        <i class="icono-agros"></i>
        </div> 
        <div class="sidebar-brand-text mx-3">Agros<sup>Produce</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
        <i class="icono-cv"></i>
          <span>Empleados</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Secciones
      </div>  

      <li class="nav-item active">
        <a class="nav-link" href="registrar_tarea.php">
        <i class="icono-nuevo"></i>
          <span>Registrar Nueva Tarea</span></a>
      </li>


      <!-- Usuarios -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="icono-empleo"></i>
          <span>Empleados</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tipos de vista:</h6> 
            <a class="collapse-item" href="index_usuario.php">Carta</a>
            <a class="collapse-item" href="index.php">Normal</a> 
            
          </div>
        </div>
      </li>

       <!-- Usuarios ddddddddddddddddddddddddddddddd-->
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <i class="icono-empleoo"></i>
          <span>Asistencia</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Asistencia por:</h6> 
            <a class="collapse-item" href="asistencia_dia.php">Día</a>
            <a class="collapse-item" href="asistencia_semana.php">Semana</a>
            
          </div>
        </div>
      </li>


      

      <!-- Tareas -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
        <i class="icono-tarea"></i>
          <span>Tareas</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Registro de tareas Por:</h6>  
            <a class="collapse-item" href="registrotra_tiempo.php">Tarea por Tiempo</a>
            <a class="collapse-item" href="registrotra_dia.php">Tarea por día</a>
            <a class="collapse-item" href="registrotra_semana.php">Tarea por Semana</a>
            
          </div>
        </div>
      </li>

      <!-- Cajas -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
        <i class="icono-caja"></i>

          <span>Cajas</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Clasificacion de cajas:</h6>
            <a class="collapse-item" href="registro_cajas_bola.php">Linea Bola</a> 
            <a class="collapse-item" href="registro_cajas_racimo.php">Linea Racimo</a> 
            <a class="collapse-item" href="registro_cajas_org.php">Linea Racimo Org</a> 
            
          </div>
        </div>
      </li>

      

    

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
    

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

         

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 
<!--                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->
                <img class="img-profile rounded-circle" src="img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
