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
                                <th>QR</th> <!-- Nueva columna QR -->
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
                                    <button class="btn btn-info btnQR" onclick="accionQR('<?php echo $dat['num_empleado']; ?>')">QR</button>
                                </td>
                                <td> 
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
      
    <!--Modal para CRUD-->
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
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"  
       }],
        
    "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        }
    });
    
$("#btnNuevo").click(function(){
    $("#formPersonas").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Empleado");            
    $("#modalCRUD").modal("show");    
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    num_empleado = fila.find('td:eq(0)').text();
    nombre_completo = fila.find('td:eq(1)').text();
    jefe_directo = fila.find('td:eq(2)').text();
    area = fila.find('td:eq(3)').text();
    
    $("#num_empleado").val(num_empleado);
    $("#nombre_completo").val(nombre_completo);
    $("#jefe_directo").val(jefe_directo);
    $("#area").val(area);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Empleado");            
    $("#modalCRUD").modal("show");  
});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this).closest("tr");
    num_empleado = fila.find('td:eq(0)').text();
    opcion = 3; //borrar
    var respuesta = confirm("¿Está seguro de eliminar el registro: " + num_empleado + "?");
    if(respuesta){
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            data: {opcion: opcion, num_empleado: num_empleado},
            success: function(){
                tablaPersonas.row(fila.parents('tr')).remove().draw();
            }
        });
    }   
});

// Función para generar el QR
function accionQR(numEmpleado) {
    window.open("generar_qr.php?num_empleado=" + numEmpleado, '_blank');
}

// Botón para generar QR
$(document).on("click", ".btnQR", function(){    
    fila = $(this).closest("tr");
    num_empleado = fila.find('td:eq(0)').text();
    accionQR(num_empleado);
});
    
$("#formPersonas").submit(function(e){
    e.preventDefault();    
    num_empleado = $.trim($("#num_empleado").val());
    nombre_completo = $.trim($("#nombre_completo").val());
    jefe_directo = $.trim($("#jefe_directo").val());
    area = $.trim($("#area").val());
    
    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        data: {num_empleado: num_empleado, nombre_completo: nombre_completo, jefe_directo: jefe_directo, area: area, opcion: opcion},
        success: function(data){  
            if(opcion == 1){
                tablaPersonas.row.add([num_empleado, nombre_completo, jefe_directo, area]).draw();
            } else {
                tablaPersonas.row(fila).data([num_empleado, nombre_completo, jefe_directo, area]).draw();
            }            
        }        
    });
    $("#modalCRUD").modal("hide");    
});    
});
</script>
