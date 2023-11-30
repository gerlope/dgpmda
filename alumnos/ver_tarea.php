<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="javascript/funciones_basicas.js"></script>
		<script src="javascript/validar_formularios.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/alumno.css">
	</head>

	<body>
		<header>
			<div>
			<?php
            
                // Iniciar la sesión
			    session_start();
                
                if (isset($_SESSION['alumno'])) {		// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión

					// Acceder al nombre de usuario almacenado en la variable de sesión
					$username = $_SESSION['nombre'];
					$ruta_foto = $_SESSION['ruta_foto'];

                    // Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
					echo "<div id='perfil-login'>
						<a href='../alumnos/alumno.php'>
							<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
							<div><h2>$username</h2></div>
						</a>
					</div>";
    			}
				else{		// Si no hay ninguna sesión de usuario activa
					header("Location: ../index.php");
				}

				$seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';


                require_once('../php/tareas.class.inc');
                // Obtener el tarea_id de la URL
                $tarea_id = isset($_GET['tarea_id']) ? $_GET['tarea_id'] : null;

                // Validar si el tarea_id está presente
                if (!$tarea_id) {
                    echo "Error: Tarea no especificada.";
                    exit;
                }

                // Obtener información detallada de la tarea
                $tarea_info = Tareas::obtenerTarea($tarea_id);

                // Verificar si se encontró información de la tarea
                if ($tarea_info) {
                    // Acceder a la información de la tarea
                    $titulo_tarea = $tarea_info['titulo'];
					$ruta_foto_tarea = $tarea_info['ruta_icono'];
                    $ruta_documento = $tarea_info['ruta_documento'];
                }


				?>

                
				<div id='div-titulo'><img src='../multimedia/imagenes/icono_alumno.png' width='60' height='60' alt='Icono página inicial'>
				<h1 id='titulo'><?= $titulo_tarea; ?></h1></div>
				<a href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>
        
        <main class="detalles-tarea">
            <div class="imagen-tarea">
                <img src='../multimedia/imagenes/<?php echo $ruta_foto_tarea; ?>' width='500' height='500' alt='Foto de la tarea'>
            </div>

            <div class="botones-tarea">
				<a href='ver_pasos_tarea.php?tarea_id=<?php echo $tarea_id; ?>'>
					<button>
						<h3>Ver pasos</h3>
						<img src='../multimedia/imagenes/icono_pasos.png' alt='Ver pasos'>
					</button>
				</a>

				<a href='../multimedia/documentos/<?php echo $ruta_documento; ?>' target="_blank">
					<button>
						<h3>Ver documento</h3>
						<img src='../multimedia/imagenes/icono_documentos.png' alt='Ver documento'>
					</button>
				</a>
			</div>
         </main>
            

            
       
    
    </body>
    
</html>