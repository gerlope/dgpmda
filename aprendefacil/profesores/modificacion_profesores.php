<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Perfil de usuario</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
	</head>
	<body>
	    <header>
			<?php
				// Iniciar la sesión
				session_start();

				// Si hay una sesión activa, mostrar el nombre de usuario y la posibilidad de cerrar sesión
				if (isset($_SESSION['usuario'])) {
					echo "<script>eliminarElemento('form-login');</script>";

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
				else if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
					// Mostramos un mensaje de error
					echo "<script>recuperarElemento('-login-incorrecto');</script>";

					$_SESSION['formularioEnviado-login'] = false;
				}
			?>
		</header>

		<main>
			<?php 
				if (isset($_SESSION['usuario'])) {

					// Acceder a los datos del usuario almacenados en las variables de sesión
                    $nombre = $_SESSION['nombre'];
                    $apellidos = $_SESSION['apellidos'];
                    $ruta_foto = $_SESSION['ruta_foto'];
                    $usuario = $_SESSION['usuario'];
                    $password = $_SESSION['password'];
				}
			?>

			<h1 id='titulo'><?php echo $usuario; ?></h1>
			<form onsubmit="return validarFormularioRegistroProfesor(event, '')" action="../php/modificar_profesor.php" method="POST" class="formulario" id="formulario-modificar">
				<button type="button" onclick="habilitarEdicion()" id="boton-editar">Editar perfil</button>
				<button type="button" onclick="deshabilitarEdicion()" id="boton-cerrarEdicion" style="display: none;">Cerrar X</button>

				<article class="campo">
					<label for="nombre" class="titulo-campo">Nombre:</label>
					<input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>" required disabled>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo">Apellidos:</label>
					<input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos?>" required disabled>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo">Fotograf&iacute;a:</label>
					<input type="text" id="ruta_foto" name="ruta_foto" value="<?php echo $ruta_foto?>" required disabled>
				</article>

				<article class="campo">
					<label for="usuario" class="titulo-campo">Nombre de usuario:</label>
					<input type="text" id="usuario" name="usuario" value="<?php echo $usuario?>" required disabled>
					<p id="usuario-incorrecto" style="display:none;">El nombre de usuario debe tener entre 4 y 30 carcteres y contener &uacute;nicamente letras, n&uacute;meros, guiones y guiones bajos</p>
				</article>
      
				<article class="campo">
					<label for="password" class="titulo-campo">Contrase&ntilde;a:</label>
					<input type="password" id="password" name="password" value="<?php echo $password?>" required disabled>
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article>
				
				<article class="campo">
					<label for="password-confirm" class="titulo-campo">Confirmar Contrase&ntilde;a:</label>
					<input type="password" id="password-confirm" name="password-confirm" value="<?php echo $password?>" required disabled>
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article>
				
				<article class="enviar">
					<input type="submit" id="boton-enviar" value="Guardar cambios" style="display:none;" disabled>
				</article>
			</form>

			<?php 
				// Si estamos en esta página y no tenemos iniciada la sesión
				if (!isset($_SESSION['usuario'])) {
					// Eliminamos el formulario y el perfil de usuario
					echo "<script>eliminarElemento('formulario-modificar');</script>";
					echo "<script>eliminarElemento('titulo');</script>";

					$tipo = '"-login2"';

					// Creamos una section para que el usuario inicie sesion
					echo 
					"<section class='mensaje'>
						<h1>No existe sesi&oacute;n activa</h1>
						<p>Inicia sesión para ver tu perfil de usuario.</p>
						
						<form onsubmit='return validarFormularioLogin(event, $tipo)' action='../php/login_profesores.php' method='POST' class='formulario'>
							<h2>Iniciar sesi&oacute;n</h2>
							<label for='usuario-login2'>Usuario/Correo:</label>
							<input type='text' id='usuario-login2' name='usuario-login2' required>
							<p id='usuario-login2-incorrecto' style='display:none;'>El usuario no tiene un formato v&aacute;lido</p>
							<br>
							<label for='password-login2'>Contrase&ntilde;a:</label>
							<input type='password' id='password-login2' name='password-login2' required>
							<p id='password-login2-incorrecto' style='display:none;'>La contraseña no tiene un formato v&aacute;lido</p>
							<br>
							<input type='text' id='tipo-login' name='tipo-login' value='-login2' style='display:none;'>
							<input type='text' id='location-login' name='location-login' value='../profesores/modificacion_profesores.php' style='display:none;'>
							<input type='text' id='location2-login' name='location2-login' value='../profesores/modificacion_profesores.php' style='display:none;'>
							<input type='submit' value='Iniciar sesi&oacute;n'>
						</form>
						<p id='-login2-incorrecto' style='display:none;'>La contrase&ntilde;a o el correo electr&oacute;nico son incorrectos. Int&eacute;ntalo de nuevo.</p>
			  		</section>";

					// Si no hay ninguna sesión activa
					if(isset($_SESSION['formularioEnviado-login2']) && $_SESSION['formularioEnviado-login2'] == true){	
						// Mostramos un mensaje de error
						echo "<script>recuperarElemento('-login2-incorrecto');</script>";

						$_SESSION['formularioEnviado-login2'] = false;
					}
				}
			?>
		</main>

		<footer>
		</footer>
	</body>
</html>