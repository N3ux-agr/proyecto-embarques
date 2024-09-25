<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bd_radios";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $serie_radio = $_POST['serie'];
    $num_empleado = $_POST['num_empleado'];
    $nombre_completo = $_POST['nombre_completo'];
    $puesto = $_POST['puesto'];
    $area = $_POST['area'];
    $jefe_directo = $_POST['jefe_directo'];
    $fecha_asignacion = $_POST['fecha_asignacion'];

    // Verificar si se subió una nueva imagen
    if ($_FILES['foto']['size'] > 0) {
        $foto_nombre = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $foto_ruta = 'imagenes/' . $foto_nombre;
        move_uploaded_file($foto_temp, $foto_ruta);
        
        // Actualizar la foto en la base de datos
        $sql_foto = "UPDATE asignacion SET foto='$foto_ruta' WHERE radio_serie='$serie_radio'";
        if ($conn->query($sql_foto) !== TRUE) {
            echo "Error al actualizar la foto: " . $conn->error;
        }
    }

    // Actualizar los demás datos del usuario en la base de datos
    $sql_datos = "UPDATE asignacion SET num_empleado='$num_empleado', nombre_completo='$nombre_completo', puesto='$puesto', area='$area', jefe_directo='$jefe_directo', fecha_asignacion='$fecha_asignacion' WHERE radio_serie='$serie_radio'";

    if ($conn->query($sql_datos) === TRUE) {
        // Redireccionar a la página principal
        header("Location: index_usuario.php");
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
} else {
    // Si se intenta acceder al script directamente sin enviar el formulario, redireccionar a la página principal
    header("Location: index_usuario.php");
    exit();
}
?>
