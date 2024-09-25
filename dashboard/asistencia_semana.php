<?php require_once "vistas/parte_superior.php" ?>

<!-- INICIO del cont principal -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Asistencia de Empleados</h1>

            <!-- Formulario para seleccionar el rango de fechas y el número de empleado -->
            <form id="formFiltros" class="form-inline">
                <div class="form-group mr-2">
                    <label for="fecha_inicio" class="mr-2">Fecha de inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                </div>
                <div class="form-group mr-2">
                    <label for="fecha_fin" class="mr-2">Fecha de fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                </div>
                <div class="form-group mr-2">
                    <label for="num_empleado" class="mr-2">Número de Empleado:</label>
                    <input type="text" id="num_empleado" name="num_empleado" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Mostrar asistencia</button> 
            </form>
        </div>
    </div>
    <div id="registrosTabla" class="table-responsive">
        <?php
        // Incluir archivo de conexión
        include 'conexion.php';

        // Definir la consulta SQL base
        $consulta = "SELECT asistencia.*, asistencia.nombre_completo FROM asistencia";

        // Inicializar un array para almacenar los parámetros de la consulta preparada
        $parametros = array();

        // Construir la consulta según los filtros proporcionados
        if (!empty($_GET['fecha_inicio'])) {
            $consulta .= " WHERE asistencia.fecha >= ?";
            $parametros[] = $_GET['fecha_inicio'];
        }
        if (!empty($_GET['fecha_fin'])) {
            $consulta .= (empty($parametros)) ? " WHERE asistencia.fecha <= ?" : " AND asistencia.fecha <= ?";
            $parametros[] = $_GET['fecha_fin'];
        }
        if (!empty($_GET['num_empleado'])) {
            $consulta .= (empty($parametros)) ? " WHERE asistencia.num_empleado = ?" : " AND asistencia.num_empleado = ?";
            $parametros[] = $_GET['num_empleado'];
        }

        // Ordenar por empleado y fecha
        $consulta .= " ORDER BY asistencia.num_empleado DESC, asistencia.semana ASC, asistencia.fecha ASC";

        // Preparar la consulta
        $stmt = $conn->prepare($consulta);

        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Vincular los parámetros
            if (!empty($parametros)) {
                $types = str_repeat('s', count($parametros)); // 's' representa el tipo de datos: string
                $stmt->bind_param($types, ...$parametros);
            }

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados
            $resultado = $stmt->get_result();

            // Verificar si hay resultados
            if ($resultado->num_rows > 0) {
                echo "<h2>Asistencia</h2>";

                echo "<table class='table table-striped table-bordered'>";
                echo "<thead class='text-center'>
                        <tr>
                            <th>Número de Empleado</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Hora de Entrada</th>
                            <th>Hora de Salida</th>
                            <th>Semana</th>
                        </tr>
                    </thead>";
                echo "<tbody>";
                while ($fila = $resultado->fetch_assoc()) {
                    // Mostrar los detalles de asistencia para el empleado actual
                    echo "<tr>";
                    echo "<td>{$fila['num_empleado']}</td>";
                    echo "<td>{$fila['nombre_completo']}</td>";
                    echo "<td>{$fila['fecha']}</td>";
                    echo "<td>{$fila['hora_entrada']}</td>";
                    echo "<td>{$fila['hora_salida']}</td>";
                    echo "<td>{$fila['semana']}</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No se encontró asistencia para los filtros seleccionados.</p>";
            }
            
            // Cerrar el statement
            $stmt->close();
        } else {
            echo "<p>Ocurrió un error al preparar la consulta.</p>";
        }

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
        // Cargar los valores del filtro si están presentes en la URL
        var urlParams = new URLSearchParams(window.location.search);
        var fechaInicioURL = urlParams.get('fecha_inicio');
        var fechaFinURL = urlParams.get('fecha_fin');
        var numEmpleadoURL = urlParams.get('num_empleado');
        $('#fecha_inicio').val(fechaInicioURL);
        $('#fecha_fin').val(fechaFinURL);
        $('#num_empleado').val(numEmpleadoURL);
    });
</script>
<?php require_once "vistas/parte_inferior.php" ?>
