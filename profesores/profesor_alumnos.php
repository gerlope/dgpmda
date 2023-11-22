<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de profesor</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/admin.css">
	</head>
	<body>
	<header>
			<div>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador redirigimos a la página del administrador que cuenta con más opciones
					if (isset($_SESSION['admin'])) {
						header("Location: ../admin/admin_tareas.php");
					}
					else if (isset($_SESSION['usuario'])) {		// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión

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
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}
				?>
				<div><h1 id='titulo'>Gesti&oacute;n de Alumnos</h1></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesion</h3></button></a>
			</div>
		</header>

		<main>
			<div class="div-principal">
				<section class="opciones-admin">
					<a href="profesor_tareas.php"><button><h3>Tareas</h3></button></a>

					<a href="profesor_alumnos.php"><button><h3>Alumnos</h3></button></a>

					<a href="profesor_multimedia.php"><button><h3>Multimedia</h3></button></a>
				</section>

				<section class="alumnos">
					<div class="barra-busqueda">
						<form action="profesor_alumnos.php" method="get">
							<input type="text" id="filtro" name="filtro" placeholder="Busqueda"><br><br>
							<input type="submit" value="Submit">
						</form>
					</div>

					<div class="lista-personal">
						<?php
							require_once('../php/alumnos.class.inc');

							$tmp = new Alumnos();
							$alumnos = $tmp->obtenerAlumnos();		//$_GET["filtro"]
							$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumno'] como una matriz vacía
							$i = 0;

							if (empty($_GET["page"])) {
								$page = 1;
							} else {
								$page = $_GET["page"];
							}

							if($alumnos){
								$perPage = 12;
								$startIndex = ($page - 1) * $perPage;
								$endIndex = $startIndex + $perPage - 1;

								foreach ($alumnos as $alumno) {
									if ($i >= $startIndex && $i <= $endIndex) {
										$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];

										// Guardamos en una variable de sesion el alumno correspondiente
										$_SESSION['alumno'][$i] = serialize($alumno);
										
										// Creamos todos los articles de los alumnos
										echo "
										<article class='alumno'>
											<div>
												<img src='../multimedia/imagenes/" . $alumno['ruta_foto'] . "' width='70' height='70' alt='Foto de perfil del alumno'>
												<h3 align='center'>{$alumnosNombre[$i]}</h3>
											</div>
										</article>";
									}
									$i++;
								}
								
								$pagep = $page+1;
								$pagem = $page-1;
								echo "</div>
								<form method='get'>";
									if($page!=1) {
										echo "<button type='submit' name='page' value='$pagem' action='admin_alumnos.php'><<</button>";
									} else {echo "<div></div>";}
									echo "<t>Page $page</t>";
									if(sizeof($alumnos)>=$page*$perPage) {
										echo "<button type='submit' name='page' value='$pagep' action='admin_alumnos.php'>>></button>";
									} else {echo "<div></div>";}
								echo "</form>";
								
							}	
							else{
								echo "<article class='alumno'><h2>No hay ning&uacute;n alumno registrado</h2></article></div>";
							}
						?>
				</section>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>