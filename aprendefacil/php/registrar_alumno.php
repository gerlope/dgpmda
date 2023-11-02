<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumno.class.inc');

        $alumnos = new Alumno();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $password = $_POST['password'];
        $curso = $_POST['curso'];
        $perfil_visualizacion = $_POST['perfil_visualizacion'];
        $ruta_foto = $_POST['ruta_foto'];

        // Insertamos los datos en la base de datos
        $alumnos->insertarAlumno($nombre, $apellidos, $password, $curso, $perfil_visualizacion, $ruta_foto);
    }
?>