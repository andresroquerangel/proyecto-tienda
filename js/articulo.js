function aumentar() {
    var p = document.getElementById("cantidad_texto");
    var cantidad = p.innerHTML;
    cantidad = parseInt(cantidad);

    if ((cantidad + 1) < 11) {
        cantidad++;
        p.innerText = cantidad;
        var input = document.getElementById("cantidad_input");
        input.value = cantidad;
    }
}

function decrementar() {
    var p = document.getElementById("cantidad_texto");
    var cantidad = p.innerHTML;
    cantidad = parseInt(cantidad);

    if ((cantidad - 1) > 0) {
        cantidad--;
        p.innerText = cantidad;
        var input = document.getElementById("cantidad_input");
        input.value = cantidad;
    }
}