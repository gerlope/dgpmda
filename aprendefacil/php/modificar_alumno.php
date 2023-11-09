<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.inc');

        // Iniciar la sesión
        session_start();

        // Acceder al id del alumno almacenado en la variable de sesión
        $id_alumno = $_SESSION['id_alumno'];

        $alumnos = new Alumnos();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $aula = $_POST['aula'];
        $password = $_POST['password'];
        $ruta_foto = $_POST['ruta_foto'];

        // Convierte el array de valores del perfil de visualizacion en una cadena separada por comas
        $perfil_visualizacion = implode(', ', $_POST['perfil']);

        // Modificamos los datos en la base de datos
        $alumnos->modificarAlumno($nombre, $apellidos, $aula, $perfil_visualizacion, $password, $ruta_foto, $id_alumno);
    }
?>