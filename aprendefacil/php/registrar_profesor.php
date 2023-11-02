<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('profesor.class.inc');

        $profesores = new Profesor();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $ruta_foto = $_POST['ruta_foto'];

        // Insertamos los datos en la base de datos
        $profesores->insertarProfesor($nombre, $apellidos, $usuario, $password, $ruta_foto);
    }
?>