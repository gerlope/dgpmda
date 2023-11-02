<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('profesor.class.inc');

        $profesores = new Profesor();
        $location = $_POST['location-login'];
        $location2 = $_POST['location2-login'];
        $tipo = $_POST['tipo-login'];
        $usuario = $_POST['usuario'. $tipo];
        $password = $_POST['password'. $tipo];

        // Iniciar la sesión
        session_start();

        // Indicamos que el formulario ha sido enviado
        $_SESSION['formularioEnviado'. $tipo] = true;

        // Si el profesor existe con ese nombre de usuario y esa contraseña
        if($profesores->comprobarProfesor($usuario, $password)){
            // Obtenemos el usuario 
            $profesorActivo = $profesores->obtenerProfesor($usuario);

            // Y almacenamos los datos del usuario en variables de sesión
            $_SESSION['nombre'] = $profesorActivo['nombre'];
            $_SESSION['apellidos'] = $profesorActivo['apellidos'];
            $_SESSION['ruta_foto'] = $profesorActivo['ruta_foto'];
            $_SESSION['usuario'] = $profesorActivo['usuario'];
            $_SESSION['password'] = $profesorActivo['password'];

            // Comprueba si las credenciales son válidas para el administrador
            if ($profesores->esAdministrador($usuario) === true) {
                // Inicio de sesión exitoso, se crea una sesión para el administrador
                $_SESSION["admin"] = true;

                header("Location: ../admin/admin.php");
            }
            else{
                // Redirigimos al usuario a la página en la que se encuentre
                header('Location: '. $location);
            }
        }
        else{
            // Si al fallar el login queremos ir a otra página distinta que al hacerlo correctamente
            // Redirigimos al usuario a la página correspondiente
            header('Location: '. $location2);
        }
    }
?>