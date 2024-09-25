<?php
// Verificar si se recibieron los datos del formulario
if(isset($_POST['numEmpleado'], $_POST['horaEntrada'], $_POST['horaSalida'], $_POST['fecha'])) {
    // Recibir los datos del formulario
    $numEmpleado = $_POST['numEmpleado'];
    $horaEntrada = $_POST['horaEntrada'];
    $horaSalida = $_POST['horaSalida'];
    $fecha = $_POST['fecha'];

    try {
        // Establecer conexión a la base de datos usando PDO
        $pdo = new PDO('mysql:host=localhost;dbname=bd_empaque', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar la consulta SQL para actualizar los datos en la tabla de asistencia
        $consulta = $pdo->prepare("UPDATE asistencia SET hora_entrada = ?, hora_salida = ? WHERE num_empleado = ? AND fecha = ?");
        
        // Ejecutar la consulta con los datos recibidos del formulario
        $consulta->execute([$horaEntrada, $horaSalida, $numEmpleado, $fecha]);
        
        // Verificar si se actualizó correctamente algún registro
        if ($consulta->rowCount() > 0) {
            // Enviar una respuesta al cliente indicando que la asistencia se actualizó correctamente
            echo 'success';
        } else {
            // Enviar una respuesta al cliente indicando que no se encontró el registro para actualizar
            echo 'not_found';
        }
    } catch(PDOException $e) {
        // Enviar una respuesta al cliente en caso de error
        echo 'error';
    }
} else {
    // Enviar una respuesta al cliente si no se recibieron todos los datos del formulario
    echo 'missing_data';
}
?>
