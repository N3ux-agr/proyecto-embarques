<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Recepción de los datos enviados mediante POST desde el JS   
$tipo_caja = (isset($_POST['tipo_caja'])) ? $_POST['tipo_caja'] : '';
$tipo_caja_original = (isset($_POST['tipo_caja_original'])) ? $_POST['tipo_caja_original'] : ''; // Nuevo
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

try {
    switch($opcion){
        case 1: // Alta
            if (!empty($tipo_caja)) {
                $consulta = "INSERT INTO bd_empaque.caja_bola (tipo_caja) VALUES(:tipo_caja)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(':tipo_caja' => $tipo_caja));
                echo "Tipo de caja insertado correctamente";
            } else {
                echo "El campo tipo de caja es requerido para insertar un tipo de caja.";
            }
            break;
        case 2: // Modificación
                if (!empty($tipo_caja)) {
                    $nuevo_tipo_caja = $_POST['nuevo_tipo_caja']; // Obtenemos el nuevo valor del tipo de caja
                    $consulta = "UPDATE bd_empaque.caja_bola SET tipo_caja=:nuevo_tipo_caja WHERE tipo_caja=:tipo_caja_original"; // Modificamos la consulta de actualización
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute(array(':nuevo_tipo_caja' => $nuevo_tipo_caja, ':tipo_caja_original' => $tipo_caja_original))) {
                        echo "Tipo de caja actualizado correctamente";
                    } else {
                        echo "Error al actualizar el tipo de caja: " . $resultado->errorInfo()[2]; // Imprimimos el mensaje de error
                    }
                } else {
                    echo "El campo tipo de caja es requerido para actualizar un tipo de caja.";
                }
                break;
            
        case 3: // Baja
            if (!empty($tipo_caja)) {
                $consulta = "DELETE FROM bd_empaque.caja_bola WHERE tipo_caja=:tipo_caja";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(':tipo_caja' => $tipo_caja));
                echo "Tipo de caja eliminado correctamente";
            } else {
                echo "El campo tipo de caja es necesario para eliminar un tipo de caja.";
            }
            break;        
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

$conexion = NULL;
?>
