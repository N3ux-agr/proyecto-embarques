<?php
include 'conexion.php';

// Verificar si se recibió el número de empleado
$num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : '';

// Verificar si se recibió el número de empleado
if (empty($num_empleado)) {
    die("No se recibió el número de empleado.");
}

// Consultar la información del empleado utilizando el número de empleado recibido
$sql_info_empleado = "SELECT * FROM empleados WHERE num_empleado = '$num_empleado'";
$result_info_empleado = $conn->query($sql_info_empleado);

// Inicializar la variable $nombre_completo
$nombre_completo = '';

// Verificar si se encontró información del empleado
if ($result_info_empleado->num_rows > 0) {
    $row_empleado = $result_info_empleado->fetch_assoc();
    $nombre_completo = $row_empleado['nombre_completo'];
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="iconos/agros.png">
    <title>Información Detallada</title>
    <link rel="stylesheet" href="estilos/empleado_informacion.css">
    <style>
        /* Estilos para los iconos */
        .iconos {
            text-align: center;
            margin-top: 20px;
        }

        .iconos a {
            display: inline-block;
            margin: 0 120px; /* Ajusta el espacio entre los iconos según sea necesario */
        }

        .iconos img {
            width: 120px; /* Ajusta el tamaño de los iconos según sea necesario */
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container"> 
        <h1>Información del Empleado</h1>
        <table>
            <thead>
                <tr>
                    <th>Número de Empleado</th>
                    <th>Nombre Completo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $num_empleado; ?></td>
                    <td><?php echo $nombre_completo; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="iconos">
        <!-- Icono para Ausencia -->
        <a href="registrar_tarea_linea.php<?php if(isset($num_empleado)) echo '?num_empleado='.$num_empleado; ?>">
            <img src="iconos/ausencia.png" alt="Icono Ausencia">
            <h3>Registrar Tarea </h3>
        </a>
        
        <!-- Icono para Asistencia -->
        <a href="asistencia.php<?php if(isset($num_empleado)) echo '?num_empleado='.$num_empleado; ?>">
            <img src="iconos/asistencia.png" alt="Icono Asistencia">
            <h3>Registrar Asistencia</h3>
        </a>
    </div>
</body>
</html>