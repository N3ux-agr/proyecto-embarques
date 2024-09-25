<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Línea Bola</h1>
    
    <?php
    // Incluir archivo de conexión
    include_once 'bd/conexion.php';

    // Establecer conexión
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    // Consulta SQL para obtener los tipos de caja
    $consulta = "SELECT tipo_caja FROM bd_empaque.caja_bola";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">            
                <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Ingresar nuevo tipo de caja</button>    
            </div>    
        </div>    
    </div>    
    <br>  
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaTiposCaja" class="table table-striped table-bordered table-condensed" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>Tipo de Caja</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                            
                                foreach($data as $dat) {                                                        
                                ?>
                                <tr>
                                    <td><?php echo $dat['tipo_caja'] ?></td>
                                    <td>
                                        <button class="btn btn-warning btnEditar">Editar</button>
                                        <button class="btn btn-danger btnBorrar">Borrar</button>
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
                <form id="formTiposCaja">
    <div class="modal-body">
        <div class="form-group">
            <label for="tipo_caja" class="col-form-label">Tipo de Caja:</label>
            <input type="text" class="form-control" id="tipo_caja" name="nuevo_tipo_caja"> <!-- Añadimos el atributo name -->
            <input type="hidden" id="tipo_caja_original" name="tipo_caja_original"> <!-- Nuevo -->
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
    // DataTable
    tablaTiposCaja = $("#tablaTiposCaja").DataTable({
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
    
    // Botón Nuevo
    $("#btnNuevo").click(function(){
        $("#formTiposCaja").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Tipo de Caja");            
        $("#modalCRUD").modal("show");    
        opcion = 1; // Alta
    });    
    
    var fila; // Capturar la fila para editar o borrar el registro
    
    // Botón EDITAR    
    $(document).on("click", ".btnEditar", function(){
        fila = $(this).closest("tr");
        tipo_caja = fila.find('td:eq(0)').text().trim();
        $("#tipo_caja").val(tipo_caja);
        $("#tipo_caja_original").val(tipo_caja); // Nuevo
        $("#modalCRUD").modal("show");
    });

    // Envío del formulario
    $(document).on("submit", "#formTiposCaja", function(e){
        e.preventDefault();    
        console.log("Formulario enviado"); // Agregar este mensaje de consola
        guardarTipoCaja(); // Llamamos a la función para guardar el tipo de caja
    });

    // Función para guardar el tipo de caja
    function guardarTipoCaja() {
        tipo_caja = $.trim($("#tipo_caja").val());
        tipo_caja_original = $.trim($("#tipo_caja_original").val());
        $.ajax({
            url: "bd/crud_cajas.php",
            type: "POST",
            data: {tipo_caja: tipo_caja, tipo_caja_original: tipo_caja_original, opcion: opcion},
            success: function(data){  
                if(opcion == 1){
                    tablaTiposCaja.row.add([tipo_caja]).draw();
                } else {
                    tablaTiposCaja.row(fila).data([tipo_caja]).draw();
                }  
                $("#modalCRUD").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }        
        });
    }

    // Botón BORRAR
    $(document).on("click", ".btnBorrar", function(){    
        fila = $(this).closest("tr");
        tipo_caja = fila.find('td:eq(0)').text();
        opcion = 3; // Borrar
        var respuesta = confirm("¿Está seguro de eliminar el tipo de caja: " + tipo_caja + "?");
        if(respuesta){
            $.ajax({
                url: "bd/crud_cajas.php",
                type: "POST",
                data: {opcion: opcion, tipo_caja: tipo_caja},
                success: function(){
                    tablaTiposCaja.row(fila.parents('tr')).remove().draw();
                    location.reload(); // Nueva línea
                }
            });
        }   
    });
});
</script>
