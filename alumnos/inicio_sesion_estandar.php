<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
    </head>
    <body>
        <header>
            <div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador redirigimos a la página del administrador
					if (isset($_SESSION['admin'])) {
						header("Location: ../admin/admin_alumnos.php");
					}
					else if (isset($_SESSION['usuario'])) {		// Si hay una sesión activa de usuario redirigimos a la página de profesor
                        header("Location: ../profesor/profesor_alumnos.php");
					}
                    else if(isset($_SESSION['id_alumno'])){     // Si hay una sesión activa de alumno redirigimos mostramos su nombre y foto
                        // Acceder al nombre de alumno almacenado en la variable de sesión
						$nombre = $_SESSION['nombre_alumno'] . " " . $_SESSION['apellidos_alumno'];
						$ruta_foto = $_SESSION['ruta_foto_alumno'];

                        echo "<div id='perfil-login'>
                        <div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
                        <div><h2>$nombre</h2></div></div>
                        <div id='div-titulo'><h1 id='titulo'>Iniciar Sesi&oacute;n</h1>
                        <img src='../multimedia/imagenes/icono_login.png' width='60' height='60' alt='Icono inicio de sesion'></div>
                        <div></div><div></div><div></div>";

                        // Si hay una sesión ya activa de alumnos redirigimos al alumno a la página correspondiente
                        if(isset($_SESSION['perfil_visualizacion'])){
                            header("Location: ../alumnos/alumno.php");
                        }
                    }
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}
				?>
			</div>
        </header>

        <main>
            <a href="../index.php" class="boton-volver" aria-label="Volver al inicio" role="button">&#129152;</a>

            <div id="form-container">
                <article id="form-login">
                    <form onsubmit="return validarFormularioLoginAlumno(event, '-login')" action="../php/login_alumnos.php" method="POST" class="formulario">
                        <label for="password-login"><h2>Contrase&ntilde;a:</h2></label>
                        <input type="password" id="password-login" name="password-login" aria-label="Contraseña" aria-describedby="password-login-incorrecto" required>
                        <p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no es v&aacute;lida. Por favor, int&eacute;ntalo de nuevo.</p>
                        <br>
                        <input type="submit" class="submit" value="Confirmar">
                    </form>
                    <div id="-login-incorrecto" aria-live="assertive" role="status"></div>
                </article>
            </div>

            <script>
                // Función para enfocar automáticamente el campo de contraseña al cargar la página
                window.onload = function () {
                    document.getElementById("password-login").focus();
                };
            </script>

            <?php
                // Almacenamos la página del login del alumno
                $_SESSION['paginaLogin'] = $_SERVER['REQUEST_URI'];

                if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
                    // Cambiamos el div con el atributo aria-live="assertive" para indicar que los cambios en este elemento deben ser anunciados de inmediato por un lector de pantalla, en este caso un mensaje de error
                    echo "<script> document.getElementById('-login-incorrecto').textContent = 'La contraseña no es la correcta. Por favor, inténtalo de nuevo.';
                    document.getElementById('password-login').style.borderColor = 'rgba(255, 0, 0, 0.7)';</script>";

                    $_SESSION['formularioEnviado-login'] = false;
                }
            ?>
        </main>

        <footer>

        </footer>
    </body>
</html>