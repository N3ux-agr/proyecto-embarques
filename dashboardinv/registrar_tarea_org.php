<?php
include 'conexion.php';

// Verificar si se recibió el número de empleado
$num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : '';

// Verificar si se recibió el número de empleado
if (empty($num_empleado)) {
    die("No se recibió el número de empleado.");
}

// Obtener la fecha actual desde PHP
$fecha_actual = date('Y-m-d');

// Obtener el número de semana actual
$semana_actual = date('W');

// Consultar la hora actual del servidor de la base de datos
$sql_hora_actual = "SELECT CURRENT_TIME() AS hora_actual";
$result_hora_actual = $conn->query($sql_hora_actual);

if ($result_hora_actual && $result_hora_actual->num_rows > 0) {
    $row_hora_actual = $result_hora_actual->fetch_assoc();
    $hora_actual = $row_hora_actual['hora_actual'];
} else {
    die("Error al obtener la hora actual del servidor de la base de datos.");
}

// Consultar la información del empleado utilizando el número de empleado recibido
$sql_info_empleado = "SELECT * FROM empleados WHERE num_empleado = '$num_empleado'";
$result_info_empleado = $conn->query($sql_info_empleado);

if ($result_info_empleado->num_rows > 0) {
    $row_empleado = $result_info_empleado->fetch_assoc();
    $nombre_completo = $row_empleado['nombre_completo'];

    // Verificar si ya se registró la entrada y salida para este empleado en este día
    $sql_verificar_entrada = "SELECT * FROM registro_entrada WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
    $sql_verificar_salida = "SELECT * FROM registro_salida WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";

    $result_verificar_entrada = $conn->query($sql_verificar_entrada);
    $result_verificar_salida = $conn->query($sql_verificar_salida);

    if ($result_verificar_entrada && $result_verificar_salida) {
        $mostrar_botones = true;

        // Si se presiona el botón de entrada, registramos la entrada
        if (isset($_POST['btn_entrada'])) {
            // Registrar la entrada
            if (registrarEntrada($conn, $num_empleado, $fecha_actual, $hora_actual, $nombre_completo, $semana_actual)) {
                // Llamar a la función JavaScript para mostrar el modal de tarea iniciada
                echo '<script>openModal("modalEntrada");</script>';
            }
        }

        // Si se presiona el botón de salida, registramos la salida
        if (isset($_POST['btn_salida'])) {
            // Registrar la salida
            if (registrarSalida($conn, $num_empleado, $fecha_actual, $hora_actual, $nombre_completo)) {
                // Llamar a la función JavaScript para mostrar el modal de tarea finalizada
                echo '<script>openModal("modalSalida");</script>';
            }
        }
    }
} else {
    die("No se encontró ningún empleado con el número proporcionado.");
}

// Función para registrar la entrada del empleado
function registrarEntrada($conn, $num_empleado, $fecha_actual, $hora_actual, $nombre_completo, $semana_actual) {
    // Verificar si ya hay una entrada para este empleado hoy
    $sql_verificar_entrada = "SELECT * FROM registro_entrada WHERE num_empleado = '$num_empleado'";
    $result_verificar_entrada = $conn->query($sql_verificar_entrada);

    if ($result_verificar_entrada->num_rows > 0) {
        // Actualizar la entrada existente
        $sql_actualizar_entrada = "UPDATE registro_entrada SET hora_entrada = '$hora_actual', fecha = '$fecha_actual', semana = '$semana_actual' WHERE num_empleado = '$num_empleado'";
        $result_actualizar_entrada = $conn->query($sql_actualizar_entrada);

        if ($result_actualizar_entrada) {
            return true;
        } else {
            die("Error al actualizar la entrada: " . $conn->error);
        }
    } else {
        // Insertar nueva entrada
        $sql_registrar_entrada = "INSERT INTO registro_entrada (num_empleado, nombre_completo, fecha, hora_entrada, semana) VALUES ('$num_empleado', '$nombre_completo', '$fecha_actual', '$hora_actual', '$semana_actual')";
        $result_registrar_entrada = $conn->query($sql_registrar_entrada);

        if ($result_registrar_entrada) {
            return true;
        } else {
            die("Error al registrar la entrada: " . $conn->error);
        }
    }
}

// Función para registrar la salida del empleado
function registrarSalida($conn, $num_empleado, $fecha_actual, $hora_actual, $nombre_completo) {
    // Verificar si ya hay una salida para este empleado hoy
    $sql_verificar_salida = "SELECT * FROM registro_salida WHERE num_empleado = '$num_empleado'";
    $result_verificar_salida = $conn->query($sql_verificar_salida);

    if ($result_verificar_salida->num_rows > 0) {
        // Actualizar la salida existente
        $sql_actualizar_salida = "UPDATE registro_salida SET hora_salida = '$hora_actual', fecha = '$fecha_actual' WHERE num_empleado = '$num_empleado'";
        $result_actualizar_salida = $conn->query($sql_actualizar_salida);

        if ($result_actualizar_salida) {
            return true;
        } else {
            die("Error al actualizar la salida: " . $conn->error);
        }
    } else {
        // Insertar nueva salida
        $sql_registrar_salida = "INSERT INTO registro_salida (num_empleado, nombre_completo, fecha, hora_salida) VALUES ('$num_empleado', '$nombre_completo', '$fecha_actual', '$hora_actual')";
        $result_registrar_salida = $conn->query($sql_registrar_salida);

        if ($result_registrar_salida) {
            return true;
        } else {
            die("Error al registrar la salida: " . $conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="iconos/agros.png">

    <title>Línea Racimo Org</title>
    <link rel="stylesheet" href="estilos/empleado_informacion.css"> 
    <style>  
        
/* Estilos para el contenedor del combobox */
.row {
    margin-top: 20px; /* Espacio superior */
}
 
/* Estilos para el texto "Seleccionar Línea" */
label {
    display: block; /* Mostrar en bloque */
    margin-bottom: 10px; /* Espacio inferior */
}

/* Estilos para centrar verticalmente el contenido */
.text-center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh; /* Altura completa de la ventana */
}

/* Estilos específicos para la tabla de registro de tarea */
.registro-tarea-table {
    width: 60%;
    border-collapse: collapse;
    border: 1px solid #ddd;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
}

.registro-tarea-table th, .registro-tarea-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

.registro-tarea-table th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
}

.registro-tarea-table select,
.registro-tarea-table input[type="text"] {
    width: calc(100% - 16px);
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    margin: 0;
}

.registro-tarea-table select {
    background-color: #f9f9f9;
}

.registro-tarea-table input[type="text"] {
    background-color: #fff;
}
</style>
</head>
<body> 

<div class="container">
    <div class="btn-container">
        <form method="post">
            <button class="btn btn-entrada" type="submit" name="btn_entrada">Inicio de Tarea</button> 
            <button class="btn btn-salida" type="submit" name="btn_salida">Tarea Terminada</button>
        </form> 
    </div>
    <h1>Registro de Tiempo</h1>
    <table>
        <thead>
            <tr>
                <th>No Empleado</th> 
                <th>Nombre Empleado</th> 
                <th>Fecha</th>
                <th>Inicio de tarea</th>
                <th>Tarea terminada</th>
                <th>Semana</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar la información del empleado utilizando el número de empleado recibido
            $sql_info_empleado = "SELECT * FROM empleados WHERE num_empleado = '$num_empleado'";
            $result_info_empleado = $conn->query($sql_info_empleado);

            if ($result_info_empleado->num_rows > 0) {
                $row_empleado = $result_info_empleado->fetch_assoc();
                $nombre_completo = $row_empleado['nombre_completo'];

                // Mostrar la información del empleado
                echo "<tr>";
                echo "<td>{$num_empleado}</td>"; 
                echo "<td>{$nombre_completo}</td>";
                echo "<td>{$fecha_actual}</td>";
                // Obtener la hora de entrada registrada si existe
                $sql_verificar_entrada = "SELECT hora_entrada FROM registro_entrada WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
                $result_verificar_entrada = $conn->query($sql_verificar_entrada);

                if ($result_verificar_entrada->num_rows > 0) {
                    $row_entrada = $result_verificar_entrada->fetch_assoc();
                    $hora_entrada = $row_entrada['hora_entrada'];
                    echo "<td>{$hora_entrada}</td>";
                } else {
                    echo "<td>No registrada</td>";
                }

                // Obtener la hora de salida si está registrada
                $sql_verificar_salida = "SELECT hora_salida FROM registro_salida WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
                $result_verificar_salida = $conn->query($sql_verificar_salida);

                if ($result_verificar_salida->num_rows > 0) {
                    $row_salida = $result_verificar_salida->fetch_assoc();
                    $hora_salida = $row_salida['hora_salida'];
                    echo "<td>{$hora_salida}</td>";
                } else {
                    echo "<td>No registrada</td>";
                }
                echo "<td>{$semana_actual}</td>";       

                echo "</tr>";
            } else {
                echo "<tr><td colspan='10'>No se encontró información del empleado.</td></tr>";
            }
            ?>
        </tbody>
        
    </table>
    <form method="post">
    <!-- Formulario para guardar la tarea --> 
    <h1>Registro de Tarea De la Línea Racimo Org</h1>
<div class="row">
    <div class="col-lg-12 text-center"> 
        <input type="hidden" name="linea" value="Línea Racimo Org"> <!-- Cambiado a un valor oculto predefinido -->
    </div>
</div>
    <input type="hidden" name="guardar_tarea" value="true">
    <table class="registro-tarea-table">
        <thead>
            <tr> 
                <th>Tipo de caja</th>
                <th>Cantidad</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar los tipos de cajas disponibles
            $sql_tipos_cajas = "SELECT DISTINCT tipo_caja FROM caja_racimo_org"; // Cambiado a caja_bola
            $result_tipos_cajas = $conn->query($sql_tipos_cajas);

            // Mostrar todas las cajas disponibles
            if ($result_tipos_cajas->num_rows > 0) {
                while ($row_tipo_caja = $result_tipos_cajas->fetch_assoc()) {
                    $tipo_caja = $row_tipo_caja['tipo_caja'];
                    echo "<tr>";
                    echo "<td>{$tipo_caja}</td>";
                    echo "<td><input type='text' name='cantidad[$tipo_caja]' class='input-cantidad' value='0'></td>"; // Cambiado el nombre del input
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No hay tipos de cajas disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <center><button class="btn-guardar" type="submit" name="btn_guardar_tarea">Guardar Tarea</button></center>
</form> 
</div>

<!-- Modal de entrada -->
<div id="modalEntrada" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalEntrada')">&times;</span>
        <h2>Tarea iniciada</h2>
        <p>Entrada registrada correctamente a las <?php echo $hora_actual; ?>. ¡Buen día!</p>
    </div>
</div>

<!-- Modal de salida -->
<div id="modalSalida" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalSalida')">&times;</span>
        <h2>Tarea terminada</h2>
        <p>Salida registrada correctamente a las <?php echo $hora_actual; ?>. ¡Hasta luego, que descanses!</p>
    </div>
</div>

<script>
// Función para mostrar el modal
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Función para cerrar el modal
function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}
</script>

</body>  
</html>

<?php if(isset($_POST['btn_guardar_tarea'])) {
    // Obtener los valores del formulario
    $tarea_inicio = $hora_actual; // Hora actual como inicio de tarea
    $tarea_terminada = $hora_actual; // Hora actual como tarea terminada
    $linea = isset($_POST['linea']) ? $_POST['linea'] : ''; // Obtener el valor seleccionado de la línea

    // Construir la parte del SQL para insertar los datos de las cajas
    $sql_insert_cajas = '';

    // Valores por defecto para las cajas que no están presentes en el formulario
    $default_cantidad = '';

    foreach ($_POST['cantidad'] as $tipo_caja => $cantidad) {
        // Construir la parte de la consulta para este tipo de caja
        $sql_insert_cajas .= "('$tipo_caja', '$cantidad', '$linea', '$num_empleado', '$nombre_completo', '$fecha_actual', '$semana_actual', '$tarea_inicio', '$tarea_terminada'),";
    }
    // Quitar la coma final
    $sql_insert_cajas = rtrim($sql_insert_cajas, ',');

    // Consulta SQL para insertar los valores en la tabla registro_trabajo
    $sql_guardar_tarea = "INSERT INTO registro_trabajo (tipo_caja, cantidad, linea, num_empleado, nombre_completo, fecha, semana, tarea_inicio, tarea_terminada) VALUES $sql_insert_cajas";
  
    if ($conn->query($sql_guardar_tarea) === TRUE) {
        echo '<script>alert("La tarea se ha guardado correctamente.");</script>';
    } else {
        echo "Error al guardar la tarea: " . $conn->error;
    }
}

?>
