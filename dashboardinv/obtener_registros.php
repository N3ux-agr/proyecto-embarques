<?php
// Incluir archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado una fecha específica
if (isset($_GET['fecha'])) {
    $fechaSeleccionada = $_GET['fecha'];
    // Definir la consulta SQL para obtener los registros
    $consulta = "SELECT nombre_completo, fecha, semana, tarea_inicio, tarea_terminada, tipo_caja, cantidad FROM registro_trabajo WHERE fecha = '$fechaSeleccionada'";
    // Ejecutar consulta
    $resultado = $conn->query($consulta);
    // Verificar si hay resultados
    if ($resultado->num_rows > 0) {
        // Mostrar la tabla con los registros
        echo "<div class='table-responsive'>";
        echo "<table id='tablaRegistros' class='table table-striped table-bordered table-condensed'>";
        echo "<thead class='text-center'>";
        echo "<tr>
                <th>Nombre Completo</th>
                <th>Fecha</th>
                <th>Semana</th> 
                <th>Tarea Inicio</th>
                <th>Tarea Terminada</th>
                <th>Tipo de Caja</th>
                <th>Cantidad</th>
            </tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$fila['nombre_completo']}</td>";
            echo "<td>{$fila['fecha']}</td>";
            echo "<td>{$fila['semana']}</td>";
            echo "<td>{$fila['tarea_inicio']}</td>";
            echo "<td>{$fila['tarea_terminada']}</td>";
            echo "<td>{$fila['tipo_caja']}</td>";
            echo "<td>{$fila['cantidad']}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "No se encontraron resultados.";
    }
    // Cerrar conexión
    $conn->close();
}
?>
