<?php
// Inicializa la sesión si no está iniciada
session_start();

// Verifica si se ha enviado el formulario
if(isset($_POST['submit'])) {
  // Conexión a la base de datos
  $conexion = new mysqli("localhost", "root", "", "bd_empaque");

  // Verifica si hay errores en la conexión
  if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
  }

  // Obtiene los datos del formulario
  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];

  // Consulta SQL para verificar las credenciales en la tabla de usuarios
  $consulta_usuarios = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$contrasena'";
  $resultado_usuarios = $conexion->query($consulta_usuarios);

  // Consulta SQL para verificar las credenciales en la tabla de invitados
  $consulta_invitados = "SELECT * FROM invitado WHERE usuario='$usuario' AND password='$contrasena'";
  $resultado_invitados = $conexion->query($consulta_invitados);

  // Verifica si se encontraron registros coincidentes en la tabla de usuarios
  if ($resultado_usuarios->num_rows > 0) {
    // Inicio de sesión exitoso como usuario
    $_SESSION['usuario'] = $usuario;
    // Redirecciona al usuario a la página de dashboard de usuarios
    header("Location: dashboard/index.php");
    exit();
  } elseif ($resultado_invitados->num_rows > 0) {
    // Inicio de sesión exitoso como invitado
    $_SESSION['usuario'] = $usuario;
    // Redirecciona al usuario a la página de dashboard de invitados
    header("Location: dashboardinv/index.php");
    exit();
  } else {
    // Inicio de sesión fallido
    $error_message = "Usuario o contraseña incorrectos. Inténtalo de nuevo.";
  }

  // Cierra la conexión a la base de datos
  $conexion->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="styles.css">
  <title> Agros Produce </title>
  <link rel="icon" type="image/png" href="dashboard/iconos/agros.png">
  <style>
    /* Estilos para el modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: none;
      border-radius: 10px;
      width: 40%; /* Cambiar el ancho del modal */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      animation: animatezoom 0.6s;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    @keyframes animatezoom {
      from {
        transform: scale(0)
      }
      to {
        transform: scale(1)
      }
    }
    .password-toggle {
      position: relative;
    }

    .password-toggle input[type="password"] {
      padding-right: 40px; /* Espacio para el botón de mostrar/ocultar contraseña */
    }

    .password-toggle .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      background-color: transparent;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="ring">
    <i style="--clr:#FF8000;"></i>
    <i style="--clr:#FCFCFC;"></i>
    <i style="--clr:#FC002E;"></i> 
    <div class="login">
    <h2>Bienvenido</h2>
    <form action="" method="post">
      <div class="inputBx">
        <input type="text" name="usuario" placeholder="Usuario">  
      </div>
      <br>
      <div class="inputBx password-toggle">
        <input type="password" name="contrasena" placeholder="Contraseña">
        <button type="button" class="toggle-password" onclick="togglePasswordVisibility(this)">Mostrar</button>
      </div>
      <br>
      <div class="inputBx">
        <input type="submit" name="submit" value="Iniciar sesión">
      </div>
    </form>
    <?php
    // Muestra el mensaje de error si existe
    if(isset($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>
    <div class="links">
      <a href="#"></a>
      <a href="#"></a>
    </div>
  </div>
  </div>

<!-- Modal -->
<div id="myModal" class="modal" onclick="closeModal()">
<!-- Contenido del modal -->
<div class="modal-content" onclick="event.stopPropagation();">
  <span class="close" onclick="closeModal()">&times;</span>
  <p>Usuario o contraseña incorrectos. Inténtalo de nuevo.</p>
</div>
</div>
  <!-- Script para mostrar el modal -->
  <script>
    function togglePasswordVisibility(button) {
      var passwordInput = button.previousElementSibling;
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        button.textContent = "Ocultar";
      } else {
        passwordInput.type = "password";
        button.textContent = "Mostrar";
      }
    }
  </script>
</body>
</html>
