<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
    </head>
    <body>
        <header>
            <div id="div-header">
				<div id="barra-lateral" class="barra-lateral">
					<a href="#" class="boton-cerrar" onclick="ocultar()"><button><h3>&#10008;</h3></button></a>
					<div id="contenido">
						<div id='perfil-login-reducido'></div>
						<a id='enlace-header-reducido' href='profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>
					</div>
				</div>
					
				<div id="boton-barra-lateral">
					<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><button><h3>&#9776;</h3></button></a>
					<a id="cerrar" class="abrir-cerrar" href="javascript:void(0)" onclick="ocultar()" style='display: none;'></button><h3>&#9776;</h3></button></a>
				</div>
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
                    else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){		// Si hay una sesión ya activa de alumnos redirigimos al alumno a la página correspondiente
                        header('Location: ../alumnos/alumno.php');
                    }
                    else if(isset($_SESSION['id_alumno'])){     // Si hay una sesión de inicio de sesión iniciada de alumno mostramos su nombre y foto
                        // Acceder al nombre de alumno almacenado en la variable de sesión
						$nombre = $_SESSION['nombre_alumno'] . " " . $_SESSION['apellidos_alumno'];
						$ruta_foto = $_SESSION['ruta_foto_alumno'];

                        echo "<div id='perfil-login'>
                        <div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
                        <div><h2>$nombre</h2></div><a id='enlace-header'></a></div>
                        <div id='div-titulo'><h1 id='tituloPrincipal'>Iniciar Sesi&oacute;n</h1>
                        <img src='../multimedia/imagenes/icono_login.png' width='60' height='60' alt='Icono inicio de sesion'></div>
                        <div></div><div></div><div></div>";
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
                        <label for="password-login"><h2>Escribe tu contrase&ntilde;a:</h2></label>
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