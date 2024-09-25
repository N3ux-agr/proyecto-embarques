<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   
$num_empleado = (isset($_POST['num_empleado'])) ? $_POST['num_empleado'] : '';
$nombre_completo = (isset($_POST['nombre_completo'])) ? $_POST['nombre_completo'] : '';
$jefe_directo = (isset($_POST['jefe_directo'])) ? $_POST['jefe_directo'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

try {
    switch($opcion){
        case 1: // Alta
            if (!empty($num_empleado) && !empty($nombre_completo) && !empty($jefe_directo) && !empty($area)) {
                $consulta = "INSERT INTO empleados (num_empleado, nombre_completo, jefe_directo, area) VALUES(:num_empleado, :nombre_completo, :jefe_directo, :area)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(':num_empleado' => $num_empleado, ':nombre_completo' => $nombre_completo, ':jefe_directo' => $jefe_directo, ':area' => $area));
                echo "success"; // Devuelve "success" si la inserción se realizó correctamente
            } else {
                echo "error"; // Devuelve "error" si hay campos faltantes
            }
            break;
    
        case 2: // Modificación
            if (!empty($num_empleado) && !empty($nombre_completo) && !empty($jefe_directo) && !empty($area)) {
                $consulta = "UPDATE empleados SET nombre_completo=:nombre_completo, jefe_directo=:jefe_directo, area=:area WHERE num_empleado=:num_empleado";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(':nombre_completo' => $nombre_completo, ':jefe_directo' => $jefe_directo, ':area' => $area, ':num_empleado' => $num_empleado));
                echo "success"; // Devuelve "success" si la actualización se realizó correctamente
            } else {
                echo "error"; // Devuelve "error" si hay campos faltantes
            }
            break;
    
        case 3: // Baja
            if (!empty($num_empleado)) {
                $consulta = "DELETE FROM empleados WHERE num_empleado=:num_empleado";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(':num_empleado' => $num_empleado));
                echo "success"; // Devuelve "success" si la eliminación se realizó correctamente
            } else {
                echo "error"; // Devuelve "error" si no se proporcionó el número de empleado
            }
            break;
        
        default:
            echo "error"; // Devuelve "error" si no se especifica una opción válida
            break;
    }
} catch (PDOException $e) {
    echo "error: " . $e->getMessage(); // Devuelve un mensaje de error si hay una excepción PDO
}

$conexion = NULL;
?>
