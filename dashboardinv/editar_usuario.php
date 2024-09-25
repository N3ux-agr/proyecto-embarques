<?php require_once "vistas/parte_superior.php" ?>
<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_radios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la serie de radio de la URL
if(isset($_GET['serie'])) {
    $serie_radio = $_GET['serie'];

    // Consultar los datos del usuario a partir de la serie de radio
    $sql = "SELECT * FROM asignacion WHERE radio_serie = '$serie_radio'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los datos del usuario en el formulario
        $row = $result->fetch_assoc();
        $radio_serie = $row['radio_serie'];
        $num_empleado = $row['num_empleado'];
        $nombre_completo = $row['nombre_completo'];
        $puesto = $row['puesto'];
        $area = $row['area'];
        $jefe_directo = $row['jefe_directo'];
        $fecha_asignacion = $row['fecha_asignacion'];
        $foto = $row['foto'];
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "Serie de radio no proporcionada.";
    exit();
}

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            padding: 30px;
            background-color: #fff;
        }

        .container h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
            margin-top: 20px;
        }

        .btn-back {
            width: 100%;
            margin-top: 10px;
        }

        #foto-preview {
            width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Usuario</h2>
        <form action="guardar_edicion_usuario.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="serie" value="<?php echo $serie_radio; ?>">
            <div class="form-group">
                <label for="radio_serie">Serie de Radio:</label>
                <input type="text" class="form-control" id="radio_serie" name="radio_serie" value="<?php echo $radio_serie; ?>">
            </div>
            <div class="form-group">
                <label for="num_empleado">Número de Empleado:</label>
                <input type="text" class="form-control" id="num_empleado" name="num_empleado" value="<?php echo $num_empleado; ?>">
            </div>
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $nombre_completo; ?>">
            </div>
            <div class="form-group">
                <label for="puesto">Puesto:</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo $puesto; ?>">
            </div>
            <div class="form-group">
                <label for="area">Área:</label>
                <input type="text" class="form-control" id="area" name="area" value="<?php echo $area; ?>">
            </div>
            <div class="form-group">
                <label for="jefe_directo">Jefe Directo:</label>
                <input type="text" class="form-control" id="jefe_directo" name="jefe_directo" value="<?php echo $jefe_directo; ?>">
            </div>
            <div class="form-group">
                <label for="fecha_asignacion">Fecha de Asignación:</label>
                <input type="date" class="form-control" id="fecha_asignacion" name="fecha_asignacion" value="<?php echo $fecha_asignacion; ?>">
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <br>
                <img src="<?php echo $foto; ?>" alt="Foto de perfil" id="foto-preview">
                <input type="file" class="form-control-file mt-2" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index_usuario.php" class="btn btn-secondary btn-back">Regresar</a>
        </form>
    </div>

    <!-- Modal de éxito -->
    <div class="modal fade" id="exitoModal" tabindex="-1" role="dialog" aria-labelledby="exitoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exitoModalLabel">Datos Guardados Correctamente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Los datos del radio se han guardado correctamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="redirectAfterModal()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
        // Cuando se hace clic en el botón de guardar cambios, se cierra el modal de edición
        $('#guardarCambios').click(function() {
            $('#editarModal').modal('hide');
        });

        // Función para redirigir después del modal de éxito
        function redirectAfterModal() {
            window.location.href = 'index_usuario.php';
        }
    </script>
</body>
</html>
<?php require_once "vistas/parte_inferior.php"?>