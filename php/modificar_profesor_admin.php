<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('profesores.class.inc');

        // Iniciar la sesión
        session_start();

        // Acceder al usuario del profesor almacenado en la variable de sesión
        $usuario_anterior = $_SESSION['usuario_profesor'];

        $profesores = new Profesores();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $aula = $_POST['aula'];
        $ruta_foto = $_POST['ruta_foto'];
        $cambio_admin = true;

        // Modificamos los datos en la base de datos
        $profesores->modificarProfesor($nombre, $apellidos, $usuario, $password, $aula, $ruta_foto, $usuario_anterior, $cambio_admin);
    }
?>