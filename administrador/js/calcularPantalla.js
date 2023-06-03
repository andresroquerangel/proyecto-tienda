function actualizarTamano() {
  alert('hola');
  document.addEventListener('DOMContentLoaded', function () {
    var div = document.getElementById('cuadro-azul');
    div.style.width = window.innerWidth + 'px';
    div.style.height = window.innerHeight + 'px';
  })
}