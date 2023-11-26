<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.inc');

        // Iniciar la sesión
        session_start();

        $alumnos = new Alumnos();
        $id = $_SESSION['id_alumno'];
        $password = $_POST['password-login'];

        // Hallamos la pagina correspondiente del login del alumno
        // por si falla dirigirlo a la misma en la que se encontraba
        $paginaLogin = $_SESSION['paginaLogin'];

        // Indicamos que el formulario ha sido enviado
        $_SESSION['formularioEnviado-login'] = true;

        // Si el alumno existe con ese id y esa contraseña
        if($alumnos->comprobarAlumno($id, $password)){
            // Obtenemos el alumno 
            $alumnoActivo = $alumnos->obtenerAlumno($id);

            // Y almacenamos los datos del alumno en variables de sesión
            $_SESSION['nombre'] = $alumnoActivo['nombre'];
            $_SESSION['apellidos'] = $alumnoActivo['apellidos'];
            $_SESSION['aula'] = $alumnoActivo['aula'];
            $_SESSION['ruta_foto'] = $alumnoActivo['ruta_foto'];
            $_SESSION['perfil_visualizacion'] = $alumnoActivo['perfil_visualizacion'];
            $_SESSION['password'] = $alumnoActivo['password'];
            
            // Redirigimos al alumno a la página correspondiente
            header("Location: ../alumnos/alumno.php");
            
        }
        else{
            // Si falla redirigimos al alumno al inicio de sesión correspondiente
            header("Location: ../../.." . $paginaLogin);
        }
    }
?>