<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta de alumnos</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
	</head>
	<body>
		<header>
			<div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['admin'])) {

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
					else{		// Si no hay ninguna sesión de administrador activa
						header("Location: ../index.php");
					}
				?>
				<div><h1 id='titulo'>Alta Alumnos</h1></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesion</h3></button></a>
			</div>
		</header>

		<main>
			<form onsubmit="return validarFormularioRegistroAlumno(event, '')" action="../php/registrar_alumno.php" method="POST" class="formulario">
				<article class="campo">
					<label for="nombre" class="titulo-campo">Nombre:</label>
					<input type="text" id="nombre" name="nombre" required>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo">Apellidos:</label>
					<input type="text" id="apellidos" name="apellidos" required>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>

				<article class="campo">
					<label for="aula" class="titulo-campo">Aula:</label>
					<input type="text" id="aula" name="aula" required>
					<p id="aula-incorrecto" style="display:none;">El aula debe contener &uacute;nicamente caracteres alfan&uacute;mericos</p>
				</article>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo">Fotograf&iacute;a personal:</label>
					<input type="file" id="ruta_foto" name="ruta_foto" accept="image/*" required>
				</article>

				<article class="campo">
					<fieldset id="fieldset-perfil_visualizacion" name="fieldset-perfil_visualizacion">
						<legend class="titulo-campo">Perfil preferente de visualizaci&oacute;n:</legend>

						<label>
						<input type="checkbox" name="perfil[]" value="audio">Audio</label>

						<label>
						<input type="checkbox" name="perfil[]" value="visual">V&iacute;deos y fotos</label>

						<label>
						<input type="checkbox" name="perfil[]" value="texto">Texto</label>
					</fieldset>
					<p id="fieldset-perfil_visualizacion-incorrecto" style="display:none;">Se debe seleccionar al menos una opci&oacute;n de visualizaci&oacute;n</p>
				</article>
      
				<article class="campo">
					<label for="password" class="titulo-campo">Contrase&ntilde;a:</label>
					<input type="password" id="password" name="password" required>
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article>
				
				<article class="campo">
					<label for="password-confirm" class="titulo-campo">Confirmar Contrase&ntilde;a:</label>
					<input type="password" id="password-confirm" name="password-confirm" required>
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article>
				
				<article class="enviar">
					<input type="submit" value="Registrarse">
				</article>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>