<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('tareas.class.inc');
        require_once('alumnos.class.inc');

        $tareas = new Tareas();

        // Obtenemos el id de la tarea y de los alumnos
        $tarea_id = $_POST['tarea_id'];
        $alumnosSeleccionados = $_POST["alumnos_id"];


        $tareas->eliminarAlumnosTarea($alumnosSeleccionados, $tarea_id);
        // Si no hay ningún alumno seleccionado eliminamos los previamente introducidos
        if(!isset($_POST["alumnos_id"]) || empty($_POST["alumnos_id"])){
            $tareas->eliminarTareaAlumno($tarea_id);
        }
        else{
            // Iteramos sobre los valores seleccionados
            foreach ($alumnosSeleccionados as $alumno_id) {
                // Insertamos los datos en la base de datos
                $tareas->asignarTarea($tarea_id, $alumno_id);
            }
        }

        header('Location: ../admin/admin_tareas.php');
    }
?>