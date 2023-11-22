<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
    </head>
    <body>
        <header>
            <div>
                <div></div>
                <div><h1 id="titulo">Iniciar Sesi&oacute;n</h1></div>
                <div></div>
            </div>
        </header>

        <main>
            <a href="../index.php" class="boton-volver">&#129152;</a>

            <div id="form-container">
                <article id="form-login">
                    <form onsubmit="return validarFormularioLoginAlumno(event, '-login')" action="../php/login_alumnos.php" method="POST" class="formulario">
                        <label for="password-login"><h2>Contrase&ntilde;a:</h2></label>
                        <input type="password" id="password-login" name="password-login" aria-label="Contraseña" required>
                        <p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no tiene un formato v&aacute;lido</p>
                        <br>
                        <input type="submit" class="submit" value="Iniciar sesi&oacute;n" role="button">
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
                // Iniciar la sesión
                session_start();

                if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
                    // Cambiamos el div con el atributo aria-live="assertive" para indicar que los cambios en este elemento deben ser anunciados de inmediato por un lector de pantalla, en este caso un mensaje de error
                    echo "<script> document.getElementById('-login-incorrecto').textContent = 'La contrase&ntilde;a no es la correcta. Por favor, int&eacute;ntalo de nuevo.';</script>";

                    $_SESSION['formularioEnviado-login'] = false;
                }
            ?>
        </main>

        <footer>

        </footer>
    </body>
</html>