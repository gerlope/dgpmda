<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('alumnos.class.inc');

        $alumnos = new Alumnos();
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $password = $_POST['password'];
        $pictograma_1 = $_POST['pictograma_1'];
        $pictograma_2 = $_POST['pictograma_2'];
        $pictograma_3 = $_POST['pictograma_3'];
        $aula = $_POST['aula'];
        $ruta_foto = $_POST['ruta_foto'];

        // Convertimos el array de valores del perfil de visualizacion en una cadena separada por comas
        // lo mismo para los valores del tipo de contraseña
        $perfil_visualizacion = implode(', ', $_POST['perfil']);
        $tipo_password = implode(', ', $_POST['tipo']);

        // Con los pictogramas los juntamos todos en un array
        $pictogramas[1] = $pictograma_1;
        $pictogramas[2] = $pictograma_2;
        $pictogramas[3] = $pictograma_3;

        // Si el tipo de contraseña no es de texto, no alamacenamos nada
        if(!(strpos($tipo_password, 'texto') || strpos($tipo_password, 'texto') === 0)){
            $password = "";
        }
        else if(!(strpos($tipo_password, 'pictogramas') || strpos($tipo_password, 'pictogramas') === 0)){   // Ídem con pictogramas
            unset($pictogramas);
            $pictogramas = [];
        }
        
        // Insertamos los datos en la base de datos
        $alumnos->insertarAlumno($nombre, $apellidos, $tipo_password, $password, $pictogramas, $aula, $perfil_visualizacion, $ruta_foto);
    }
?>