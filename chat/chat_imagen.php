<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/index.css">
        
        <link rel="stylesheet" type="text/css" href="../css/chat.css">
	</head>

	<body>
		<header>
			<div id="div-header">
				<div id="barra-lateral" class="barra-lateral">
					<a href="#" class="boton-cerrar" onclick="ocultar()"><button><h3>&#10008;</h3></button></a>
					<div id="contenido">
						<div id='perfil-login-reducido'></div>
						<a id='enlace-header-reducido' href='../profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>
					</div>
				</div>
					
				<div id="boton-barra-lateral">
					<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><button><h3>&#9776;</h3></button></a>
					<a id="cerrar" class="abrir-cerrar" href="javascript:void(0)" onclick="ocultar()" style='display: none;'></button><h3>&#9776;</h3></button></a>
				</div>

				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['usuario'])) {
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						// Si la sesión activa es la de el administrador añadimos una linea para ir al panel de administrador
						if(isset($_SESSION['admin'])){
							echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
							<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
							<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
						else{
							echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
							<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
							<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
					}
					else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){
						// Acceder al nombre de alumno almacenado en la variable de sesión
						$username = $_SESSION['nombre'] . " " . $_SESSION['apellidos'];
						$ruta_foto = $_SESSION['ruta_foto'];

						echo "<div id='perfil-login'>
						<a href='../alumnos/alumno.php'>
						<img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></a></div>
						<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
						<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
					}
					else{
						echo "<div id='perfil-login'></div>
						<div id='div-titulo'><img src='../multimedia/imagenes/chat.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Chat</h1></div>
						<a id='enlace-header' href='../profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>";
					}
                    $chat = unserialize($_SESSION['chat'][$_GET['chat']])
				?>
			</div>	
		</header>

		<main>
            <a href="../alumnos/alumno.php" class="boton-volver" aria-label="Volver a la página anterior" role="button">🢀</a>
            <div id='chat-enclosure'>
                
                <div id='chat'>
                </div>
                
                <div id='scroll-buttons'>
                    <button id='scrollup'><b>⬆</b></button>
                    <button id='scrolldown'><b>⬇</b></button>
                </div>
            </div>
            <script>
                var chat = document.querySelector("#chat");
                var scrollup = document.querySelector("#scrollup");
                var scrolldown = document.querySelector("#scrolldown");

                scrollup.addEventListener("click", function() {
                    chat.scrollTop -= 30;
                });

                scrolldown.addEventListener("click", function() {
                    chat.scrollTop += 30;
                });
            </script>
        </main>
        <div id='message-div'>
        <div class='botones-pantalla'><button onClick='anteriorPag()' class='boton-pantalla' id='prevPictos' aria-label="Ir a pictogramas anteriores" style='visibility: hidden;'>&#129152;</button></div>
        <form action='../php/mandar_mensaje.php' method='POST'>
                <?php
					$directorio = "../multimedia/imagenes";
					$page = isset($_GET['page']) ? $_GET['page'] : 1;
					$itemsPerPage = 8; 					// Número de elementos por página

					function verificarMasElementos($directorio, $currentPage, $itemsPerPage) {

						if (is_dir($directorio)) {
							$archivos = scandir($directorio);
							$extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

							$archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
								$extension = pathinfo($archivo, PATHINFO_EXTENSION);
								return in_array(strtolower($extension), $extensiones_permitidas);
							});

							// Calculamos la cantidad total de elementos y verifica si hay más allá de la página actual
							$totalItems = count($archivos_filtrados);
							$startIndex = ($currentPage - 1) * $itemsPerPage;
							$endIndex = $startIndex + $itemsPerPage;

							return $endIndex < $totalItems;
						}

						return false;
					}                    

                    // Verificamos que la carpeta exista
                    if (is_dir($directorio)) {
                        // Obtenemos la lista de archivos en la carpeta
						$archivos = scandir($directorio);
                        $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

                        $archivos_filtrados = array_filter($archivos, function ($archivo) use ($extensiones_permitidas) {
                            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                            return in_array(strtolower($extension), $extensiones_permitidas);
                        });

                        // Mostramos los archivos de la página actual
                        $start = ($page - 1) * $itemsPerPage;
                        $end = $start + $itemsPerPage - 1;

                        $count = 0;

                        foreach ($archivos_filtrados as $archivo) {
							$archivostr = '"'.$archivo.'"';
							if ($count >= $start && $count <= $end) {
                                echo "<button class='pictograma' name='input_mensaje' onClick='select(\"$archivo\")' value='" . $archivo . "'>
                                <img src='" . $directorio . "/" . $archivo . "' alt='" . $archivo . "' title='" . $archivo . " style='width:50px'></button>";
                            }
                            $count++;
                        }
                    }
                ?>
                <input class='hidden' id="input_chat_id" name="input_chat_id" type="text" value='<?php echo $chat['id'];?>'>
                <input class='hidden' id="input_sender" name="input_sender" type="text" value='<?php echo $username;?>'>
                <input class='hidden' id="input_senderimg" name="input_senderimg" type="text" value='<?php echo $ruta_foto;?>'>
        </form>
        <div class='botones-pantalla'><button onClick='siguientePag()' class='boton-pantalla' id='posPictos' aria-label='Mostrar más pictogramas'>&#129154;</button></div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
            var id = document.querySelector("#input_chat_id").value;
            setInterval(refreshMessages, 1000);
            function refreshMessages() {
                $.ajax({
                type: "POST",
                url: 'log_imagen.php',
                data: {"chat_id": id},
                success: function(data){
                    chat.innerHTML = data;
                }
                });
            }
        </script>

                <script>
					function selectPicto(archivo) {
							document.getElementById("input_mensaje").value = archivo;
							document.getElementById("preview").style.visibility = "visible";
					}
				</script>
	</body>
</html>