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

				<section class="tareas" style='margin:auto; margin-top:0; height:706px'>
					<h2 align='center' style='margin-top: 0'>Tareas</h2>
					<div style='display:flex; justify-content:space-between'>
						<form action="admin-tareas.php" method="get" style='display:flex; justify-content:start'>
							<input type="text" id="filtro" name="filtro" placeholder="Busqueda" style='margin-left: 25px'><br><br>
							<input type="submit" value="Submit">
						</form>
						<a href="crear_tareas.php"><button>Nueva Tarea</button></a>
					</div>
					<table style="border: 3px solid black; border-collapse: collapse; table-layout: auto; width:450px; margin: 20px">
						<tbody>
							<tr>
								<th style='border: 2px solid black; border-collapse'><b>Nombre</b></th>
							</tr>
							<?php
								require_once('../php/tareas.class.inc');

								$tmp = new Tareas();
								$tareas = $tmp->obtenerTareas();
								$_SESSION['tarea'] = array(); 			// Inicializa $_SESSION['tarea'] como una matriz vacía
								$i = 0;

								if (empty($_GET["page"])) {
									$page = 1;
								} else {
									$page = $_GET["page"];
								}

								if($tareas){
									foreach ($tareas as $tarea) {
										if (15*($page-1) < $tarea["id"] && $tarea["id"] <= 15*$page) {
											$tareasTitulo[$i] = $tarea['titulo'];

											// Guardamos en una variable de sesion de la tarea correspondiente
											$_SESSION['tarea'][$i] = serialize($tarea);
											
											// Creamos todos los articles de las tareas
											echo "<tr>
												<td align='left' style='border: 1px solid black; border-collapse'><a href='../admin/asignar_tareas.php?indice=$i' style='color: inherit'><h3 style='margin: 3px'>{$tareasTitulo[$i]}</h3></a></td>
											</tr>";
										}
										$i++;
									}
								
								$pagep = $page+1;
								$pagem = $page-1;
								echo "</tbody>
								</table>
								<form method='get' style='display:flex; justify-content:center; align-self:flex-end'>";
									if($page!=1) {
										echo "<button type='submit' name='page' value='$pagem' action='admin-tareas.php'><<</button>";
									} else {echo "<div></div>";}
									echo "<t style='margin:10px'>Page $page</t>";
									if(sizeof($tareas)>=$page*15) {
										echo "<button type='submit' name='page' value='$pagep' action='admin-tareas.php'>>></button>";
									} else {echo "<div></div>";}
								echo "</form>";
							}
							else{
								echo "<article class='alumno'><h2>No hay ning&uacuten alumno registrado</h2></article></tbody></table>";
							}
							?>
					
				</section>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>