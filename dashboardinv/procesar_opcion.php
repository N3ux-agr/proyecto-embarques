<?php
if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
    switch ($opcion) {
        case 'registro_tiempo':
            include 'asistencia.php';
            break;
        case 'registro_tarea':
            include 'ver_empleado.php';
            break;  
        default:
            echo "Opción no válida.";
    }
} else {
    echo "No se recibió ninguna opción.";
}
?>
