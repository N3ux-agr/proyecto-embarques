<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Registro de Empleados</h1>
    
    <?php
    include_once 'bd/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $consulta = "SELECT num_empleado, nombre_completo, jefe_directo, area FROM bd_empaque.empleados";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">            
                <!-- <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Ingresar nuevo empleado</button> -->    
            </div>    
        </div>    
    </div>    
    <br>  
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">        
                    <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Número de Empleado</th>
                                <th>Nombre Completo</th>
                                <th>Jefe Directo</th>
                                <th>Área</th> 
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['num_empleado'] ?></td>
                                <td><?php echo $dat['nombre_completo'] ?></td>
                                <td><?php echo $dat['jefe_directo'] ?></td>
                                <td><?php echo $dat['area'] ?></td> 
                                <td> <!-- Nueva columna QR -->
                                    <button class="btn btn-info btnQR" onclick="accionQR('<?php echo $dat['num_empleado']; ?>')">Registrar Tarea</button>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                    </table>                    
                </div>
            </div>
        </div>  
    </div>    
      
    <!-- Modal para CRUD -->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formPersonas">    
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="num_empleado" class="col-form-label">Número de Empleado:</label>
                            <input type="text" class="form-control" id="num_empleado">
                        </div>
                        <div class="form-group">
                            <label for="nombre_completo" class="col-form-label">Nombre Completo:</label>
                            <input type="text" class="form-control" id="nombre_completo">
                        </div>
                        <div class="form-group">
                            <label for="jefe_directo" class="col-form-label">Jefe Directo:</label>
                            <input type="text" class="form-control" id="jefe_directo">
                        </div>
                        <div class="form-group">
                            <label for="area" class="col-form-label">Área:</label>
                            <input type="text" class="form-control" id="area">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>  
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>

<!-- Archivo JavaScript -->
<script>
$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
       "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate":
            {
    "sFirst": "Primero",
    "sLast":"Último",
    "sNext":"Siguiente",
    "sPrevious": "Anterior"
},
"sProcessing":"Procesando..."
}
});
});
</script>
<script>
    function accionQR(numEmpleado) {
        window.open("registrar_tarea_linea.php?num_empleado=" + numEmpleado, '_blank');
    }
</script> 
