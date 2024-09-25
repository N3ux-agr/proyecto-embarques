<?php require_once "vistas/parte_superior.php" ?>
<?php
// Verificar si se recibió la solicitud para guardar la información
if (isset($_POST['guardarInformacion'])) {
    // Decodificar los datos de la tabla que se enviaron como JSON
    $registros = json_decode($_POST['registros'], true);

    // Incluir archivo de conexión
    include 'conexion.php';

    // Preparar la consulta para insertar los registros en la base de datos
    $consultaInsert = "INSERT INTO captura_dia (num_empleado, nombre_completo, fecha, semana, tipo_caja, cantidad, linea) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($consultaInsert);

    // Iterar sobre los registros y ejecutar la inserción
    foreach ($registros as $registro) {
        $stmt->bind_param('sssssss', $registro['num_empleado'], $registro['nombre_completo'], $registro['fecha'], $registro['semana'], $registro['tipo_caja'], $registro['cantidad'], $registro['linea']);
        $stmt->execute();
    }

    // Cerrar la conexión y la declaración
    $stmt->close();
    $conn->close();

    // Redirigir o mostrar un mensaje de éxito
    echo "La información se ha guardado correctamente.";
    exit; // Opcional: detiene la ejecución del script después de guardar los datos
}
?>

<!-- INICIO del cont principal -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Registro de Trabajo</h1>
            <!-- Barra de herramientas -->
            <div class="mb-3"> 
            </div>

            <!-- Formulario para seleccionar la fecha, número de empleado y línea -->
            <form id="formFiltros" class="form-inline">
                
                <div class="form-group mr-2">
                    <label for="num_empleado" class="mr-2">Número de Empleado:</label>
                    <input type="text" id="num_empleado" name="num_empleado" class="form-control">
                </div>
                <div class="form-group mr-2">
                    <label for="linea" class="mr-2">Línea:</label>
                    <select id="linea" name="linea" class="form-control">
                        <option value="">Seleccionar línea</option>
                        <option value="Línea Bola" <?php if(isset($_GET['linea']) && $_GET['linea'] == 'Línea Bola') echo "selected"; ?>>Línea Bola</option>
                        <option value="Línea Racimo" <?php if(isset($_GET['linea']) && $_GET['linea'] == 'Línea Racimo') echo "selected"; ?>>Línea Racimo</option>
                        <option value="Línea Racimo Org" <?php if(isset($_GET['linea']) && $_GET['linea'] == 'Línea Racimo Org') echo "selected"; ?>>Línea Racimo Org</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="fecha" class="mr-2">Seleccionar fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button> 
            </form>
        </div> 
    </div>
    <div id="registrosTabla" class="table-responsive">
        <?php
        // Incluir archivo de conexión
        include 'conexion.php';

        // Obtener la fecha seleccionada (por defecto hoy si no hay ninguna)
        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

        // Obtener el número de empleado y línea si se proporcionan
        $num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : '';
        $linea = isset($_GET['linea']) ? $_GET['linea'] : '';

        // Preparar la consulta base
        $consulta = "SELECT num_empleado, nombre_completo, fecha, semana, tipo_caja, SUM(cantidad) as total_cantidad, linea FROM registro_trabajo WHERE fecha = ?";

        // Agregar filtros según lo especificado
        if (!empty($num_empleado)) {
            $consulta .= " AND num_empleado = ?";
        }
        if (!empty($linea)) {
            $consulta .= " AND linea = ?";
        }

        // Agrupar por empleado y línea
        $consulta .= " GROUP BY num_empleado, linea";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($consulta);
        if (!empty($num_empleado) && !empty($linea)) {
            $stmt->bind_param('ss', $fecha, $num_empleado, $linea);
        } elseif (!empty($num_empleado)) {
            $stmt->bind_param('ss', $fecha, $num_empleado);
        } elseif (!empty($linea)) {
            $stmt->bind_param('ss', $fecha, $linea);
        } else {
            $stmt->bind_param('s', $fecha);
        }
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Mostrar resultados
        if ($resultado->num_rows > 0) {
            // Mostrar los datos en la tabla por usuario y línea
            while ($fila = $resultado->fetch_assoc()) {
                echo "<h2>Registros para el usuario: {$fila['nombre_completo']} - Línea: {$fila['linea']}</h2>";
                echo "<table class='table table-striped table-bordered table-condensed'>";
                echo "<thead class='text-center'>";
                echo "<tr>
                        <th>Número de Empleado</th>
                        <th>Fecha</th>
                        <th>Semana</th> 
                        <th>Tipo de Caja</th>
                        <th>Cantidad Total</th>
                    </tr>";
                echo "</thead>";
                echo "<tbody>";

                // Obtener detalles de registros
                $consultaDetalles = "SELECT num_empleado, fecha, semana, tipo_caja, SUM(cantidad) as total_cantidad FROM registro_trabajo WHERE num_empleado = ? AND fecha = ? AND linea = ? GROUP BY tipo_caja";
                $stmtDetalles = $conn->prepare($consultaDetalles);
                $stmtDetalles->bind_param('sss', $fila['num_empleado'], $fecha, $fila['linea']);
                $stmtDetalles->execute();
                $resultadoDetalles = $stmtDetalles->get_result();

                // Mostrar detalles
                while ($detalle = $resultadoDetalles->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$fila['num_empleado']}</td>";
                    echo "<td>{$detalle['fecha']}</td>";
                    echo "<td>{$detalle['semana']}</td>";
                    echo "<td>{$detalle['tipo_caja']}</td>";
                    echo "<td>{$detalle['total_cantidad']}</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            }
        } else {
            echo "<p>No se encontraron resultados para los filtros seleccionados.</p>";
        }

        // Cerrar consultas y conexión
        $stmt->close();
        $stmtDetalles->close();
        $conn->close();
        ?>
    </div>
</div>
<!-- FIN del cont principal -->

<?php require_once "vistas/parte_inferior.php" ?>
 

<?php
// Verificar si se recibió la solicitud para guardar la información
if (isset($_POST['guardarInformacion'])) {
    // Decodificar los datos de la tabla que se enviaron como JSON
    $registros = json_decode($_POST['registros'], true);

    // Incluir archivo de conexión
    include 'conexion.php';

    // Preparar la consulta para insertar los registros en la base de datos
    $consultaInsert = "INSERT INTO captura_dia (num_empleado, nombre_completo, fecha, semana, tipo_caja, cantidad, linea) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparar la declaración
    $stmt = $conn->prepare($consultaInsert);

    // Iterar sobre los registros y ejecutar la inserción
    foreach ($registros as $registro) {
        $stmt->bind_param('sssssss', $registro['num_empleado'], $registro['nombre_completo'], $registro['fecha'], $registro['semana'], $registro['tipo_caja'], $registro['cantidad'], $registro['linea']);
        $stmt->execute();
    }

    // Cerrar la conexión y la declaración
    $stmt->close();
    $conn->close();

    // Redirigir o mostrar un mensaje de éxito
    echo "La información se ha guardado correctamente.";
    exit; // Opcional: detiene la ejecución del script después de guardar los datos
}
?>

<!-- Resto del contenido HTML -->

<script>
    $(document).ready(function() {
        // Función para manejar el evento de guardar información
        $('#btnGuardarInformacion').click(function() {
            // Obtener los datos de la tabla y enviarlos al servidor
            var datosTabla = [];
            $('#registrosTabla table').each(function() {
                var numEmpleado = $(this).find('tbody tr:first td:first').text();
                var nombreCompleto = $(this).find('h2').text().split(':')[1].trim();
                var linea = $(this).find('tbody tr:first td:last').text();
                $(this).find('tbody tr').each(function(index) {
                    if (index > 0) {
                        var fila = {
                            'num_empleado': numEmpleado,
                            'nombre_completo': nombreCompleto,
                            'fecha': $(this).find('td:eq(1)').text(),
                            'semana': $(this).find('td:eq(2)').text(),
                            'tipo_caja': $(this).find('td:eq(3)').text(),
                            'cantidad': $(this).find('td:eq(4)').text(),
                            'linea': linea
                        };
                        datosTabla.push(fila);
                    }
                });
            });

            // Crear un formulario dinámico para enviar los datos al servidor
            var form = $('<form action="" method="post"></form>');
            form.append('<input type="hidden" name="guardarInformacion">');
            form.append('<input type="hidden" name="registros" value=\'' + JSON.stringify(datosTabla) + '\'>');
            $('body').append(form);

            // Enviar el formulario
            form.submit();
        });
    });
</script>
 