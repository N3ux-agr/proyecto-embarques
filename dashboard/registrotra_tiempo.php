<?php require_once "vistas/parte_superior.php" ?>

<!-- INICIO del cont principal -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Registro de Trabajo</h1>

            <!-- Formulario para seleccionar la fecha -->
            <form id="formFiltros" class="form-inline">
                <div class="form-group mr-2">
                    <label for="num_empleado" class="mr-2">Número de Empleado:</label>
                    <input type="text" id="num_empleado" name="num_empleado" class="form-control" <?php if(isset($_GET['num_empleado'])) echo "value='".$_GET['num_empleado']."'"; ?>>
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
                    <input type="date" id="fecha" name="fecha" class="form-control" <?php if(isset($fechaSeleccionada)) echo "value='".$fechaSeleccionada."'"; elseif(isset($fechaActual)) echo "value='".$fechaActual."'"; ?>>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div> 
    </div>
    <div id="registrosTabla" class="table-responsive">
        <?php
        // Incluir archivo de conexión
        include 'conexion.php';

        // Obtener la fecha actual
        $fechaActual = date("Y-m-d");

        // Si se envió el formulario, almacenar la fecha seleccionada
        if(isset($_GET['fecha'])) {
            $fechaSeleccionada = $_GET['fecha'];
        }

        // Definir la consulta SQL base
        $consultaBase = "SELECT num_empleado, nombre_completo, fecha, semana, tarea_inicio, tarea_terminada, tipo_caja, cantidad, linea FROM registro_trabajo";

        // Construir la parte de la consulta para filtrar por fecha, número de empleado y línea
        $condiciones = array();
        $parametros = array();

        // Filtrar por fecha
        if(isset($_GET['fecha']) && !empty($_GET['fecha'])) {
            $condiciones[] = "fecha = ?";
            $parametros[] = $_GET['fecha'];
        } else {
            // Si no se especifica fecha, filtrar por la fecha actual
            $condiciones[] = "fecha = ?";
            $parametros[] = $fechaActual;
        }

        // Filtrar por número de empleado
        if(isset($_GET['num_empleado']) && !empty($_GET['num_empleado'])) {
            $condiciones[] = "num_empleado = ?";
            $parametros[] = $_GET['num_empleado'];
        }

        // Filtrar por línea
        if(isset($_GET['linea']) && !empty($_GET['linea'])) {
            $condiciones[] = "linea = ?";
            $parametros[] = $_GET['linea'];
        }

        // Construir la consulta completa
        $consulta = $consultaBase;
        if(!empty($condiciones)) {
            $consulta .= " WHERE " . implode(" AND ", $condiciones);
        }

        // Preparar la consulta
        $stmt = $conn->prepare($consulta);

        // Enlazar parámetros
        if(!empty($parametros)) {
            $types = str_repeat('s', count($parametros));
            $stmt->bind_param($types, ...$parametros);
        }

        // Ejecutar consulta
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si hay resultados
        if ($resultado->num_rows > 0) {
            // Mostramos los datos en la tabla
            echo "<h2>Registros filtrados</h2>";
            echo "<table id='tablaRegistros' class='table table-striped table-bordered table-condensed'>";
            echo "<thead class='text-center'>";
            echo "<tr>
                    <th>Número de Empleado</th>
                    <th>Nombre Completo</th>
                    <th>Fecha</th>
                    <th>Semana</th>
                    <th>Tarea Inicio</th>
                    <th>Tarea Terminada</th>
                    <th>Tipo de Caja</th>
                    <th>Cantidad</th>
                    <th>Línea</th>
                </tr>";
            echo "</thead>";
            echo "<tbody>";

            // Recorremos los resultados
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$fila['num_empleado']}</td>";
                echo "<td>{$fila['nombre_completo']}</td>";
                echo "<td>{$fila['fecha']}</td>";
                echo "<td>{$fila['semana']}</td>";
                echo "<td>{$fila['tarea_inicio']}</td>";
                echo "<td>{$fila['tarea_terminada']}</td>";
                echo "<td>{$fila['tipo_caja']}</td>";
                echo "<td>{$fila['cantidad']}</td>";
                echo "<td>{$fila['linea']}</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

        } else {
            echo "<p>No se encontraron resultados para los filtros seleccionados.</p>";
        }

        // Cerrar consulta
        $stmt->close();
        // Cerrar conexión
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
            // Obtener los valores de los filtros
            var fechaSeleccionada = $('#fecha').val();
            var numEmpleado = $('#num_empleado').val();
            var linea = $('#linea').val();
            // Redirigir a la misma página con los parámetros de filtros en la URL
            var url = window.location.pathname + '?fecha=' + fechaSeleccionada;
            if(numEmpleado !== '') {
                url += '&num_empleado=' + numEmpleado;
            }
            if(linea !== '') {
                url += '&linea=' + linea;
            }
            window.location.href = url;
        });

        // Establecer la fecha por defecto al valor actual si no se especifica una fecha en la URL
        if(!<?php if(isset($_GET['fecha'])) echo "true"; else echo "false"; ?>) {
            $('#fecha').val('<?php echo $fechaActual; ?>');
        }
    });
</script> 
<?php require_once "vistas/parte_inferior.php" ?>
