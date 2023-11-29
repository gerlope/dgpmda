<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Alta de alumnos</title>
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
				<div id="div-titulo"><h1 id='titulo'>Alta Alumnos</h1>
				<img src='../multimedia/imagenes/icono_admin.png' width='60' height='60' alt='Icono administrador'></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
		<a href="./admin_alumnos.php" class="boton-volver" aria-label="Volver al inicio" role="button">&#129152;</a>
			<form onsubmit="return validarFormularioRegistroAlumno(event, '')" action="../php/registrar_alumno.php" method="POST" class="formulario">
				<article class="campo">
					<label for="nombre" class="titulo-campo"><b>Nombre:</b></label></br>
					<input type="text" id="nombre" name="nombre" required>
					<p id="nombre-incorrecto" style="display:none;">El nombre debe contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article></br>
				
				<article class="campo">
					<label for="apellidos" class="titulo-campo"><b>Apellidos:</b></label></br>
					<input type="text" id="apellidos" name="apellidos" required>
					<p id="apellidos-incorrecto" style="display:none;">Los apellidos deben contener &uacute;nicamente caracteres alfab&eacute;ticos</p>
				</article></br>

				<article class="campo">
					<label for="aula" class="titulo-campo"><b>Aula:</b></label></br>
					<input type="text" id="aula" name="aula" required>
					<p id="aula-incorrecto" style="display:none;">El aula debe contener &uacute;nicamente caracteres alfan&uacute;mericos</p>
				</article></br>

                <article class="campo">
					<label for="ruta_foto" class="titulo-campo"><b>Fotograf&iacute;a personal:</b></label></br>
					<img src="" class="pic_field" id="foto"></br>
					<input type="file" id="ruta_foto" name="ruta_foto" accept="image/*" required>
				</article></br>

				<article>
					<fieldset id="fieldset-perfil_visualizacion" name="fieldset-perfil_visualizacion" class="fieldset">
						<legend class="titulo-campo"><b>Perfil preferente de visualizaci&oacute;n:</b></legend>

						<label>
						<input type="checkbox" name="perfil[]" value="audio">Audio</label>

						<label>
						<input type="checkbox" name="perfil[]" value="visual">V&iacute;deos y fotos</label>

						<label>
						<input type="checkbox" name="perfil[]" value="texto">Texto</label>
					</fieldset>
					<p id="fieldset-perfil_visualizacion-incorrecto" style="display:none;">Se debe seleccionar al menos una opci&oacute;n de visualizaci&oacute;n</p>
				</article></br>

				<article>
					<fieldset id="fieldset-tipo_password" name="fieldset-tipo_password" class="fieldset">
						<legend class="titulo-campo"><b>Tipo de contrase&ntilde;a:</b></legend>

						<label>
						<input type="radio" name="tipo[]" id="tipo-texto" value="texto">Texto</label>

						<label>
						<input type="radio" name="tipo[]" id="tipo-pictogramas" value="pictogramas">Pictogramas</label>
					</fieldset>
					<p id="fieldset-tipo_password-incorrecto" style="display:none;">Se debe seleccionar al menos un tipo de contrase&ntilde;a</p>
				</article></br>
      
				<article class="campo" id="campo-password">
					<label for="password" class="titulo-campo"><b>Contrase&ntilde;a:</b></label></br>
					<input type="password" id="password" name="password">
					<p id="password-incorrecto" style="display:none;">La contrase&ntilde;a debe tener 4 o más caracteres</p>
				</article></br>
				
				<article class="campo" id="campo-password-confirm">
					<label for="password-confirm" class="titulo-campo"><b>Confirmar Contrase&ntilde;a:</b></label></br>
					<input type="password" id="password-confirm" name="password-confirm">
					<p id="password-confirm-incorrecto" style="display:none;">La contrase&ntilde;a no coincide. Int&eacute;ntalo de nuevo</p>
				</article>

				<article class="campo" id="campo-pictogramas" style="display:none;">
					<label class="titulo-campo"><b>Pictogramas:</b></label></br></br>
					<label for="pictograma_1" class="titulo-campo">Primer Pictograma:</label></br>
					<img src="" class="pic_field" id="picto1"></br>
					<input type="file" id="pictograma_1" name="pictograma_1" accept="image/*"></br></br>

					<label for="pictograma_2" class="titulo-campo">Segundo Pictograma:</label></br>
					<img src="" class="pic_field" id="picto2"></br>
					<input type="file" id="pictograma_2" name="pictograma_2" accept="image/*"></br></br>

					<label for="pictograma_3" class="titulo-campo">Tercer Pictograma:</label></br>
					<img src="" class="pic_field" id="picto3"></br>
					<input type="file" id="pictograma_3" name="pictograma_3" accept="image/*"></br></br>
				</article></br>
				
				<article class="enviar">
					<input type="submit" value="Registrarse" class="button-big">
				</article></br>
			</form>

			<script>
				// Función para manejar la visibilidad de los campos de contraseña
				function displayImage(id, archivo) {
					document.getElementById(id).src="../multimedia/pictogramas_password/" + archivo;
					document.getElementById(id).value = archivo;
					document.getElementById(id).display = "block";
				};
				
				function togglePasswordFields() {
					var tipoTextoCheckbox = document.getElementById('tipo-texto');
					var tipoPictogramasCheckbox = document.getElementById('tipo-pictogramas');
					var campoPassword = document.getElementById('campo-password');
					var campoPasswordConfirm = document.getElementById('campo-password-confirm');
					var campoPictogramas = document.getElementById('campo-pictogramas');

					// Si el tipo de contraseña es con texto
					if (tipoTextoCheckbox.checked) {
						campoPassword.style.display = 'block';
						campoPasswordConfirm.style.display = 'block';
						campoPassword.querySelector('input').setAttribute('required', 'required');
                		campoPasswordConfirm.querySelector('input').setAttribute('required', 'required');
					} else {
						campoPassword.style.display = 'none';
						campoPasswordConfirm.style.display = 'none';
						campoPassword.querySelector('input').removeAttribute('required');
                		campoPasswordConfirm.querySelector('input').removeAttribute('required');
					}

					// Si el tipo de contraseña es con pictogramas
					if (tipoPictogramasCheckbox.checked) {
						campoPictogramas.style.display = 'block';
						campoPictogramas.querySelectorAll('input').forEach(function(input) {
							input.setAttribute('required', 'required');
						});
					} else {
						campoPictogramas.style.display = 'none';
						campoPictogramas.querySelectorAll('input').forEach(function(input) {
							input.removeAttribute('required');
						});
					}
				}

				// Asociamos la función al evento de cambio del checkbox
				document.getElementById('tipo-texto').addEventListener('change', togglePasswordFields);
				document.getElementById('tipo-pictogramas').addEventListener('change', togglePasswordFields);

				// Llamada inicial para asegurar que los campos se muestren correctamente al cargar la página
				togglePasswordFields();
			</script>
		</main>

		<footer>
		</footer>
	</body>
</html>