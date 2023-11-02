<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta de profesores</title>
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
        	<h1>Registro de Profesores</h1>
			<form onsubmit="return validarFormularioRegistroProfesor(event, '')" action="../php/registrar_profesor.php" method="POST" class="formulario">
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
					<label for="ruta_foto" class="titulo-campo">Fotograf&iacute;a personal:</label>
					<input type="file" id="ruta_foto" name="ruta_foto" required>
				</article>

				<article class="campo">
					<label for="usuario" class="titulo-campo">Nombre de usuario:</label>
					<input type="text" id="usuario" name="usuario" required>
					<p id="usuario-incorrecto" style="display:none;">El nombre de usuario debe tener entre 4 y 16 carcteres y contener &uacute;nicamente letras, n&uacute;meros, guiones y guiones bajos</p>
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

                <?php
					if (isset($_SESSION['usuarioRepetidoBD']) && $_SESSION['usuarioRepetidoBD'] == true) {
						echo "<p id='usuarioBD-incorrecto'>El usuario introducido ya existe. Por favor, ingrese un nombre de usuario diferente </p>";

						$_SESSION['usuarioRepetidoBD'] = false;
					}
				?>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>