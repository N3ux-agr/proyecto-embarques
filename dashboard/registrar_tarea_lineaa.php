<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener la dirección IP del cliente
$ip_cliente = $_SERVER['REMOTE_ADDR'];

// Consultar las direcciones IP permitidas desde la base de datos
$sql_ip_permitidas = "SELECT ip FROM ip_permitidas";
$result_ip_permitidas = $conn->query($sql_ip_permitidas);

// Verificar si la consulta se realizó correctamente
if ($result_ip_permitidas->num_rows > 0) {
    // Inicializar un array para almacenar las direcciones IP permitidas
    $direcciones_permitidas = array();

    // Obtener las direcciones IP permitidas y almacenarlas en el array
    while ($row_ip = $result_ip_permitidas->fetch_assoc()) {
        $direcciones_permitidas[] = $row_ip['ip'];
    }

    // Verificar si la dirección IP del cliente está en la lista de direcciones permitidas
    if (in_array($ip_cliente, $direcciones_permitidas)) {
        // Si la dirección IP del cliente está permitida, continuar con el resto del código

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
            margin-top: 40px;
        }

        .iconos a {
            display: inline-block;
            margin: 0 90px; /* Ajusta el espacio entre los iconos según sea necesario */
            text-decoration: none;
            color: #333;
            transition: transform 0.3s ease;
        }

        .iconos a:hover {
            color: #FF5733; /* Cambio de color al naranja al pasar el cursor */
            transform: translateY(-10px); /* Efecto de elevación al pasar el cursor */
        }

        .iconos img {
            width: 150px; /* Ajusta el tamaño de los iconos según sea necesario */
            height: auto;
        }

        /* Estilos para el título "Elige la línea" */
        .elige-linea {
            text-align: center;
            margin-top: 20px;
            font-size: 36px;
            color: #FF5733; /* Color naranja */
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Estilos para la lista de opciones */
        .opciones {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .opcion {
            margin: 20px;
            text-align: center;
            font-size: 20px;
            color: #555;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .opcion:hover {
            color: #FF5733; /* Cambio de color al naranja al pasar el cursor */
        }

        .opcion h3 {
            margin-top: 10px;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container"> 
        <h1>Información del Empleado</h1>
        <div class="datos-empleado">
            <p><strong>Número de Empleado:</strong> <?php echo $num_empleado; ?></p>
            <p><strong>Nombre Completo:</strong> <?php echo $nombre_completo; ?></p>
        </div>
    </div>

    <div class="elige-linea">Elige la línea</div>

    <div class="iconos opciones">
        <!-- Icono para Registrar Tarea Bola -->
        <a href="registrar_tarea_bola.php<?php if(isset($num_empleado)) echo '?num_empleado='.$num_empleado; ?>" class="opcion">
            <img src="iconos/t.png" alt="Icono Tarea Bola">
            <h3>Línea Bola</h3>
        </a>
        
        <!-- Icono para Registrar Tarea Racimo -->
        <a href="registrar_tarea_racimo.php<?php if(isset($num_empleado)) echo '?num_empleado='.$num_empleado; ?>" class="opcion">
            <img src="iconos/to.png" alt="Icono Tarea Racimo">
            <h3>Línea Racimo</h3>
        </a>

        <!-- Icono para Registrar Tarea Org -->
        <a href="registrar_tarea_org.php<?php if(isset($num_empleado)) echo '?num_empleado='.$num_empleado; ?>" class="opcion">
            <img src="iconos/tom.png" alt="Icono Tarea Org">
            <h3>Línea Racimo Org</h3>
        </a>
    </div>
</body>
</html>
<?php
    } else {
        // Si la dirección IP del cliente no está permitida, redirigir al usuario a la página "denegado.php"
        header('Location: denegado.php');
        exit(); // Asegurarse de que el script se detenga después de redirigir
    }
} else {
    // Si no se encontraron direcciones IP permitidas en la base de datos, redirigir al usuario a la página "denegado.php" o manejar el error de otra manera
    header('Location: denegado.php');
    exit(); // Asegurarse de que el script se detenga después de redirigir
}
?>
