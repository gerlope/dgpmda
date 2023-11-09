<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Asignar tarea</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
	</head>
	<body>
	    <header>
		<?php
				// Iniciar la sesión
				session_start();

				// Si hay una sesión activa de administrador, mostrar el nombre de usuario y la posibilidad de cerrar sesión
				if (isset($_SESSION['admin'])) {

					// Acceder al nombre de usuario almacenado en la variable de sesión
					$username = $_SESSION['usuario'];
					$ruta_foto = $_SESSION['ruta_foto'];

					// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
					echo "<article id='perfil-login'>
					<a href='../profesores/modificacion_profesores.php'>
					<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
					<h2>$username</h2></a>
					<a href='../php/logout.php'>&#10149; Cerrar sesión</a></article>";
				}
				else{		// Si no hay ninguna sesión de administrador activa
					header("Location: ../index.php");
				}
			?>
		</header>

		<main>
			<?php 	
				require_once('../php/tareas.class.inc');

				// Acceder a los datos de las tareas almacenadas en la variable de sesión
				// Usamos $_GET porque en este caso el indice de las tareas no compromete
				// al sistema ni a la seguridad y privacidad del mismo
				$tarea = unserialize($_SESSION['tarea'][$_GET['indice']]);

				$titulo = $tarea['titulo'];
				$tareaId = $tarea['id'];
				$indice = $_GET['indice'];

				// Creamos una instancia de tareas para el código javascript
				$tareas = new Tareas();
			?>

			<h1 id='tituloPrincipal'><?php echo $titulo;?></h1>
			<article>
				<a href='../admin/modificacion_tareas.php?indice=<?php echo $indice;?>'>
					<h3>Modificar tarea</h3>
				</a>
			</article>
			
			<form action="../php/asignar_tarea.php" method="POST" class="formulario">
				<article class="campo">
						<fieldset id="fieldset-alumnos" name="fieldset-alumnos">
							<?php
								require_once('../php/alumnos.class.inc');

								$tmp = new Alumnos();
								$alumnos = $tmp->obtenerAlumnos();
								$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumno'] como una matriz vacía
								$i = 0;

								if($alumnos){
									foreach ($alumnos as $alumno) {
										$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];
										$alumnosId[$i] = $alumno['id'];

										// Guardamos en una variable de sesion el alumno correspondiente
										$_SESSION['alumno'][$i] = serialize($alumno);
										
										// Creamos todos los input de los alumnos
										echo "<label>
										<input type='checkbox' name='alumnos_id[]' value='{$alumnosId[$i]}'>{$alumnosNombre[$i]}</label>";

										$i++;
									}
								}	
								else{
									echo "<article class='alumno'><h2>No hay ning&uacute; alumno registrado</h2></article>";
								}
							?>

							<input type="number" id="tarea_id" name="tarea_id" value=<?php echo $tareaId;?> style="display:none;">
						</fieldset>
					</article>

				<article class="enviar">
					<input type="submit" value="Confirmar">
				</article>
			</form>

			<script>
				document.addEventListener("DOMContentLoaded", function() {
					// Obtenemos el id de la tarea
					var tarea_id = <?php echo json_encode($tareaId); ?>;
					
					// Obtenemos los alumnos que ya tienen asignada la tarea
					var alumnosAsignados = <?php echo json_encode($tareas->obtenerAlumnosAsignados($tareaId)); ?>;
					
					// Iterar sobre los checkboxes y marcarlos si están asignados
					var checkboxes = document.querySelectorAll('input[name="alumnos_id[]"]');
					checkboxes.forEach(function(checkbox) {
						var alumno_id = checkbox.value;
						if (alumnosAsignados.some(function(alumno) { return alumno.alumno_id == alumno_id; })) {
							checkbox.checked = true;
						}
					});
				});
			</script>
		</main>

		<footer>
		</footer>
	</body>
</html>