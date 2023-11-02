<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumno.class.inc');

        // Iniciar la sesión
        session_start();

        // Acceder al id del alumno almacenado en la variable de sesión
        $id_alumno = $_SESSION['id_alumno'];

        $alumnos = new Alumno();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $curso = $_POST['curso'];
        $perfil_visualizacion = $_POST['perfil_visualizacion'];
        $password = $_POST['password'];
        $ruta_foto = $_POST['ruta_foto'];

        // Modificamos los datos en la base de datos
        $alumnos->modificarAlumno($nombre, $apellidos, $curso, $perfil_visualizacion, $password, $ruta_foto, $id_alumno);
    }
?>