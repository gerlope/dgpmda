<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesi&oacute;n</title>
		<script src="../javascript/funcionesBasicas.js"></script>
		<script src="../javascript/validarFormularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
	</head>
	<body>
		<header>
		</header>

		<main>
			<?php
				// Iniciar la sesión
				session_start();

				// Si no podemos acceder al indice del alumno correspondiente nos redirigmos al index
				if($_GET['indice'] == null){
					header('Location: ../index.php');
					exit;
				}

				// Acceder a los datos de los alumnos almacenados en la variable de sesión
				// Usamos $_GET porque en este caso el indice de los alumnos no compromete
				// al sistema ni a la seguridad y privacidad del mismo
				$alumno = unserialize($_SESSION['alumno'][$_GET['indice']]);

				$perfil_visualizacion = $alumno['perfil_visualizacion'];

				$_SESSION['id_alumno'] = $alumno['id'];
				$_SESSION['nombre_alumno'] = $alumno['nombre'];
				$_SESSION['apellidos_alumno'] = $alumno['apellidos'];
				$_SESSION['ruta_foto_alumno'] = $alumno['ruta_foto'];

				// Según el perfil preferente de visualización del alumno tendrá un inicio de sesión personalizado
				if(strpos($perfil_visualizacion, 'visual') || strpos($perfil_visualizacion, 'visual') === 0){
					header("Location: inicio_sesion_pictogramas.php");
				}else{
					header("Location: inicio_sesion_estandar.php");
				}
			?>
		</main>

		<footer>
		</footer>
	</body>
</html>