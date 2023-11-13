<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Perfil de administrador</title>
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
	</head>
	<body>
		<header>
			<div style='display: flex; align-content: center; justify-content: space-between'>
				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa de administrador, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['admin'])) {

						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login' style='display: flex; align-content: center; margin:15px'>
							<a href='../profesores/modificacion_profesores.php' style='display: flex; justify-content: flex-start'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div style='margin-left: 5px'><h2>$username</h2></div>
							</a>
						</div>";
					}
					else{		// Si no hay ninguna sesión de administrador activa
						header("Location: ../index.php");
					}
				?>
				<a href='../php/logout.php' style='margin: 15px'><button><h3>Cerrar Sesion</h3></button></a>
			</div>
		</header>

		<main>
			<div style='display:flex; align-content:start'>
				<section style='display: flex; flex-direction: column; justify-content:center; gap: 40px; margin: 50px'>
					<a href="admin-tareas.php"><button style="width:175px; height:80px"><h3>Tareas</h3></button></a>
				
					<a href="admin-profesores.php"><button style="width:175px; height:80px"><h3>Profesores</h3></button></a>

					<a href="admin-alumnos.php"><button style="width:175px; height:80px"><h3>Alumnos</h3></button></a>

					<a href="admin-multimedia.php"><button style="width:175px; height:80px"><h3>Multimedia</h3></button></a>
				</section>

				<section class="profesores" style='height:706px'>
					<h2 align='center' style='margin-top: 0'>Profesores</h2>
					<div style='display:flex; justify-content:space-between'>
						<form action="admin-profesores.php" method="get" style='display:flex; justify-content:start'>
							<input type="text" id="filtro" name="filtro" placeholder="Busqueda" style='margin-left: 25px'><br><br>
							<input type="submit" value="Submit">
						</form>
						<a href="alta_profesores.php"><button>Nuevo Profesor</button></a>
					</div>
					<div style="display:flex; flex-wrap:wrap; width:1500px; margin:15px">
						<?php
							require_once('../php/profesores.class.inc');

							$tmp = new Profesores();
							$profesores = $tmp->obtenerProfesores();		//$_GET["filtro"]
							$_SESSION['profesor'] = array(); 			// Inicializa $_SESSION['profesor'] como una matriz vacía
							$i = 0;

							if (empty($_GET["page"])) {
								$page = 1;
							} else {
								$page = $_GET["page"];
							}

							if($profesores){
								foreach ($profesores as $profesor) {
									if (30*($page-1) < $profesor["id"] && $profesor["id"] <= 30*$page) {
										$profesoresNombre[$i] = $profesor['nombre'] . ' ' . $profesor['apellidos'];

										// Guardamos en una variable de sesion el profesor correspondiente
										$_SESSION['profesor'][$i] = serialize($profesor);
										
										// Creamos todos los articles de los profesores
										echo "
										<article>
											<a href='../profesores/modificacion_profesores.php?indice=$i' style='color:inherit'>
											<div style='border-style: solid;padding:2px 2px; margin:5px; width:130px; height:165px; display:flex; flex-direction: column'>
												<img src='../multimedia/imagenes/" . $profesor['ruta_foto'] . "' width='70' height='70' alt='Foto de perfil del profesor' style='margin: auto'>
												<h3 align='center' style='margin-bottom:10px; margin-top:5px'>$profesoresNombre[$i]</h3>
											</div>
											</a>
										</article>";
									}
									$i++;
								}
								

								$pagep = $page+1;
								$pagem = $page-1;
								echo "</div>
								<form method='get' style='display:flex; justify-content:center; align-self:flex-end'>";
									if($page!=1) {
										echo "<button type='submit' name='page' value='$pagem' action='admin-profesores.php'><<</button>";
									} else {echo "<div></div>";}
									echo "<t style='margin:10px'>Page $page</t>";
									if(sizeof($profesores)>=$page*30) {
										echo "<button type='submit' name='page' value='$pagep' action='admin-profesores.php'>>></button>";
									} else {echo "<div></div>";}
								echo "</form>";
								
							}	
							else{
								echo "<article class='profesor'><h2>No hay ning&uacuten profesor registrado</h2></article></div>";
							}
						?>
				</section>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>