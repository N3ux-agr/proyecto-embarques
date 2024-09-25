<?php
// Incluir archivo de conexión
include 'conexion.php';

// Verificar si se recibieron los datos del formulario
if(isset($_POST['numEmpleado']) && isset($_POST['horaEntrada']) && isset($_POST['horaSalida'])) {
    // Recibir los datos del formulario
    $numEmpleado = $_POST['numEmpleado'];
    $horaEntrada = $_POST['horaEntrada'];
    $horaSalida = $_POST['horaSalida'];
    
    // Obtener la fecha actual
    $fecha = date("Y-m-d");
    // Obtener la semana actual
    $semana = date('W');

    try {
        // Establecer conexión a la base de datos usando PDO
        $pdo = new PDO('mysql:host=localhost;dbname=bd_empaque', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Consulta para obtener el nombre completo del empleado
        $consultaEmpleado = $pdo->prepare("SELECT nombre_completo FROM empleados WHERE num_empleado = ?");
        $consultaEmpleado->execute([$numEmpleado]);
        $nombreEmpleado = $consultaEmpleado->fetchColumn();
        
        // Preparar la consulta SQL para insertar los datos en la tabla de asistencia
        $consulta = $pdo->prepare("INSERT INTO asistencia (num_empleado, nombre_completo, fecha, hora_entrada, hora_salida, semana) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Ejecutar la consulta con los datos recibidos del formulario
        $consulta->execute([$numEmpleado, $nombreEmpleado, $fecha, $horaEntrada, $horaSalida, $semana]);
        
        // Enviar una respuesta al cliente indicando que la asistencia se guardó correctamente
        echo 'success';
    } catch(PDOException $e) {
        // Enviar una respuesta al cliente en caso de error
        echo 'error';
    }
} else {
    // Enviar una respuesta al cliente si no se recibieron todos los datos del formulario
    echo 'error';
}
?>
