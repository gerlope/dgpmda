<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Aprendefacil</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="javascript/funciones_basicas.js"></script>
		<script src="javascript/validar_formularios.js"></script>
	</head>

	<body>
		<header>
			<article id="form-login">
				<h2>¿Eres profesor? Inicia sesi&oacute;n</h2>
				<form onsubmit="return validarFormularioLogin(event, '-login')" action="php/login_profesores.php" method="POST" class="formulario">
					<label for="usuario-login">Usuario/Correo:</label>
					<input type="text" id="usuario-login" name="usuario-login" required>
					<p id="usuario-login-incorrecto" style="display:none;">El usuario no tiene un formato v&aacute;lido</p>
					<br>
					<label for="password-login">Contrase&ntilde;a:</label>
					<input type="password" id="password-login" name="password-login" required>
					<p id="password-login-incorrecto" style="display:none;">La contrase&ntilde;a no tiene un formato v&aacute;lido</p>
					<br>
					<input type="submit" value="Iniciar sesi&oacute;n">
				</form>
				<p id="-login-incorrecto" style="display:none;">La contrase&ntilde;a o el correo electr&oacute;nico son incorrectos. Int&eacute;ntalo de nuevo.</p>
			</article>

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
					// Si la sesión activa es la de el administrador añadimos una linea para ir al panel de administrador
					if(isset($_SESSION['admin'])){
						echo "<article id='perfil-login'>
						<a href='profesores/modificacion_profesores.php'>
						<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></a>
						<a href='admin/admin-tareas.php'>
						<h2>Ir a panel de administrador</h2></a>
						<a href='php/logout.php'>&#10149; Cerrar sesión</a></article>";
					}
					else{
						echo "<article id='perfil-login'>
						<a href='profesores/modificacion_profesores.php'>
						<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></a>
						<a href='php/logout.php'>&#10149; Cerrar sesión</a></article>";
					}
				}
				else if(isset($_SESSION['formularioEnviado-login']) && $_SESSION['formularioEnviado-login'] == true){	// Si no hay ninguna sesión activa
					// Mostramos un mensaje de error
					echo "<script>recuperarElemento('-login-incorrecto');</script>";

					$_SESSION['formularioEnviado-login'] = false;
				}
			?>
		</header>

		<main>
			<section class="alumnos">
				<h2>Alumnos</h2>
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
							echo "<article class='alumno'>
								<a href='alumnos/inicio_sesion.php?indice=$i'>
									<img src='multimedia/imagenes/" . $alumno['ruta_foto'] . "' width='60' height='60' alt='Foto de perfil del alumno' >
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