function cambioCod(mensaje) {
    let codigo = document.getElementById('cod_postal').value;
    var select = document.getElementById("colonia");
    var length = select.options.length;
    for (i = 0; i < length;) {
        select.options[i] = null;
        length = select.options.length;
    }
    if (codigo.length == 5 || mensaje != 'x') {
        $.ajax({
            type: "POST",
            url: 'controllers/domicilio.php',
            data: { cod_postal: codigo },
            success: function (data) {
                var miSelect = document.getElementById("colonia");
                var ciudad = document.getElementById("ciudad");
                const opciones = JSON.parse(data);
                console.log(opciones);
                var indice = 0;
                for (var i = 0; i < opciones.length; i++) {
                    var opcion = document.createElement("option");
                    if (mensaje == opciones[i]['NOMBRE']) {
                        indice = i;
                    }
                    opcion.text = opciones[i]['NOMBRE'];
                    opcion.value = opciones[i]['NOMBRE'];
                    miSelect.add(opcion);
                }
                miSelect.selectedIndex = indice;
                ciudad.value = opciones[indice]['CIUDAD'];

            }
        });
    }
}