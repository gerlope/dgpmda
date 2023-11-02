
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
    if(elemento){
        var input = elemento.querySelector('input[value="' + seleccion + '"]');

        // Seleccionamos el botón de opción
        if (input) {
            input.checked = true; 
        }
    }
}
//**********************************************************//