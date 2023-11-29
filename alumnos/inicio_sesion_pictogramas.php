<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="stylesheet" type="text/css" href="../css/acceso.css">
		<link rel="stylesheet" type="text/css" href="../css/multimedia.css">
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

            <section class="pictogramas">
				<?php
					$directorio = "../multimedia/pictogramas_password";
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$itemsPerPage = 10; 					            // Número de elementos por página

					function addPicto($archivo) {
						
					}
					
					function verificarMasElementos($directorio, $currentPage, $itemsPerPage) {
					
						if (is_dir($directorio)) {
							$archivos = scandir($directorio);
							$extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
					
							$archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
								$extension = pathinfo($archivo, PATHINFO_EXTENSION);
								return in_array(strtolower($extension), $extensiones_permitidas);
							});
					
							// Calcula la cantidad total de elementos y verifica si hay más allá de la página actual
							$totalItems = count($archivos_filtrados);
							$startIndex = ($currentPage - 1) * $itemsPerPage;
							$endIndex = $startIndex + $itemsPerPage;
	
							return $endIndex < $totalItems;
						}
					
						return false;
					}                    

                    // Verifica que la carpeta exista
                    if (is_dir($directorio)) {
                        // Obtén la lista de archivos en la carpeta
						$archivos = scandir($directorio);
                        $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

                        $archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
                            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                            return in_array(strtolower($extension), $extensiones_permitidas);
                        });

                        // Muestra los archivos de la página actual
                        $start = ($page - 1) * $itemsPerPage;
                        $end = $start + $itemsPerPage - 1;

                        $count = 0;

                        foreach ($archivos_filtrados as $archivo) {
							$archivostr = '"'.$archivo.'"';
							if ($count >= $start && $count <= $end) {
                                echo "<button class='pictograma' name='pictograma' onClick='addPicto(\"$archivo\")' value='" . $archivo . "'><img src='" . $directorio . "/" . $archivo . "' alt='" . $archivo . "' title='" . $archivo . "'></button>";
                            }
                            $count++;
                        }
                    }
                ?>
			</section>

            <div class="pagination">
					<?php
						$directorio = "../multimedia/pictogramas_password";
						$itemsPerPage = 10;
						$prevPage = ($page > 1) ? $page - 1 : 1;
						$nextPage = $page + 1;
						echo "<form method='get'>";
						
						// Verifica si hay más elementos en la sección actual para avanzar a la siguiente página
						$hasMoreItems = verificarMasElementos($directorio, $page, $itemsPerPage);
						
						if ($page != 1) {
							echo "<button class='boton-pantalla' type='submit' name='page' value='$prevPage'><<</button>";
						} else {
							echo "<div></div>";
						}

						// Solo muestra el botón para avanzar a la siguiente página si hay más elementos
						if ($hasMoreItems) {
							echo "<button class='boton-pantalla' type='submit' name='page' value='$nextPage'>>></button>";
						} else {
							echo "<div></div>";
						}

						echo "</form>";
					?>
            </div>

			<div class="pictogramas-seleccionados">
				<div><button class='boton-pantalla' onClick='clearPictos()' name='borrar' value='borrar'>Borrar</button></div>
						<div class="pictograma"><img id="picto1" src=""></div>
						<div class="pictograma"><img id="picto2" src=""></div>
						<div class="pictograma"><img id="picto3" src=""></div>
				
					<script>
						let selected = [];
						var d=new Date();
						d.setTime(d.getTime()+(60*1000));
						var expires = "; expires="+d.toGMTString();

						function addPicto(archivo) {
							if(typeof selected[0] == 'undefined') {
								selected[0] = archivo;
								document.getElementById("picto1").src="../multimedia/pictogramas_password/" + archivo;
								document.getElementById("picto1d").value = archivo;
								document.getElementById("picto1").style.visibility = "visible";
								document.cookie = "picto1=" + archivo + expires;
							} else if(typeof selected[1] == 'undefined') {
								selected[1] = archivo;
								document.getElementById("picto2").src="../multimedia/pictogramas_password/" + archivo;
								document.getElementById("picto2d").value = archivo;
								document.getElementById("picto2").style.visibility = "visible";
								document.cookie = "picto2=" + archivo + expires;
							} else if(typeof selected[2] == 'undefined') {
								selected[2] = archivo;
								document.getElementById("picto3").src="../multimedia/pictogramas_password/" + archivo;
								document.getElementById("picto3d").value = archivo;
								document.getElementById("picto3").style.visibility = "visible";
								document.cookie = "picto3=" + archivo + expires;
							}
						}

						function clearPictos() {
							selected = [];
							document.getElementById("picto1").src="";
							document.getElementById("picto2").src="";
							document.getElementById("picto3").src="";
							document.getElementById("picto1").style.visibility = "hidden";
							document.getElementById("picto2").style.visibility = "hidden";
							document.getElementById("picto3").style.visibility = "hidden";
							clearCookies();
						}

						function clearCookies() {
							document.cookie = "picto1=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
							document.cookie = "picto2=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
							document.cookie = "picto3=" + "; expires=Thu, 01 Jan 1970 00:00:00 UTC"
						}

						// Función para obtener el valor de una cookie por su nombre
						function obtenerCookie(picto1,picto2,picto3) {
							var picto1EQ = picto1 + "=";
							var picto2EQ = picto2 + "=";
							var picto3EQ = picto3 + "=";
							var pictos = [];

							var cookies = document.cookie.split(';');
							for (var i = 0; i < cookies.length; i++) {
								var cookie = cookies[i];
								while (cookie.charAt(0) == ' ') {
									cookie = cookie.substring(1, cookie.length);
								}
								if (cookie.indexOf(picto1EQ) == 0) {
									pictos[0] = cookie.substring(picto1EQ.length, cookie.length);
								}else if (cookie.indexOf(picto2EQ) == 0) {
									pictos[1] = cookie.substring(picto2EQ.length, cookie.length);
								}else if (cookie.indexOf(picto3EQ) == 0) {
									pictos[2] = cookie.substring(picto3EQ.length, cookie.length);
								}
							}
							
							return pictos;
						}	

						// Al cargar la página, verifica si hay una selección guardada y la muestra
						window.onload = function () {
							var pictos = obtenerCookie("picto1","picto2","picto3");
							if (pictos[0]) {
								addPicto(pictos[0]);
							} 
							if (pictos[1]) {
								addPicto(pictos[1]);
							}
							if (pictos[2]) {
								addPicto(pictos[2]);
							}
						};
						</script>

				<form action="../php/login_alumnos.php" method="POST">
                        <p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no es v&aacute;lida. Por favor, int&eacute;ntalo de nuevo.</p>
						<input class="hidden" type="text" id="picto1d" name="picto1d">
						<input class="hidden" type="text" id="picto2d" name="picto2d">
						<input class="hidden" type="text" id="picto3d" name="picto3d">
                        <input class="boton-pantalla" onClick="clearCookies()" type="submit" name = "confirmar" value="Confirmar">
				</form>

			</div>
			<div id="-login-incorrecto" aria-live="assertive" role="status"></div>	

			<?php
                // Almacenamos la página del login del alumno
                $_SESSION['paginaLogin'] = $_SERVER['REQUEST_URI'];

                if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
                    // Cambiamos el div con el atributo aria-live="assertive" para indicar que los cambios en este elemento deben ser anunciados de inmediato por un lector de pantalla, en este caso un mensaje de error
                    echo "<script>document.getElementById('-login-incorrecto').textContent = 'La contraseña no es la correcta. Por favor, inténtalo de nuevo.';</script>";

                    $_SESSION['formularioEnviado-login'] = false;
                }
            ?>
        </main>

        <footer>

        </footer>
    </body>
</html>