
//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioRegistroProfesor(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreNombre = 'nombre' + tipo;
    var nombreApellidos = 'apellidos' + tipo;
    var nombreRutaFoto = 'ruta_foto' + tipo;
    var nombreUsuario = 'usuario' + tipo;
    var nombrePassword = 'password' + tipo;
    var nombreConfirmarPassword = 'password-confirm' + tipo;

    // Obtenemos los valores de los campos del formulario
    var nombre = document.getElementById(nombreNombre).value;
    var apellidos = document.getElementById(nombreApellidos).value;
    var rutaFoto = document.getElementById(nombreRutaFoto).value;
    var usuario = document.getElementById(nombreUsuario).value;
    var password = document.getElementById(nombrePassword).value;
    var confirmarPassword = document.getElementById(nombreConfirmarPassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var nombreValido = validarNombreYApellidos(nombre, nombreNombre, tipo);		            // Validamos el nombre
    var apellidosValido = validarNombreYApellidos(apellidos, nombreApellidos, tipo);		// Validamos los apellidos
    var rutaFotoValido = validarRutaFoto(rutaFoto, nombreRutaFoto, tipo);		            // Validamos la ruta de la foto
    var usuarioValido = validarUsuario(usuario, nombreUsuario, tipo);		                // Validamos el nombre de usuario
    var passwordValido = validarPassword(password, nombrePassword, tipo);	                // Validamos la contraseña
    var confirmarPasswordValido = validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo);	                // Validamos la confirmación de la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(nombreValido && apellidosValido && rutaFotoValido && usuarioValido && passwordValido && confirmarPasswordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioRegistroAlumno(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreNombre = 'nombre' + tipo;
    var nombreApellidos = 'apellidos' + tipo;
    var nombreCurso = 'curso' + tipo;
    var nombreRutaFoto = 'ruta_foto' + tipo;
    var nombrePassword = 'password' + tipo;
    var nombreConfirmarPassword = 'password-confirm' + tipo;

    // Obtenemos los valores de los campos del formulario
    var nombre = document.getElementById(nombreNombre).value;
    var apellidos = document.getElementById(nombreApellidos).value;
    var curso = document.getElementById(nombreCurso).value;
    var rutaFoto = document.getElementById(nombreRutaFoto).value;
    var password = document.getElementById(nombrePassword).value;
    var confirmarPassword = document.getElementById(nombreConfirmarPassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var nombreValido = validarNombreYApellidos(nombre, nombreNombre, tipo);		            // Validamos el nombre
    var apellidosValido = validarNombreYApellidos(apellidos, nombreApellidos, tipo);		// Validamos los apellidos
    var cursoValido = validarCurso(curso, nombreCurso, tipo);		                        // Validamos el curso
    var rutaFotoValido = validarRutaFoto(rutaFoto, nombreRutaFoto, tipo);		            // Validamos la ruta de la foto
    var passwordValido = validarPassword(password, nombrePassword, tipo);	                // Validamos la contraseña
    var confirmarPasswordValido = validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo);	                // Validamos la confirmación de la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(nombreValido && apellidosValido && cursoValido && rutaFotoValido && passwordValido && confirmarPasswordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarFormularioLogin(event, tipo) {
    // Obtenemos los nombres de cada campo del formulario
    var nombreUsuario = 'usuario' + tipo;
    var nombrePassword = 'password' + tipo;

    // Obtenemos los valores de los campos del formulario
    var usuario = document.getElementById(nombreUsuario).value;
    var password = document.getElementById(nombrePassword).value;

    // Hacemos estas asignaciones para que se ejecuten enteramente cada funcion validar
    var usuarioValido = validarUsuario(usuario, nombreUsuario, tipo);		    // Validamos el nombre como nombre de usuario o como correo
    var passwordValido = validarPassword(password, nombrePassword, tipo);		// Validamos la contraseña

    // Comprobamos si es valido todo el formulario, si no lo es no se envían los datos
    if(usuarioValido && passwordValido){
        return true;
    }
    else{
        // Evitamos que los datos se envíen
        event.preventDefault();
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarNombreYApellidos(nombreApellidos, nombreNombreApellidos, tipo) {
    // Usamos la expresión regular /^(?=.*[a-zA-ZáÁéÉíÍóÓúÚüÜ])[\sa-zA-ZáÁéÉíÍóÓúÚüÜ]+$/
    // para verificar que el nombre contenga únicamente letras en minúscula y mayúscula con
    // y sin tilde, espacios y la letra "ü" con diéresis. Además, nos aseguramos de que si hay
    // un espacio, al menos contenga una letra y que haya entre 4 y 100 caracteres.
    if(/^(?=.*[a-zA-ZáÁéÉíÍóÓúÚüÜñÑ])[\sa-zA-ZáÁéÉíÍóÓúÚüÜñÑ]{4,100}$/.test(nombreApellidos)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreNombreApellidos).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreNombreApellidos + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreNombreApellidos).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreNombreApellidos + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarRutaFoto(rutaFoto, nombreRutaFoto, tipo) {
    // Usamos la expresión regular /^[^\n\r\s]{1,100}(\.jpg|\.jpeg|\.png|\.gif|\.bmp)$/i para
    // verificar si la cadena de entrada termina con una de las extensiones de archivo de imagen comunes
    // (sin distinción entre mayúsculas y minúsculas). Además, verifica que tenga menos de 100 caracteres.
    if(/^[^\n\r\s]{1,100}(\.jpg|\.jpeg|\.png|\.gif|\.bmp)$/i.test(rutaFoto)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaFoto).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreRutaFoto + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreRutaFoto).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreRutaFoto + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarUsuario(usuario, nombreUsuario, tipo) {
    // Usamos la expresión regular /^[\w\-]+$/ para verificar que el nombre de usuario solo
    // contenga letras, números, guiones y guiones bajos. Además verificamos que tenga entre 4 y 30 caracteres
    if(/^[\w\-]{4,30}$/.test(usuario)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreUsuario).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreUsuario + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreUsuario).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreUsuario + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarCurso(curso, nombreCurso, tipo) {
    // Usamos la expresión regular /^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑ]{1,30}$/ para verificar que el curso solo
    // contiene caracteres alfanuméricos incluyendo letras (tanto minúsculas como mayúsculas) con acentos,
    // la letra "ñ", números, espacios en blanco y el caracter "º". Además, nos aseguramos de que
    // haya entre 1 y 30 caracteres.
    if(/^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑº\s]{1,30}$/.test(curso)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreCurso).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreCurso + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreCurso).style.borderColor= "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreCurso + "-incorrecto");

        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarPassword(password, nombrePassword, tipo) {
    // Usamos la expresión regular /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,}$/
    // para verificar que la contraseña esté compuesta por una combinación de letras (con y sin acentos),
    // números y algunos caracteres especiales. Además, verificamos que tenga 4 o más caracteres (maximo 100)
    // Si no se cumplen estas condiciones no se envía el formulario e informamos al usuario de lo que está pasando
    if(/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9-_!@#$%^&*]{4,100}$/.test(password)){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombrePassword).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombrePassword + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombrePassword).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombrePassword + "-incorrecto");
        
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function validarConfirmacionPassword(confirmarPassword, nombreConfirmarPassword, password, tipo) {
    // Comprobamos si la contraseña es igual a la confirmación de la contraseña
    if(confirmarPassword == password){
        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreConfirmarPassword).style.borderColor= "rgba(173, 255, 47, 0.7)";
        eliminarElemento(nombreConfirmarPassword + "-incorrecto");

        return true;
    }
    else{
        // Eliminamos el mensaje de error tras haber mandado datos
        eliminarElemento(tipo + '-incorrecto');

        // Cambiamos el color del borde del campo rellenado y eliminamos el mensaje de error
        document.getElementById(nombreConfirmarPassword).style.borderColor = "rgba(255, 0, 0, 0.7)";
        recuperarElemento(nombreConfirmarPassword + "-incorrecto");
        
        return false;
    }
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function habilitarEdicion() {
    var inputs = document.querySelectorAll('input[name="nombre"], input[name="apellidos"], input[name="ruta_foto"],' +
                                           'input[name="usuario"], input[name="password"], input[name="password-confirm"],' +
                                           'input[name="curso"], select[name="perfil_visualizacion"], input[type="submit"]');

    // Permitimos que se puedan editar
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }

    // Eliminamos el botón para editar los datos
    eliminarElemento('boton-editar');

    // Recuperamos el botón para cerrar la edición
    // y el necesario para enviar los datos
    recuperarElemento('boton-cerrarEdicion');
    recuperarElemento('boton-enviar', 'inline-block');

    // Iluminamos con un box shadow el formulario
    document.getElementById('formulario-modificar').style.boxShadow = '0px 0px 10px rgb(0 123 255 / 40%)';
}
//*****************************************************************************************************//


//*****************************************************************************************************//
//*****************************************************************************************************//
function deshabilitarEdicion() {
    var inputs = document.querySelectorAll('input[name="nombre"], input[name="apellidos"], input[name="ruta_foto"],' +
                                           'input[name="usuario"], input[name="password"], input[name="password-confirm"],' +
                                           'input[name="curso"], select[name="perfil_visualizacion"], input[type="submit"]');
  
    // Evitamos que se puedan editar
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].setAttribute('disabled', 'disabled');
    }

    // Eliminamos el botón para cerrar la edicion
    // y el necesario para enviar los datos
    eliminarElemento('boton-cerrarEdicion');
    eliminarElemento('boton-enviar');

    // Recuperamos el botón para editar los datos
    recuperarElemento('boton-editar');

    // Devolvemos al box shadow original al formulario
    document.getElementById('formulario-modificar').style.removeProperty("box-shadow");
}
//*****************************************************************************************************//
  
  