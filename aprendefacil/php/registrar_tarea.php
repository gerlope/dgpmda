<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('tareas.class.inc');

        $tareas = new Tareas();
        $titulo = $_POST['titulo'];
        $ruta_documento = $_POST['ruta_documento'];

        // Obtenemos el número de pasos del formulario
        $numero_pasos_totales = $_POST['numero_pasos'];
        $numero_pasos = 0;

        // Inicializamos un array vacío para almacenar los datos de los pasos
        $pasos = array();

        // Iteramos a través de los pasos y recogemos los datos
        for ($i = 1; $i <= $numero_pasos_totales; $i++) {
            if(isset($_POST["paso_descripcion_$i"]) && !empty($_POST["paso_descripcion_$i"])){
                $numero_pasos++;
                $paso = array(
                    'descripcion' => $_POST["paso_descripcion_$i"],     // Descripción del paso
                    'video' => $_POST["paso_video_$i"],                 // Nombre del archivo de video
                    'foto' => $_POST["paso_foto_$i"],                   // Nombre del archivo de foto
                    'audio' => $_POST["paso_audio_$i"]                  // Nombre del archivo de audio
                );
    
                // Agregamos el paso al array de pasos
                $pasos[$i] = $paso;
            }
        }

        // Insertamos los datos en la base de datos
        $tareas->insertarTarea($titulo, $ruta_documento, $numero_pasos, $pasos, $numero_pasos_totales);
    }
?>