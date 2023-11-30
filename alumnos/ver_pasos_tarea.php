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
		<link rel="stylesheet" type="text/css" href="../css/tarea.css">
	</head>

	<body class="pagina-tareas">
		<header>
			<div>
				<?php
				// Iniciar la sesión
				session_start();

				if (isset($_SESSION['alumno'])) { // Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión

					// Acceder al nombre de usuario almacenado en la variable de sesión
					$username = $_SESSION['nombre'];
					$ruta_foto = $_SESSION['ruta_foto'];

					// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
					echo "<div id='perfil-login'>
						<a href='../alumnos/alumno.php'>
							<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
							<div><h2>$username</h2></div>
						</a>
					</div>";
				} else { // Si no hay ninguna sesión de usuario activa
					header("Location: ../index.php");
				}

				$seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';

				require_once('../php/tareas.class.inc');
				// Obtener el tarea_id de la URL
				$tarea_id = isset($_GET['tarea_id']) ? $_GET['tarea_id'] : null;

				// Validar si el tarea_id está presente
				if (!$tarea_id) {
					echo "Error: Tarea no especificada.";
					exit;
				}

				// Obtener información detallada de la tarea
				$tarea_info = Tareas::obtenerTarea($tarea_id);

				// Verificar si se encontró información de la tarea
				if ($tarea_info) {
					// Acceder a la información de la tarea
					$titulo_tarea = $tarea_info['titulo'];
					$total_pasos = $tarea_info['numero_pasos'];
                    $ruta_foto_tarea = $tarea_info['ruta_icono'];
				}

				// Obtener el paso actual
				$paso_actual = isset($_GET['paso']) ? $_GET['paso'] : 1;

				// Obtener información detallada del paso actual
				$pasosTarea = Tareas::obtenerPasosDeTarea($titulo_tarea, $total_pasos);

				// Inicializar variables para el paso actual
				$paso_descripcion = "";
				$paso_video = "";
				$paso_foto = "";
				$paso_audio = "";

				// Acceder a los datos del paso actual
				foreach ($pasosTarea as $paso) {
					if ($paso['orden'] == $paso_actual) {
						$paso_descripcion = $paso["descripcion"];
						$paso_video = $paso["video"];
						$paso_foto = $paso["foto"];
						$paso_audio = $paso["audio"];
						break; // Salir del bucle una vez que se encuentra el paso actual
					}
				}
				?>

				<div id='div-titulo'>
					<img src='../multimedia/imagenes/<?php echo $ruta_foto_tarea; ?>' width='60' height='60' alt='Icono página inicial'>
					<h1 id='titulo'><?= $titulo_tarea; ?></h1>
					<h1 id='paso-actual'>- Paso <?= $paso_actual; ?></h2>
				</div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<div class="botones">
                <button class="boton-pantalla"><h3>IMAGEN</h3></button>
                <button class="boton-pantalla"><h3>VIDEO</h3></button>
                <button class="boton-pantalla"><h3>AUDIO</h3></button>
            </div>

			</div>

			<div class="imagen-tarea">

				<!-- Flechas para navegar entre pasos -->
                <?php if ($paso_actual > 1) : ?>
                <button class = "boton-paso"  id='prevTareas' aria-label="Ir a paso anterior" onclick="window.location.href='ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=<?php echo $paso_actual - 1; ?>'">&#129152;</button>
                <?php endif; ?>


                <?php
				// Mostrar la foto del paso actual
				echo "<img src='../multimedia/imagenes/$paso_foto' width='500' height='400' alt='Foto del paso actual'>";
				?>

				<?php if ($paso_actual < $total_pasos) : ?>
                    <button class = "boton-paso"  id='posTareas' aria-label="Ir a paso siguiente" onclick="window.location.href='ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>&paso=<?php echo $paso_actual + 1; ?>'">&#129154;</button>
				<?php endif; ?>
			</div>
		</main>

        <footer>
				<!-- Mostrar el texto referente a ese paso -->
				<?php
				echo "<p>$paso_descripcion</p>";
				?>
        </footer>
	</body>
</html>
