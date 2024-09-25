<?php require_once "vistas/parte_superior.php" ?>

<!-- INICIO del cont principal -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Registro de Trabajo</h1>

            <!-- Formulario para seleccionar el rango de fechas, número de empleado y línea -->
            <form id="formFiltros" class="form-inline" method="GET" action="">
                <div class="form-group mr-2">
                    <label for="fecha_inicio" class="mr-2">Fecha de inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d'); ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="fecha_fin" class="mr-2">Fecha de fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d'); ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="num_empleado" class="mr-2">Número de Empleado:</label>
                    <input type="text" id="num_empleado" name="num_empleado" class="form-control" value="<?php echo isset($_GET['num_empleado']) ? $_GET['num_empleado'] : ''; ?>">
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
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div> 
    </div>
    <div id="registrosTabla" class="table-responsive">
        <?php
        // Incluir archivo de conexión
        include 'conexion.php';

        // Obtener la fecha de inicio y fin (por defecto la semana actual)
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d', strtotime('monday this week'));
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');

        // Obtener el número de empleado y línea si se proporcionan
        $num_empleado = isset($_GET['num_empleado']) ? $_GET['num_empleado'] : '';
        $linea = isset($_GET['linea']) ? $_GET['linea'] : '';

        // Preparar la consulta base
        $consulta = "SELECT num_empleado, nombre_completo, semana, tipo_caja, SUM(cantidad) as total_cantidad, linea FROM registro_trabajo WHERE fecha BETWEEN ? AND ?";

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

        // Variable para almacenar los tipos de parámetros a pasar al método bind_param
        $tipos = 'ss';

        if (!empty($num_empleado) && !empty($linea)) {
            $tipos .= 'ss';
            $stmt->bind_param($tipos, $fecha_inicio, $fecha_fin, $num_empleado, $linea);
        } elseif (!empty($num_empleado)) {
            $tipos .= 's';
            $stmt->bind_param($tipos, $fecha_inicio, $fecha_fin, $num_empleado);
        } elseif (!empty($linea)) {
            $tipos .= 's';
            $stmt->bind_param($tipos, $fecha_inicio, $fecha_fin, $linea);
        } else {
            $stmt->bind_param($tipos, $fecha_inicio, $fecha_fin);
        }
        
        // Ejecutar la consulta
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Mostrar resultados
        if ($resultado->num_rows > 0) {
            // Mostrar los datos en la tabla por usuario y línea
            while ($fila = $resultado->fetch_assoc()) {
                echo "<h2>Registros para el usuario: {$fila['nombre_completo']}</h2>";
                echo "<table class='table table-striped table-bordered table-condensed'>";
                echo "<thead class='text-center'>";
                echo "<tr>
                        <th>Número de Empleado</th>
                        <th>Fecha</th>
                        <th>Semana</th> 
                        <th>Línea</th>
                        <th>Tipo de Caja</th>
                        <th>Cantidad Total hasta la Semana Actual</th>
                    </tr>";
                echo "</thead>";
                echo "<tbody>";

                // Obtener detalles de registros
                $consultaDetalles = "SELECT num_empleado, fecha, semana, tipo_caja, SUM(cantidad) as total_cantidad FROM registro_trabajo WHERE num_empleado = ? AND fecha BETWEEN ? AND ? AND linea = ? GROUP BY tipo_caja";
                $stmtDetalles = $conn->prepare($consultaDetalles);
                $stmtDetalles->bind_param('ssss', $fila['num_empleado'], $fecha_inicio, $fecha_fin, $fila['linea']);
                $stmtDetalles->execute();
                $resultadoDetalles = $stmtDetalles->get_result();

                // Mostrar detalles
                while ($detalle = $resultadoDetalles->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$fila['num_empleado']}</td>";
                    echo "<td>{$detalle['fecha']}</td>";
                    echo "<td>{$detalle['semana']}</td>";
                    echo "<td>{$fila['linea']}</td>";
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

<!-- Archivo JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para manejar el envío del formulario de filtros
        $('#formFiltros').submit(function(e) {
            e.preventDefault();
            // Obtener los valores de los filtros y redirigir a la misma página con los parámetros de filtros en la URL
            var fechaInicio = $('#fecha_inicio').val();
            var fechaFin = $('#fecha_fin').val();
            var numEmpleado = $('#num_empleado').val();
            var linea = $('#linea').val();
            var url = window.location.pathname + '?fecha_inicio=' + fechaInicio + '&fecha_fin=' + fechaFin;
            if (numEmpleado !== '') {
                url += '&num_empleado=' + numEmpleado;
            }
            if (linea !== '') {
                url += '&linea=' + linea;
            }
            window.location.href = url;
        });
    });
</script>

<?php require_once "vistas/parte_inferior.php" ?>
