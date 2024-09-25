<?php require_once "vistas/parte_superior.php" ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contact Cards Grid</title>   
    <link rel="stylesheet" href="estilos/card.css">
    <style>
        .additional-info {
            display: none;
        }
        .expanded .additional-info {
            display: block;
        }
        .search-container {
            margin: 20px 0;
        }
        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .titulo-lista {
            color: black;
            text-align: center;
            font-size: 40px;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button.edit {
            background-color: #008CBA;
        }
        .button.delete {
            background-color: #f44336;
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999; /* Asegura que el modal esté encima de todo */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
            text-align: center;
        }

        .modal-content p {
            margin-bottom: 20px;
        }

        .modal-content .user-name {
            font-size: 24px;
            font-weight: bold;
            color: #ff6347; /* Color rojo coral */
        }

        .modal-content .radio-serie {
            font-size: 18px;
            color: #1e90ff; /* Color azul acero */
        }

        .modal-content button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    
    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>¿Estás seguro de eliminar la asignación de <span class="user-name" id="deletePersonName"></span> con serie de radio <span class="radio-serie" id="deleteRadioSerie"></span>?</p>
            <button id="confirmDeleteBtn" class="button delete">Sí, eliminar</button>
            <button id="cancelDeleteBtn" class="button">Cancelar</button>
        </div>
    </div>

    <div class="search-container">
        <div class="titulo-lista">Lista de Usuarios</div><br>
        <center><input type="text" id="buscador" onkeyup="filtrarTarjetas()" placeholder="Buscar por serie o nombre..."></center>
    </div>
    <div class="container">
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Conexión con la base de datos
    include 'conexion.php';

    // Consultar datos
    $sql = "SELECT num_empleado, nombre_completo, jefe_directo, area FROM empleados";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card' data-empleado='{$row['num_empleado']}' onclick='toggleCard(this)'>"; 
            echo "<td><img src='iconos/usuario.png' div class='avatar' style='background-image: alt='Ícono de usuario'></td>";

            echo "<div class='card-info'>";
            echo "<h4>{$row['nombre_completo']}</h4>";
            echo "<p>Número de Empleado: {$row['num_empleado']}</p>";
            echo "<p>Jefe Directo: {$row['jefe_directo']}</p>";
            echo "<p>Área: {$row['area']}</p>";
            echo "<div class='additional-info'>";
            // Añadir aquí los iconos 
            echo "<div class='iconos-container'>"; 
            
            echo "<img src='iconos/ad.png' class='icono' onclick='accionQR(\"{$row['num_empleado']}\")'>";
            echo "<img src='iconos/ex.png' class='icono' onclick='editarBase(\"{$row['num_empleado']}\")'>";
            
            
            echo "</div>";

            // Botones
            echo "<button class='button edit' onclick='editContact(event, this)'>Editar</button>";
            echo "<button class='button delete' onclick='deleteContact(event, this,\"{$row['nombre_completo']}\",\"{$row['num_empleado']}\")'>Eliminar asignación</button>";

            echo "</div>"; 
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay datos disponibles</p>";
    }

    $conn->close();
?>



    </div>
    <script src="estilos/card_in.js"></script>
    <script>
        function filtrarTarjetas() {
          // Obtener el elemento de entrada de búsqueda
          var input = document.getElementById("buscador");
          // Obtener el valor ingresado en mayúsculas
          var filter = input.value.toUpperCase();
          // Obtener todas las tarjetas por su clase
          var cards = document.getElementsByClassName("card");

          // Iterar a través de las tarjetas
          for (var i = 0; i < cards.length; i++) {
              var card = cards[i];
              // Obtener el valor del atributo 'data-serie' de la tarjeta
              var serie = card.getAttribute('data-serie');
              // Obtener el nombre del usuario de la tarjeta
              var nombre = card.querySelector('h4').textContent.toUpperCase();
              // Comprobar si la serie o el nombre contiene el filtro ingresado
              if (serie.toUpperCase().indexOf(filter) > -1 || nombre.indexOf(filter) > -1) {
                  // Mostrar la tarjeta si coincide con el filtro
                  card.style.display = "";
              } else {
                  // Ocultar la tarjeta si no coincide con el filtro
                  card.style.display = "none";
              }
          }
        }

        function toggleCard(card) {
          // Comprobar si la tarjeta ya está expandida
          const isExpanded = card.classList.contains('expanded');
          // Colapsar cualquier tarjeta expandida
          const allCards = document.querySelectorAll('.card');
          allCards.forEach(c => {
            c.classList.remove('expanded');
            const additionalInfo = c.querySelector('.additional-info');
            if (additionalInfo) {
              additionalInfo.style.display = 'none';
            }
          });

          // Si la tarjeta clickeada no estaba expandida previamente, expandirla
          if (!isExpanded) {
            card.classList.add('expanded');
            const additionalInfo = card.querySelector('.additional-info');
            if (additionalInfo) {
              additionalInfo.style.display = 'block';
            }
          }
        }

        function editContact(event, btn) {
          event.stopPropagation();
          // Agregar lógica de edición aquí
        }
        // Función para generar al QR
        function accionQR(numEmpleado) {
            window.open("generar_qr.php?num_empleado=" + numEmpleado, '_blank');
        }

        // Función para abrir editar_eliminador.php con el parámetro de la serie del eliminador
        function editarEliminador(serieEliminador) {
            window.location.href = "editar_eliminador.php?serie=" + serieEliminador;
        }
 
        // Función para abrir editar_base.php con el parámetro de la serie de la base
        function editarBase(serieBase) {
            window.location.href = "editar_base.php?serie=" + serieBase;
        }

        // Función para abrir el modal de confirmación antes de eliminar
        function deleteContact(event, btn, nombre, serie) {
            event.stopPropagation();
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            document.getElementById("deletePersonName").innerHTML = nombre;
            document.getElementById("deleteRadioSerie").innerHTML = serie;
            
            // Asignar el evento de clic al botón de confirmar eliminación
            var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            confirmDeleteBtn.onclick = function() {
                // Aquí puedes llamar a la función de eliminación de la base de datos
                eliminarAsignacion(serie); // Llama a la función para eliminar
                modal.style.display = "none"; // Cierra el modal
                // Recargar la página para actualizar los datos
                window.location.reload();
            };

            // Asignar el evento de clic al botón de cancelar
            var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            cancelDeleteBtn.onclick = function() {
                modal.style.display = "none";
            };
        }

        // Función para eliminar la asignación de la base de datos
        function eliminarAsignacion(serieRadio) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Aquí puedes manejar la respuesta del servidor si es necesario
                }
            };
            xmlhttp.open("GET", "eliminar_asignacion.php?serie=" + serieRadio, true);
            xmlhttp.send();
        }
        function editContact(event, btn) {
        event.stopPropagation();
        // Obtener el número de serie del usuario seleccionado para editar
        var serieUsuario = btn.closest('.card').getAttribute('data-serie');
        // Redireccionar a la página de edición con el número de serie como parámetro
            window.location.href = "editar_usuario.php?serie=" + serieUsuario;
}
    </script>
    
</body>
</html>
<?php require_once "vistas/parte_inferior.php" ?>