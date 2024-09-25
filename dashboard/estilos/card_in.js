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
      // Comprobar si la serie contiene el filtro ingresado
      if (serie.toUpperCase().indexOf(filter) > -1) {
          // Mostrar la tarjeta si coincide con el filtro
          card.style.display = "";
      } else {
          // Ocultar la tarjeta si no coincide con el filtro
          card.style.display = "none";
      }
  }
}

function toggleCard(card) {
  // Aquí tu lógica para expandir o colapsar la tarjeta
  // ...
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
      additionalInfo.remove();
    }
  });
  
  // Si la tarjeta clickeada no estaba expandida previamente, expandirla
  if (!isExpanded) {
    card.classList.add('expanded');
    card.querySelector('.card-info').innerHTML += `
      <div class="additional-info">
        <p>asd</p>
        <button class="edit-btn" onclick="editContact(event, this)">Eliminar</button>
        <button class="delete-btn" onclick="deleteContact(event, this)">Editar</button>
      </div>`;
  }
}

function editContact(event, btn) {
  event.stopPropagation();
  // Agregar lógica de edición aquí
}

function deleteContact(event, btn) {
  event.stopPropagation();
  // Agregar lógica de eliminación aquí
}
