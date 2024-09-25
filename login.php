<?php
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
    
    // Consulta SQL para verificar las credenciales
    $consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$contrasena'";
    $resultado = $conexion->query($consulta);
    
    // Verifica si se encontraron registros coincidentes
    if ($resultado->num_rows > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['usuario'] = $usuario;
        // Redirecciona al usuario a la página de dashboard
        header("Location: dashboard/index.php");
        exit();
    } else {
        // Inicio de sesión fallido
        echo "Nombre de usuario o contraseña incorrectos";
    }
    
    // Cierra la conexión a la base de datos
    $conexion->close();
}
?>
