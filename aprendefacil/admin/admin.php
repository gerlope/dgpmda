<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de administrador</title>
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
					<img src='../imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
					<h2>$username</h2></a>
					<a href='../php/logout.php'>&#10149; Cerrar sesión</a></article>";
				}
				else{		// Si no hay ninguna sesión de administrador activa
					header("Location: ../index.php");
				}
			?>
		</header>

		<main>
        	<section>
				<h2>Alta de Profesores</h2>
				<p>Utiliza este botón para dar de alta profesores.</p>
				<a href="alta_profesores.php"><button>Dar de Alta Profesores</button></a>
			</section>

        	<section>
				<h2>Alta de Alumnos</h2>
				<p>Utiliza este botón para dar de alta alumnos.</p>
				<a href="alta_alumnos.php"><button>Dar de Alta Alumnos</button></a>
			</section>

			<section class="alumnos">
				<h2>Alumnos</h2>
				<?php
					require_once('../php/alumno.class.inc');

					$tmp = new Alumno();
					$alumnos = $tmp->obtenerAlumnos();
					$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumnos'] como una matriz vacía
					$i = 0;

					if($alumnos){
						foreach ($alumnos as $alumno) {
							$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];

							// Guardamos en una variable de sesion el alumno correspondiente
							$_SESSION['alumno'][$i] = serialize($alumno);
							
							// Creamos todos los articles de los alumnos
							echo "<article class='alumno'>
								<a href='../admin/modificacion_alumnos.php?indice=$i'>
									<img src='../imagenes/" . $alumno['ruta_foto'] . "' alt='Foto de perfil del alumno'>
									<h3>{$alumnosNombre[$i]}</h3>
								</a>
							</article>";

							$i++;
						}
					}	
					else{
						echo "<article class='alumno'><h2>No hay ning&uacute; alumno registrado</h2></article>";
					}
				?>
			</section>
		</main>

		<footer>
		</footer>
	</body>
</html>