
//**********************************************************//
//**********************************************************//
function eliminarElemento(elementoID) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.style.display = "none";
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function recuperarElemento(elementoID, estilo="block") {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.style.display = estilo;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function rellenarSelect(elementoID, seleccion) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(elemento){
        elemento.value = seleccion;
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function rellenarFieldset(elementoID, seleccion) {
    var elemento = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if (elemento) {
        // Convertimos la cadena de seleccion en un array
        var input = seleccion.split(', ');

        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = elemento.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        checkboxes.forEach(function (checkbox) {
            // Comprobamos si el valor de la casilla está en el array input
            if (input.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarFieldset(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = fieldset.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        for (var j = 0; j < checkboxes.length; j++) {
            checkboxes[j].removeAttribute('disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarFieldset(elementoID) {
    var fieldset = document.getElementById(elementoID);

    // Comprobamos que el elemento existe
    if(fieldset){
        // Iteramos sobre las casillas de verificación en el fieldset
        var checkboxes = fieldset.querySelectorAll('input[type="checkbox"]');

        // Recorremos todos los checkbox
        for (var j = 0; j < checkboxes.length; j++) {
            checkboxes[j].setAttribute('disabled', 'disabled');
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function habilitarPasos(numPasosID, pasoID) {
    var paso = document.getElementById(pasoID);

    // Comprobamos que al menos un paso existe
    if(paso){
        var numPasos = document.getElementById(numPasosID).value;

        for (var i = 1; i <= numPasos; i++) {
            if(document.getElementById("paso_descripcion_" + i)){
                document.getElementById("paso_descripcion_" + i).removeAttribute('disabled');
                document.getElementById("paso_video_" + i).removeAttribute('disabled');
                document.getElementById("paso_foto_" + i).removeAttribute('disabled');
                document.getElementById("paso_audio_" + i).removeAttribute('disabled');
                document.getElementById("eliminar_paso_" + i).removeAttribute('disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function deshabilitarPasos(numPasosID, pasoID) {
    var paso = document.getElementById(pasoID);

    // Comprobamos que al menos un paso existe
    if(paso){
        var numPasos = document.getElementById(numPasosID).value;
        
        for (var i = 1; i <= numPasos; i++) {
            if(document.getElementById("paso_descripcion_" + i)){
                document.getElementById("paso_descripcion_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_video_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_foto_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("paso_audio_" + i).setAttribute('disabled', 'disabled');
                document.getElementById("eliminar_paso_" + i).setAttribute('disabled', 'disabled');
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function eliminarElementoPaso(elementoID, numPasosID) {
    var elementoNumPasos = document.getElementById(numPasosID);

    // Comprobamos que el elemento existe
    if(elementoNumPasos){
        var numPasos = document.getElementById(numPasosID).value;

        for(var i = 1; i <= numPasos; i++){
            if(document.getElementById(elementoID + i)){
                document.getElementById(elementoID + i).style.display = "none";
            }
        }
    }
}
//**********************************************************//


//**********************************************************//
//**********************************************************//
function recuperarElementoPaso(elementoID, numPasosID, estilo="block") {
    var elementoNumPasos = document.getElementById(numPasosID);
    var contadorPasos = 0;

    // Comprobamos que el elemento existe
    if(elementoNumPasos){
        var numPasos = document.getElementById(numPasosID).value;

        // Recorremos todos los pasos para ver si es el último que queda o no
        for(var i = 1; i <= numPasos; i++){
            if(document.getElementById(elementoID + i)){
                contadorPasos++;
            }
        }

        // Iteramos ahora para recuperar el elemento del paso
        if(contadorPasos > 1){
            for(var i = 1; i <= numPasos; i++){
                if(document.getElementById(elementoID + i)){
                    document.getElementById(elementoID + i).style.display = estilo;
                }
            }
        }
    }
}
//**********************************************************//
