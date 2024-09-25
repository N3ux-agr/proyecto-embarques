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
    $sql_verificar_entrada = "SELECT * FROM asistencia WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
    $result_verificar_entrada = $conn->query($sql_verificar_entrada);

    if ($result_verificar_entrada->num_rows > 0) {
        // Actualizar la entrada existente
        $sql_actualizar_entrada = "UPDATE asistencia SET hora_entrada = '$hora_actual' WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
        $result_actualizar_entrada = $conn->query($sql_actualizar_entrada);

        if ($result_actualizar_entrada) {
            return true;
        } else {
            die("Error al actualizar la entrada: " . $conn->error);
        }
    } else {
        // Insertar nueva entrada
        $sql_registrar_entrada = "INSERT INTO asistencia (num_empleado, nombre_completo, fecha, hora_entrada, semana) VALUES ('$num_empleado', '$nombre_completo', '$fecha_actual', '$hora_actual', '$semana_actual')";
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
    $sql_verificar_salida = "SELECT * FROM asistencia WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
    $result_verificar_salida = $conn->query($sql_verificar_salida);

    if ($result_verificar_salida->num_rows > 0) {
        // Actualizar la salida existente
        $sql_actualizar_salida = "UPDATE asistencia SET hora_salida = '$hora_actual' WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
        $result_actualizar_salida = $conn->query($sql_actualizar_salida);

        if ($result_actualizar_salida) {
            return true;
        } else {
            die("Error al actualizar la salida: " . $conn->error);
        }
    } else {
        // Insertar nueva salida
        $sql_registrar_salida = "INSERT INTO asistencia (num_empleado, nombre_completo, fecha, hora_salida, semana) VALUES ('$num_empleado', '$nombre_completo', '$fecha_actual', '$hora_actual', '$semana_actual')";
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
    $sql_verificar_entrada = "SELECT * FROM asistencia WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
    
    $result_verificar_entrada = $conn->query($sql_verificar_entrada);
    
    if ($result_verificar_entrada) {
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
    <title>Agros Produce</title>
    <link rel="icon" type="image/png" href="iconos/agros.png">
    <style>
    .btn-container {
        display: flex;
        justify-content: space-between; /* Añade espacio entre los botones */
        margin-bottom: 10px; /* Margen inferior para separar los botones del contenido siguiente */
    }
 
</style>
</head>

<body>

    <div class="container">
    <div class="btn-container">
            <form method="post">
                <button class="btn btn-entrada" type="submit" name="btn_entrada">Registrar Entrada</button>
            </form>
            <form method="post">
                <button class="btn btn-salida" type="submit" name="btn_salida">Registrar Salida</button>
            </form>
        </div>
        <h1>Registro de Asistencia</h1>
        <table>
            <thead>
                <tr>
                    <th>No Empleado</th>
                    <th>Nombre Empleado</th>
                    <th>Fecha</th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
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
                    $sql_verificar_entrada = "SELECT hora_entrada FROM asistencia WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
                    $result_verificar_entrada = $conn->query($sql_verificar_entrada);

                    if ($result_verificar_entrada->num_rows > 0) {
                        $row_entrada = $result_verificar_entrada->fetch_assoc();
                        $hora_entrada = $row_entrada['hora_entrada'];
                        echo "<td>{$hora_entrada}</td>";
                    } else {
                        echo "<td>No registrada</td>";
                    }

                    // Obtener la hora de salida si está registrada
                    $sql_verificar_salida = "SELECT hora_salida FROM asistencia WHERE num_empleado = '$num_empleado' AND fecha = '$fecha_actual'";
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

    </div>


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
            setTimeout(function () {
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
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
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

</body>

</html>
