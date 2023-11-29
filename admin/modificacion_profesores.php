<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Perfil de profesor</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/formulario.css">
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
				<div id="div-titulo"><h1 id='titulo'>Modificar Profesor</h1>
				<img src='../multimedia/imagenes/icono_admin.png' width='60' height='60' alt='Icono administrador'></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<?php 				
				// Acceder a los datos de los profesores almacenados en la variable de sesión
				// Usamos $_GET porque en este caso el indice de los profesores no compromete
				// al sistema ni a la seguridad y privacidad del mismo
				$profesor = unserialize($_SESSION['profesor'][$_GET['indice']]);

				$nombre = $profesor['nombre'];
				$apellidos = $profesor['apellidos'];
				$usuario = $profesor['usuario'];
				$ruta_foto = $profesor['ruta_foto'];
				$aula = $profesor['aula'];
				$es_administrador = $profesor['es_administrador'];
				$password = $profesor['password'];
				$_SESSION['usuario_profesor'] = $profesor['usuario'];
			?>

			<a href="./admin_profesores.php" class="boton-volver" aria-label="Volver al inicio" role="button">&#129152;</a>
			<form onsubmit="return validarFormularioRegistroProfesor(event, '')" action="../php/modificar_profesor.php" method="POST" class="formulario" id="formulario-modificar">
				<button type="button" onclick="habilitarEdicion()" class="button" id="boton-editar">Editar perfil</button>
				<button type="button" onclick="deshabilitarEdicion()" class="button" id="boton-cerrarEdicion" style="display: none;">Cerrar X</button></br>

				<article class="campo">
					<label for="nombre" class="titulo-campo"><b>Nombre:</b></label></br>
					<input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>" required disabled>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article></br>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo"><b>Apellidos:</b></label></br>
					<input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos?>" required disabled>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article></br>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo"><b>Fotograf&iacute;a:</b></label></br>
					<img src="" class="pic_field" id="foto"></br>
					<input type="file" id="ruta_foto" name="ruta_foto" accept="image/*" required disabled>
				</article></br>

				<article class="campo">
					<label for="aula" class="titulo-campo"><b>Aula:</b></label></br>
					<input type="text" id="aula" name="aula" value="<?php echo $aula?>" required disabled>
					<p id="aula-incorrecto" style="display:none;">El aula debe contener &uacute;nicamente caracteres alfan&uacute;mericos</p>
				</article></br>

				<article class="campo">
					<label for="usuario" class="titulo-campo"><b>Nombre de usuario:</b></label></br>
					<input type="text" id="usuario" name="usuario" value="<?php echo $usuario?>" required disabled>
					<p id="usuario-incorrecto" style="display:none;">El nombre de usuario debe tener entre 4 y 30 carcteres y contener &uacute;nicamente letras, n&uacute;meros, guiones y guiones bajos</p>
				</article></br>
      
				<article class="campo">
					<label for="password" class="titulo-campo"><b>Contrase&ntilde;a:</b></label></br>
					<input type="password" id="password" name="password" value="<?php echo $password?>" required disabled>
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article></br>
				
				<article class="campo">
					<label for="password-confirm" class="titulo-campo"><b>Confirmar Contrase&ntilde;a:</b></label></br>
					<input type="password" id="password-confirm" name="password-confirm" value="<?php echo $password?>" required disabled>
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article></br>
				
				<article class="enviar">
					<input type="submit" class="button-big" id="boton-enviar" value="Guardar cambios" style="display:none;" disabled>
				</article>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>