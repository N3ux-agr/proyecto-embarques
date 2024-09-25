 <?php
include 'conexion.php';

// Verificar si se recibió el número de empleado
$num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : '';

// Verificar si se recibió el número de empleado
if (empty($num_empleado)) {
    die("No se recibió el número de empleado.");
}

// Definir la variable $nombre_completo con un valor por defecto
$nombre_completo = '';

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
            // Obtener la hora actual nuevamente
            $hora_actual = $row_hora_actual['hora_actual'];

            // Registrar la entrada
            if (registrarEntrada($conn, $num_empleado, $fecha_actual, $hora_actual, $nombre_completo, $semana_actual)) {
                // Llamar a la función JavaScript para mostrar el modal de tarea iniciada
                echo '<script>openModal("modalEntrada");</script>';
            }
        }

        // Si se presiona el botón de salida, registramos la salida
        if (isset($_POST['btn_salida'])) {
            // Obtener la hora actual nuevamente
            $hora_actual = $row_hora_actual['hora_actual'];

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
?>



<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="estilos/empleado_informacion.css">
    <title> Agros Produce </title>
    <link rel="icon" type="image/png" href="iconos/agros.png"> 
    
    
    
    <style>  
        
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
            // Consultar los tipos de cajas disponibles
            $sql_tipos_cajas = "SELECT DISTINCT tipo_caja FROM tipo_cajas";
            $result_tipos_cajas = $conn->query($sql_tipos_cajas);

            // Variable para almacenar las opciones del combo box
            $combo_options = '';

            // Construir las opciones del combo box
            if ($result_tipos_cajas->num_rows > 0) {
             while ($row_tipo_caja = $result_tipos_cajas->fetch_assoc()) {
             $tipo_caja = $row_tipo_caja['tipo_caja'];
            $combo_options .= "<option value='$tipo_caja'>$tipo_caja</option>";
            }
            }

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
        
    </table><!-- Formulario para guardar la tarea -->
    <h1>Registro de Tarea</h1>
    <form method="post">
    <input type="hidden" name="guardar_tarea" value="true">
    <input type="hidden" name="hora_entrada" value="<?php echo $hora_entrada; ?>">
    <input type="hidden" name="hora_salida" value="<?php echo $hora_salida; ?>">
    <table class="registro-tarea-table">
        <thead>
            <tr> 
                <th>Tipo de caja</th>
                <th>Cantidad</th> 
            </tr>
        </thead>
        <tbody>
            <tr>  
                <td>
                    <select name="tipo_caja">
                        <?php echo $combo_options; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="cantidad" class="input-cantidad">
                </td>
            </tr>
        </tbody>
    </table>
    <center><button class="btn-guardar" type="submit" name="btn_guardar_tarea">Guardar Tarea</button></center>
</form> 
<style> 
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


</body>  
<div id="modalEntrada" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalEntrada')">&times;</span>
            <h2>Tarea iniciada</h2>
            <p>Entrada registrada correctamente a las <?php echo $hora_actual; ?>. ¡Buen día!</p>
        </div>
    </div>

    <!-- Modal de tarea terminada -->
    <div id="modalSalida" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalSalida')">&times;</span>
            <h2>Tarea terminada</h2>
            <p>Salida registrada correctamente a las <?php echo $hora_actual; ?>. ¡Hasta luego, que descanses!</p>
        </div>
    </div>
    <!-- Mostrar modal si es necesario -->
    <?php
    if ($mostrar_botones) {
        echo "<div id='myModal' class='modal'>";
        echo "<div class='modal-content $tipo_modal'>";
        echo "<span class='close'>&times;</span>";
        echo "<p>$mensaje_modal</p>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
<?php
if(isset($_POST['btn_guardar_tarea'])) {
    // Obtener los valores de los campos de la tabla
    $tarea_inicio = isset($_POST['hora_entrada']) ? $_POST['hora_entrada'] : 'No registrada';
    $tarea_terminada = isset($_POST['hora_salida']) ? $_POST['hora_salida'] : 'No registrada';
    $tipo_caja = isset($_POST['tipo_caja']) ? $_POST['tipo_caja'] : '';
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

    // Consulta SQL para insertar los valores en la tabla registro_trabajo
    $sql_guardar_tarea = "INSERT INTO registro_trabajo (num_empleado, nombre_completo, fecha, semana, tarea_inicio, tarea_terminada, tipo_caja, cantidad) VALUES ('$num_empleado', '$nombre_completo', '$fecha_actual', '$semana_actual', '$tarea_inicio', '$tarea_terminada', '$tipo_caja', '$cantidad')";
// Indica que se deben mostrar los botones
if ($conn->query($sql_guardar_tarea) === TRUE) {
    echo '<script>showModal("La tarea se ha guardado correctamente.");</script>';
} else {
    echo "Error al guardar la tarea: " . $conn->error;
}
 
}
?>
    <!-- Modal de mensaje -->
    <div id="modalMessage" class="modal">
        <div class="modal-content">
            <p id="message"></p>
        </div>
    </div>
    <script>
    // Función para mostrar el modal
    function showModal(message) {
        // Obtener el modal
        var modal = document.getElementById("modalMessage");
        
        // Mostrar el mensaje en el modal
        modal.innerHTML = message;
        
        // Mostrar el modal
        modal.style.display = "block";
        
        // Cerrar el modal después de 3 segundos
        setTimeout(function() {
            modal.style.display = "none";
        }, 3000);
    }
</script>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Show modal if entry or exit was registered
    <?php
    if ($mensaje_modal != "") {
        echo "modal.style.display = 'block';";
    }
    ?>
</script>
  
</html>
 