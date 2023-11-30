<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="javascript/funciones_basicas.js"></script>
		<script src="javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/alumno.css">
	</head>

	<body>
		<header>
			<div>
			<?php
					// Iniciar la sesión
					session_start();

					if (isset($_SESSION['alumno'])) {		// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión

						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['nombre'];
						$ruta_foto = $_SESSION['ruta_foto'];
						$idAlumno = $_SESSION['id_alumno'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../alumnos/alumno.php'>
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
				<div id='div-titulo'><img src='../multimedia/imagenes/icono_alumno.png' width='60' height='60' alt='Icono página inicial'>
				<h1 id='titulo'>Tareas</h1></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<h2>Tareas por hacer</h2>
			<section class="tareas">
				<div class='botones-pantalla'><button class='boton-pantalla' id='prevTareas' aria-label="Ir a tareas anteriores" style='display: none;'>&#129152;</button></div>

				<?php
					require_once('../php/tareas.class.inc');

					

					$tmp = new Tareas();
					$tareas = $tmp->obtenerTareasAsignadas($idAlumno);

					if($tareas){
						foreach ($tareas as $tarea) {
							// Obtener información detallada de la tarea
							$tarea_id = $tarea['tarea_id'];
							$tarea_info = Tareas::obtenerTarea($tarea_id);
					
							// Verificar si se encontró información de la tarea
							if ($tarea_info) {
								// Acceder a la información de la tarea
								$titulo = $tarea_info['titulo'];
								$ruta_foto = $tarea_info['ruta_icono'];
					
								// Mostrar la información de la tarea
								echo "<a href='ver_tarea.php?tarea_id=$tarea_id' class='tarea'>";
								echo "<p>$titulo</p>";
								echo "<img src='../multimedia/imagenes/$ruta_foto' alt='Foto de la tarea'>";
								echo "</a>";
								
							} else {
								echo "<article class='alumno'><h2>No hay ning&uacute;n alumno registrado</h2></article>";
							}
						}
					}

					echo "<div class='botones-pantalla'><button class='boton-pantalla' id='posTareas' aria-label='Mostrar más tareas'>&#129154;</button></div>";
				?>
			</section>

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var tareasContainer = document.querySelector(".tareas");
					var tareas = document.querySelectorAll(".tarea");
					var posButton = document.getElementById("posTareas");
					var prevButton = document.getElementById("prevTareas");

					// Establece el número máximo de tareas por pantalla
					var tareasPorPantalla = 2;

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
						var startIndex = pantallaActual * tareasPorPantalla;
						var endIndex = startIndex + tareasPorPantalla;

						// Muestra u oculta los alumnos según la pantalla actual
						tareas.forEach(function (tarea, index) {
							tarea.style.display = index >= startIndex && index < endIndex ? "block" : "none";
						});

						// Muestra u oculta los botones dependiendo de si hay más pantallas
						posButton.style.display = endIndex < tareas.length ? "block" : "none";
						prevButton.style.display = pantallaActual > 0 ? "block" : "none";
					}
				});
			</script>
		</main>

		<footer>
			<a href='../php/historial.php' class='boton-con-imagen'>
				<button>
					<h3>Historial</h3>
					<img src='../multimedia/imagenes/historial.png' alt='Historial'>
				</button>
			</a>
        	
			<a href='../php/logout.php' class='boton-con-imagen'>
				<button>
					<h3>Cerrar Sesión</h3>
					<img src='../multimedia/imagenes/icono_logout.png' alt='Historial'>
				</button>
			</a>

    	</footer>
	</body>
</html>