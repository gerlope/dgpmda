<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de administrador</title>
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
				<div><h1 id='titulo'>Gesti&oacute;n de Profesores</h1></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesion</h3></button></a>
			</div>
		</header>

		<main>
			<div class="div-principal">
				<section class="opciones-admin">
					<a href="admin_tareas.php"><button><h3>Tareas</h3></button></a>
				
					<a href="admin_profesores.php"><button><h3>Profesores</h3></button></a>

					<a href="admin_alumnos.php"><button><h3>Alumnos</h3></button></a>

					<a href="admin_multimedia.php"><button><h3>Multimedia</h3></button></a>
				</section>

				<section class="profesores">
					<div class="barra-busqueda">
						<form action="admin_profesores.php" method="get">
							<input type="text" id="filtro" name="filtro" placeholder="Busqueda"><br><br>
							<input type="submit" value="Submit">
						</form>
						<a href="alta_profesores.php"><button>Nuevo Profesor</button></a>
					</div>

					<div class="lista-personal">
						<?php
							require_once('../php/profesores.class.inc');

							$tmp = new Profesores();
							$profesores = $tmp->obtenerProfesores();		
							$_SESSION['profesor'] = array(); 			// Inicializa $_SESSION['profesor'] como una matriz vacía
							$i = 0;

							if (empty($_GET["page"])) {
								$page = 1;
							} else {
								$page = $_GET["page"];
							}

							if($profesores){
								$perPage = 12;
								$startIndex = ($page - 1) * $perPage;
								$endIndex = $startIndex + $perPage - 1;

								foreach ($profesores as $profesor) {
									if ($i >= $startIndex && $i <= $endIndex) {
										$profesoresNombre[$i] = $profesor['nombre'] . ' ' . $profesor['apellidos'];

										// Guardamos en una variable de sesion el profesor correspondiente
										$_SESSION['profesor'][$i] = serialize($profesor);
										
										// Creamos todos los articles de los profesores
										echo "
										<article class='profesor'>";
										if($profesor['usuario'] == $_SESSION['usuario']){
											echo "
											<a href='../profesores/modificacion_profesores.php'>";
										}
										else{
											echo "
											<a href='../admin/modificacion_profesores.php?indice=$i'>";
										}
										echo "
											<div>
												<img src='../multimedia/imagenes/" . $profesor['ruta_foto'] . "' width='70' height='70' alt='Foto de perfil del profesor'>
												<h3>$profesoresNombre[$i]</h3>
											</div>
											</a>
										</article>";
									}
									$i++;
								}
								

								$pagep = $page+1;
								$pagem = $page-1;
								echo "</div>
								<form method='get'>";
									if($page!=1) {
										echo "<button type='submit' name='page' value='$pagem' action='admin_profesores.php'><<</button>";
									} else {echo "<div></div>";}
									echo "<t>Page $page</t>";
									if(sizeof($profesores)>=$page*$perPage) {
										echo "<button type='submit' name='page' value='$pagep' action='admin_profesores.php'>>></button>";
									} else {echo "<div></div>";}
								echo "</form>";
								
							}	
							else{
								echo "<article class='profesor'><h2>No hay ning&uacute;n profesor registrado</h2></article></div>";
							}
						?>
				</section>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>