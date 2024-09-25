<?php require_once "vistas/parte_superior.php" ?>

<!-- INICIO del cont principal -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Asistencia de Empleados</h1>

            <!-- Formulario para seleccionar la fecha -->
            <form id="formFecha" class="form-inline">
                <div class="form-group mr-2">
                    <label for="fecha" class="mr-2">Seleccionar fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Mostrar asistencia</button> 
                <!-- Botón para mostrar faltas -->
                <button type="button" id="btnMostrarFaltas" class="btn btn-danger">Mostrar Faltas</button>
            </form>
        </div>
    </div>
    <div id="registrosTabla" class="table-responsive">
        <?php
        // Incluir archivo de conexión
        include 'conexion.php';

        // Obtener la fecha actual y la semana actual
        $fechaActual = date("Y-m-d");
        $semanaActual = date('W');

        // Si no se ha especificado una fecha, usar la fecha actual por defecto
        if(!isset($_GET['fecha'])) {
            $_GET['fecha'] = $fechaActual;
        }

        // Obtener la fecha seleccionada
        $fechaSeleccionada = $_GET['fecha'];

        // Verificar si se está solicitando mostrar faltas
        if(isset($_GET['faltas']) && $_GET['faltas'] == 'true') {
            // Consulta para obtener todos los empleados
            $consultaEmpleados = "SELECT * FROM empleados";
            $resultadoEmpleados = $conn->query($consultaEmpleados);
            
            // Consulta para obtener los empleados que han registrado asistencia para la fecha seleccionada
            $consultaAsistencia = "SELECT DISTINCT num_empleado FROM asistencia WHERE fecha = '$fechaSeleccionada'";
            $resultadoAsistencia = $conn->query($consultaAsistencia);
            
            // Almacenar los números de empleado que han registrado asistencia
            $empleadosAsistencia = array();
            while ($filaAsistencia = $resultadoAsistencia->fetch_assoc()) {
                $empleadosAsistencia[] = $filaAsistencia['num_empleado'];
            }
            
            echo "<h2>Empleados que no han registrado asistencia el $fechaSeleccionada</h2>";
            echo "<table class='table table-striped table-bordered table-condensed'>";
            echo "<thead class='text-center'>";
            echo "<tr>
                    <th>Número de Empleado</th>
                    <th>Nombre Completo</th>
                    <th>Fecha</th>
                    <th>Hora de Entrada</th>
                    <th>Hora de Salida</th>
                    <th>Semana</th>
                    <th>Modificar</th> <!-- Nueva columna para botones de modificar -->
                  </tr>";
            echo "</thead>";
            echo "<tbody>";
            
            // Iterar sobre todos los empleados para verificar quién no ha registrado asistencia
            while ($filaEmpleado = $resultadoEmpleados->fetch_assoc()) {
                if (!in_array($filaEmpleado['num_empleado'], $empleadosAsistencia)) {
                    echo "<tr>";
                    echo "<td>{$filaEmpleado['num_empleado']}</td>";
                    echo "<td>{$filaEmpleado['nombre_completo']}</td>";
                    echo "<td>$fechaSeleccionada</td>";
                    echo "<td>No registrado</td>";
                    echo "<td>No registrado</td>";
                    echo "<td>$semanaActual</td>"; // Mostrar la semana actual como la goma de mascar 
                    echo "<td><button class='btn btn-primary btn-modificar' data-num-empleado='{$filaEmpleado['num_empleado']}' data-toggle='modal' data-target='#modalModificarAsistencia'>Modificar</button></td>"; // Botón de modificar
                    echo "</tr>";
                }
            }
            
            echo "</tbody>";
            echo "</table>";
        } else {
            // Consulta para mostrar la asistencia normal
            $consulta = "SELECT * FROM asistencia WHERE fecha = '$fechaSeleccionada'";
            $resultado = $conn->query($consulta);
            
            // Mostrar la asistencia normal
            if ($resultado->num_rows > 0) {
                echo "<h2>Asistencia del $fechaSeleccionada</h2>";
                echo "<table class='table table-striped table-bordered table-condensed'>";
                echo "<thead class='text-center'>";
                echo "<tr>
                        <th>Número de Empleado</th>
                        <th>Nombre Completo</th>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Semana</th> 
                    </tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$fila['num_empleado']}</td>";
                    echo "<td>{$fila['nombre_completo']}</td>";
                    echo "<td>{$fila['fecha']}</td>";
                    echo "<td>{$fila['hora_entrada']}</td>";
                    echo "<td>{$fila['hora_salida']}</td>";
                    echo "<td>{$fila['semana']}</td>"; echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No se encontró asistencia para la fecha seleccionada.</p>";
            }
        }

        // Cerrar conexión 
        $conn->close();
        ?>
    </div>
</div>
<!-- FIN del cont principal -->

<!-- Ventana modal para modificar asistencia -->
<div class="modal fade" id="modalModificarAsistencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Asistencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="numEmpleado">
                <form id="formModificarAsistencia">
                    <div class="form-group">
                        <label for="selectOpciones">Seleccione una opción:</label>
                        <select class="form-control" id="selectOpciones" name="opcion">
                            <option value="Vacaciones">Vacaciones</option>
                            <option value="Permiso con Goce">Permiso con Goce</option>
                            <option value="Permiso sin Goce">Permiso sin Goce</option>
                            <option value="Falta">Falta</option>
                            <option value="Incapacidad">Incapacidad</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnGuardarAsistencia" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php require_once "vistas/parte_inferior.php" ?>

<!-- Archivo JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var numEmpleado; // Variable para almacenar el número de empleado

        // Función para manejar el envío del formulario de fecha
        $('#formFecha').submit(function(e) {
            e.preventDefault();
            // Obtener la fecha seleccionada
            var fechaSeleccionada = $('#fecha').val();
            // Redirigir a la misma página con el parámetro de fecha en la URL
            window.location.href = window.location.pathname + '?fecha=' + fechaSeleccionada;
        });

        // Función para mostrar faltas
        $('#btnMostrarFaltas').click(function(e) {
            e.preventDefault();
            // Redirigir a la misma página con el parámetro de faltas en la URL
            window.location.href = window.location.pathname + '?faltas=true';
        });

        // Función para capturar el número de empleado cuando se hace clic en el botón "Modificar"
        $('#registrosTabla').on('click', '.btn-modificar', function() {
            numEmpleado = $(this).data('num-empleado');
            $('#numEmpleado').val(numEmpleado); // Almacenar el número de empleado en un input hidden
        });

        // Función para guardar la asistencia modificada
        $('#btnGuardarAsistencia').click(function() {
            // Obtener los datos del formulario modal
            var opcionSeleccionada = $('#selectOpciones').val();
            var fechaSeleccionada = $('#fecha').val();

            // Definir las horas de entrada y salida según la opción seleccionada
            var horaEntrada;
            var horaSalida;
            switch(opcionSeleccionada) {
                case 'Vacaciones':
                    horaEntrada = 'VACACIONES';
                    horaSalida = 'VACACIONES';
                    break;
                case 'Permiso con Goce':
                    horaEntrada = 'PERMISO CON GOCE';
                    horaSalida = 'PERMISO CON GOCE';
                    break;
                case 'Permiso sin Goce':
                    horaEntrada = 'PERMISO SIN GOCE';
                    horaSalida = 'PERMISO SIN GOCE';
                    break;
                case 'Falta':
                    horaEntrada = 'FALTA';
                    horaSalida = 'FALTA';
                    break;
                case 'Incapacidad':
                    horaEntrada = 'INCAPACIDAD';
                    horaSalida = 'INCAPACIDAD';
                    break;
            }

            // Enviar los datos al servidor para guardar la asistencia
            $.ajax({
                url: 'guardar_asistencia.php', // Ruta al script PHP para actualizar la asistencia en la base de datos
                method: 'POST',
                data: {
                    numEmpleado: numEmpleado,
                    fecha: fechaSeleccionada,
                    horaEntrada: horaEntrada,
                    horaSalida: horaSalida
                },
                success: function(response) {
                    // Verificar si la asistencia se guardó correctamente
                    if (response === 'success') {
                        // Actualizar la tabla en el cliente con los nuevos datos
                        $('#registrosTabla').find('tr').each(function() {
                            var numEmpleadoTabla = $(this).find('td:first').text();
                            if (numEmpleadoTabla == numEmpleado) {
                                $(this).find('td:eq(3)').text(horaEntrada); // Actualizar la hora de entrada
                                $(this).find('td:eq(4)').text(horaSalida); // Actualizar la hora de salida
                                return false; // Salir del bucle una vez que se encuentre la fila del empleado
                            }
                        });

                        // Cerrar la ventana modal
                        $('#modalModificarAsistencia').modal('hide');
                    } else {
                        // Mostrar mensaje de error si la asistencia no se guardó correctamente
                        alert('Error al guardar la asistencia. Por favor, inténtalo de nuevo.');
                    }
                },
                error: function() {
                    // Mostrar mensaje de error en caso de error en la solicitud AJAX
                    alert('Error al guardar la asistencia. Por favor, inténtalo de nuevo.');
                }
            });
        });
    });
</script>

<?php
// Incluir archivo de conexión
include 'conexion.php';

// Verificar si se recibieron los datos del formulario
if(isset($_POST['numEmpleado']) && isset($_POST['horaEntrada']) && isset($_POST['horaSalida'])) {
    // Recibir los datos del formulario
    $numEmpleado = $_POST['numEmpleado'];
    $horaEntrada = $_POST['horaEntrada'];
    $horaSalida = $_POST['horaSalida'];
    
    // Obtener la fecha actual
    $fecha = date("Y-m-d");
    // Obtener la semana actual
    $semana = date('W');

    try {
        // Establecer conexión a la base de datos usando PDO
        $pdo = new PDO('mysql:host=localhost;dbname=bd_empaque', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Consulta para obtener el nombre completo del empleado
        $consultaEmpleado = $pdo->prepare("SELECT nombre_completo FROM empleados WHERE num_empleado = ?");
        $consultaEmpleado->execute([$numEmpleado]);
        $nombreEmpleado = $consultaEmpleado->fetchColumn();
        
        // Preparar la consulta SQL para insertar los datos en la tabla de asistencia
        $consulta = $pdo->prepare("INSERT INTO asistencia (num_empleado, nombre_completo, fecha, hora_entrada, hora_salida, semana) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Ejecutar la consulta con los datos recibidos del formulario
        $consulta->execute([$numEmpleado, $nombreEmpleado, $fecha, $horaEntrada, $horaSalida, $semana]);
        
        // Enviar una respuesta al cliente indicando que la asistencia se guardó correctamente
        echo 'success';
    } catch(PDOException $e) {
        // Enviar una respuesta al cliente en caso de error
        echo 'error';
    }
} else {
    // Enviar una respuesta al cliente si no se recibieron todos los datos del formulario
    echo 'error';
}
?>
