<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de administrador</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/admin.css">
		<link rel="stylesheet" type="text/css" href="../css/multimedia.css">
	</head>
	<body>
		<header>
			<div>
			<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador redirigimos a la página del administrador que cuenta con más opciones
					if (isset($_SESSION['admin'])) {
						header("Location: ../admin/admin_tareas.php");
					}
					else if (isset($_SESSION['usuario'])) {		// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión

						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div><h2>$username</h2></div>
							</a>
						</div>";
					}
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}

					$seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';
				?>
				<div id="div-titulo"><h1 id='titulo'>Gesti&oacute;n de Multimedia</h1>
				<img src='../multimedia/imagenes/icono_profesor.png' width='60' height='60' alt='Icono profesor'></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<div class="div-principal">
				<section class="opciones-admin">
					<a href="profesor_tareas.php"><button><h3>Tareas</h3></button></a>

					<a href="profesor_alumnos.php"><button><h3>Alumnos</h3></button></a>

					<a href="profesor_multimedia.php"><button><h3>Multimedia</h3></button></a>
				</section>

				<?php
				function obtenerExtensionesPermitidas($seccion)
				{
					switch ($seccion) {
						case 'imagenes':
							return array('jpg', 'jpeg', 'png', 'gif');
						case 'videos':
							return array('mp4', 'webm', 'ogg');
						case 'audios':
							return array('mp3', 'wav', 'ogg');
						case 'documentos':
							return array('pdf', 'doc', 'docx', 'xls', 'xlsx');
						default:
							return array();
					}
				}

				function mostrarArchivo($seccion, $carpeta, $archivo)
				{
					$ruta_archivo = $carpeta . '/' . $archivo;

					switch ($seccion) {
						case 'imagenes':
							echo '<img src="' . $ruta_archivo . '" alt="' . $archivo . '" title="' . $archivo . '">';
							break;
						case 'videos':
							echo '<video controls>';
							echo '<source src="' . $ruta_archivo . '" type="video/mp4">';
							echo 'Tu navegador no soporta el tag de video.';
							echo '</video>';
							break;
						case 'audios':
							echo '<audio controls>';
							echo '<source src="' . $ruta_archivo . '" type="audio/mp3">';
							echo 'Tu navegador no soporta el tag de audio.';
							echo '</audio>';
							break;
						case 'documentos':
							echo '<a href="' . $ruta_archivo . '" target="_blank">' . $archivo . '</a><br><br>';
							break;
					}
				}

				function verificarMasElementos($seccion, $base_path, $itemsPerPage, $currentPage) {
					$carpeta = $base_path . '/' . $seccion;
				
					if (is_dir($carpeta)) {
						$archivos = scandir($carpeta);
						$extensiones_permitidas = obtenerExtensionesPermitidas($seccion);
				
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
				?>

				<div id="media-container-profesor">
					<div id="botones-multimedia">
						<form method="get">
							<button type="submit" onclick="mostrarSeccion('imagenes')" name="section" value="imagenes"><h3>Im&aacute;genes</h3></button>
							<button type="submit" onclick="mostrarSeccion('videos')" name="section" value="videos"><h3>V&iacute;deos</h3></button>
							<button type="submit" onclick="mostrarSeccion('audios')" name="section" value="audios"><h3>Audios</h3></button>
							<button type="submit" onclick="mostrarSeccion('documentos')" name="section" value="documentos"><h3>Documentos</h3></button>
						</form>
					</div>
					
					<?php
					$base_path = '../multimedia/'; 										// Ruta archivos multimedia
					$secciones = array('imagenes', 'videos', 'audios', 'documentos');
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$itemsPerPage = 3; 													// Número de elementos por página

					foreach ($secciones as $seccion) {
						$carpeta = $base_path . '/' . $seccion;

						// Verifica que la carpeta exista
						if (is_dir($carpeta)) {
							echo '<div class="media-section" id="' . $seccion . '">';

							// Obtén la lista de archivos en la carpeta
							$archivos = scandir($carpeta);
							$extensiones_permitidas = obtenerExtensionesPermitidas($seccion);

							$archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
								$extension = pathinfo($archivo, PATHINFO_EXTENSION);
								return in_array(strtolower($extension), $extensiones_permitidas);
							});

							// Muestra los archivos de la página actual
							$start = ($page - 1) * $itemsPerPage;
							$end = $start + $itemsPerPage - 1;

							$count = 0;

							foreach ($archivos_filtrados as $archivo) {
								if ($count >= $start && $count <= $end) {
									mostrarArchivo($seccion, $carpeta, $archivo);
								}
								$count++;
							}

							echo '</div>';
						}
					}
					?>

					<div class="pagination">
					<?php
						$prevPage = ($page > 1) ? $page - 1 : 1;
						$nextPage = $page + 1;
						$seccion = $seccion_actual;

						echo "<form method='get'>";
						
						// Verifica si hay más elementos en la sección actual para avanzar a la siguiente página
						$hasMoreItems = verificarMasElementos($seccion, $base_path, $itemsPerPage, $page);
						
						if ($page != 1) {
							echo "<button type='submit' name='page' value='$prevPage'><<</button>";
						} else {
							echo "<div></div>";
						}

						echo "<span>Page $page</span>";

						// Solo muestra el botón para avanzar a la siguiente página si hay más elementos
						if ($hasMoreItems) {
							echo "<button type='submit' name='page' value='$nextPage'>>></button>";
						} else {
							echo "<div></div>";
						}

						echo "</form>";
					?>
					</div>
				</div>

				<script>
					// Función para mostrar la sección correspondiente y guardar la selección en una cookie
					function mostrarSeccion(seccion) {
						var secciones = document.querySelectorAll('.media-section');
						secciones.forEach(function (element) {
							element.style.display = 'none';
						});

						document.getElementById(seccion).style.display = 'block';

						// Guarda la selección en una cookie
						document.cookie = "seccionSeleccionada=" + seccion;
					}

					// Función para obtener el valor de una cookie por su nombre
					function obtenerCookie(nombre) {
						var nombreEQ = nombre + "=";
						var cookies = document.cookie.split(';');
						for (var i = 0; i < cookies.length; i++) {
							var cookie = cookies[i];
							while (cookie.charAt(0) == ' ') {
								cookie = cookie.substring(1, cookie.length);
							}
							if (cookie.indexOf(nombreEQ) == 0) {
								return cookie.substring(nombreEQ.length, cookie.length);
							}
						}
						return null;
					}

					// Al cargar la página, verifica si hay una selección guardada y la muestra
					window.onload = function () {
						var seccionGuardada = obtenerCookie("seccionSeleccionada");
						if (seccionGuardada) {
							mostrarSeccion(seccionGuardada);
						}
					};
				</script>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>