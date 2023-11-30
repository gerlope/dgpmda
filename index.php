<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="javascript/funciones_basicas.js"></script>
		<script src="javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>

	<body>
		<header>
			<div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['usuario'])) {
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						// Si la sesión activa es la de el administrador añadimos una linea para ir al panel de administrador
						if(isset($_SESSION['admin'])){
							echo "<div id='perfil-login'>
							<a href='profesores/modificacion_profesores.php'>
							<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='titulo'>Inicio</h1></div>
							<a href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
						else{
							echo "<div id='perfil-login'>
							<a href='profesores/modificacion_profesores.php'>
							<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='titulo'>Inicio</h1></div>
							<a href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
					}
					else if(isset($_SESSION['perfil_visualizacion'])){
						// Acceder al nombre de alumno almacenado en la variable de sesión
						$username = $_SESSION['nombre'] . " " . $_SESSION['apellidos'];
						$ruta_foto = $_SESSION['ruta_foto'];

						echo "<div id='perfil-login'>
						<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></div>
						<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='titulo'>Inicio</h1></div>
						<a href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
					}
					else{
						echo "<div id='perfil-login'></div>
							<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='titulo'>Inicio</h1></div>
							<a href='profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>";
					}
				?>
			</div>
		</header>

		<main>
			<h2>Selecciona tu nombre y foto</h2>
			<section class="alumnos">
				<div class='botones-pantalla'><button class='boton-pantalla' id='prevAlumnos' aria-label="Ir a alumnos anteriores" style='display: none;'>&#129152;</button></div>

				<?php
					require_once('php/alumnos.class.inc');

					$tmp = new Alumnos();
					$alumnos = $tmp->obtenerAlumnos();
					$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumno'] como una matriz vacía
					$i = 0;

					if($alumnos){
						foreach ($alumnos as $alumno) {
							$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];

							// Guardamos en una variable de sesion el alumno correspondiente
							$_SESSION['alumno'][$i] = serialize($alumno);
							
							// Creamos todos los articles de los alumnos
							echo "<a href='alumnos/acceso_alumnos.php?indice=$i'>
								<article class='alumno'>
									<img src='multimedia/imagenes/" . $alumno['ruta_foto'] . "' width='70' height='70' alt='Foto de perfil del alumno' >
									<h3>{$alumnosNombre[$i]}</h3>
								</article></a>";

							$i++;
						}
					}	
					else{
						echo "<article class='alumno'><h2>No hay ning&uacute;n alumno registrado</h2></article>";
					}

					echo "<div class='botones-pantalla'><button class='boton-pantalla' id='posAlumnos' aria-label='Mostrar más alumnos'>&#129154;</button></div>";
				?>
			</section>

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var alumnosContainer = document.querySelector(".alumnos");
					var alumnos = document.querySelectorAll(".alumno");
					var posButton = document.getElementById("posAlumnos");
					var prevButton = document.getElementById("prevAlumnos");

					// Establece el número máximo de alumnos por pantalla
					var alumnosPorPantalla = 10;

					// Inicializa el estado de la pantalla
					var pantallaActual = 0;
					actualizarPantalla();

					// Escucha el evento del botón para avanzar de pantalla
					posButton.addEventListener("click", function () {
						pantallaActual++;
						actualizarPantalla();
					});

					// Escucha el evento del botón para retroceder de pantalla
					prevButton.addEventListener("click", function () {
						pantallaActual--;
						actualizarPantalla();
					});

					function actualizarPantalla() {
						var startIndex = pantallaActual * alumnosPorPantalla;
						var endIndex = startIndex + alumnosPorPantalla;

						// Muestra u oculta los alumnos según la pantalla actual
						alumnos.forEach(function (alumno, index) {
							alumno.parentNode.style.display = index >= startIndex && index < endIndex ? "block" : "none";
						});

						// Muestra u oculta los botones dependiendo de si hay más pantallas
						posButton.style.display = endIndex < alumnos.length ? "block" : "none";
						prevButton.style.display = pantallaActual > 0 ? "block" : "none";
					}
				});
			</script>
		</main>

		<footer>

    	</footer>
	</body>
</html>