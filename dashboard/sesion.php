<?php 
session_start(); // Inicia la sesión si aún no se ha iniciado

// Verifica si se ha enviado el formulario
if(isset($_POST['submit'])) {
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "bd_empaque");

    // Verifica si hay errores en la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtiene la contraseña del formulario
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para verificar si la contraseña coincide en la tabla de sesion
    $consulta_sesion = "SELECT COUNT(*) as count FROM sesion WHERE password='$contrasena'";
    $resultado_sesion = $conexion->query($consulta_sesion);
    $row = $resultado_sesion->fetch_assoc();
    $count = $row['count'];

    // Verifica si se encontró una coincidencia en la tabla de sesion
    if ($count == 1) {
        // Inicio de sesión exitoso
        $_SESSION['usuario'] = 'sesion'; // Solo almacenamos un valor para identificar que el usuario ha iniciado sesión
        // Mostrar modal de inicio de sesión exitoso
        echo "<script>alert('¡Inicio de sesión exitoso!');</script>";
    } else {
        // Inicio de sesión fallido
        $error_message = "Contraseña incorrecta. Inténtalo de nuevo.";
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
  <title> Agros Produce - Iniciar Sesión </title>
  <link rel="icon" type="image/png" href="dashboard/iconos/agros.png">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #212121;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login {
      width: 90%;
      max-width: 400px;
      background-color: #333333;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login h2 {
      margin-bottom: 30px;
      text-align: center;
      color: #ff6600;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .input-group {
      position: relative;
      margin-bottom: 30px;
    }

    .input-group input {
      width: 100%;
      padding: 15px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      background-color: #4d4d4d;
      color: #ffffff;
      transition: background-color 0.3s;
    }

    .input-group input:focus {
      outline: none;
      background-color: #666666;
    }

    .input-group .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background-color: transparent;
      border: none;
      cursor: pointer;
      color: #cccccc;
    }

    .input-group .toggle-password:hover {
      color: #ffffff;
    }

    .btn-login {
      width: 100%;
      padding: 15px;
      background-color: #ff6600;
      color: #ffffff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn-login:hover {
      background-color: #ff8000;
    }

    .error-message {
      color: #ff3333;
      margin-top: 20px;
      text-align: center;
      font-size: 14px;
      animation: shake 0.5s ease-out;
    }

    @keyframes shake {
      0%, 100% {
        transform: translateX(0);
      }
      25%, 75% {
        transform: translateX(-10px);
      }
      50% {
        transform: translateX(10px);
      }
    }

    .login-footer {
      text-align: center;
      margin-top: 20px;
      color: #cccccc;
      font-size: 14px;
    }

    .login-footer a {
      color: #ff6600;
      text-decoration: none;
      transition: color 0.3s;
    }

    .login-footer a:hover {
      color: #ff8000;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login">
      <h2>Inserta la contraseña</h2>
      <form action="" method="post">
        <div class="input-group">
          <input type="password" name="contrasena" placeholder="Contraseña">
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility(this)">Mostrar</button>
        </div>
        <div class="input-group">
          <input type="submit" name="submit" value="Iniciar sesión" class="btn-login">
        </div>
      </form>
      <?php
      // Muestra el mensaje de error si existe
      if(isset($error_message)) {
          echo '<div class="error-message">' . $error_message . '</div>';
      }
      ?>
    </div>
  </div>

  <!-- Script para mostrar/ocultar contraseña -->
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

