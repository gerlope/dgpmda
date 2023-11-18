<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesi&oacute;n</title>
		<script src="../javascript/funcionesBasicas.js"></script>
		<script src="../javascript/validarFormularios.js"></script>
	</head>
	<body>
		<header>
			<?php
				// Iniciar la sesión
				session_start();

				// Si no podemos acceder al indice del alumno correspondiente nos redirigmos al index
				if($_GET['indice'] == null){
					header('Location: ../index.php');
					exit;
				}

				$indice = $_GET['indice'];
			?>
		</header>

		<main>
		</main>

		<footer>
		</footer>
	</body>
</html>