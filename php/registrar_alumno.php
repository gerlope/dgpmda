<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.inc');

        $alumnos = new Alumnos();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $password = $_POST['password'];
        $aula = $_POST['aula'];
        $ruta_foto = $_POST['ruta_foto'];

        // Convierte el array de valores del perfil de visualizacion en una cadena separada por comas
        $perfil_visualizacion = implode(', ', $_POST['perfil']);

        // Insertamos los datos en la base de datos
        $alumnos->insertarAlumno($nombre, $apellidos, $password, $aula, $perfil_visualizacion, $ruta_foto);
    }
?>