<?php
    require_once ('datos_object.class.inc');

    // Cada instancia de la clase Tareas se corresponde con una fila/registro de la tabla del mismo nombre
    class Tareas extends DataObject {

        /****************************************************************************************/
        /****************************************************************************************/
        /* Constructor */
        protected $datos = array(
            "titulo" => "",
            "ruta_documento"=>"",
            "numero_pasos"=>""
        );
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve la tarea con el id pasado */
        public static function obtenerTarea($id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_TAREAS . " WHERE id = :id";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":id", $id, PDO::PARAM_STR );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );

                if ( $fila ) return $fila;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve todas las tareas de la BD */
        public static function obtenerTareas() {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_TAREAS;

            try {
                $st = $conexion->prepare( $sql );
                $st->execute();
                $filas = $st->fetchAll(PDO::FETCH_ASSOC);
                parent::desconectar( $conexion );

                if ( $filas ) return $filas;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve toda la información de los pasos y su multimedia de una tarea 
        con un nombre de tarea y un numero de pasos dado */
        public static function obtenerPasosDeTarea($titulo, $numPasos) {
            $conexion = parent::conectar();
            $sql = "SELECT p.orden, p.descripcion, m.audio, m.foto, m.video FROM " . TABLA_TAREAS . " AS t
                    INNER JOIN " . TABLA_PASOS . " AS p ON t.id = p.tarea_id 
                    LEFT JOIN " . TABLA_MULTIMEDIA . " AS m ON p.id = m.paso_id
                    WHERE t.titulo = :titulo AND t.numero_pasos = :numPasos";
        
            try {
                $st = $conexion->prepare($sql);
                $st->bindValue(":titulo", $titulo, PDO::PARAM_STR);
                $st->bindValue(":numPasos", $numPasos, PDO::PARAM_STR);
                $st->execute();
                $pasos = $st->fetchAll(PDO::FETCH_ASSOC);
                parent::desconectar($conexion);
        
                if ($pasos) return $pasos;
            } catch (PDOException $e) {
                parent::desconectar($conexion);
                die("Consulta fallada: " . $e->getMessage());
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que inserta en la tabla tareas una tarea con los datos correspondientes */
        public static function insertarTarea($titulo, $ruta_documento, $numero_pasos, $pasos, $numero_pasos_totales) {
            $conexion = parent::conectar();

            $sql="INSERT INTO " . TABLA_TAREAS . "(titulo, ruta_documento, numero_pasos) VALUES (?, ?, ?)";

            try {
                $st = $conexion->prepare( $sql );
                $st->execute([$titulo, $ruta_documento, $numero_pasos]);
                $tarea_id = $conexion->lastInsertId();
                
                // Iteramos a través de los pasos y datos multimedia
                for ($i = 1, $orden = 0; $i <= $numero_pasos_totales; $i++) {

                    if($pasos[$i]["descripcion"] != null){
                        $descripcion = $pasos[$i]["descripcion"];
                        $video = $pasos[$i]["video"];
                        $foto = $pasos[$i]["foto"];
                        $audio = $pasos[$i]["audio"];
                        $orden++;
                        
                        // Insertamos datos de los pasos en la tabla "pasos"
                        $sql = "INSERT INTO " . TABLA_PASOS . "(tarea_id, orden, descripcion) VALUES (?, ?, ?)";
                        $st = $conexion->prepare($sql);
                        $st->execute([$tarea_id, $orden, $descripcion]);
                        $paso_id = $conexion->lastInsertId();
                        
                        // Insertamos datos de multimedia en la tabla "multimedia"
                        $sql = "INSERT INTO " . TABLA_MULTIMEDIA . "(paso_id, audio, foto, video) VALUES (?, ?, ?, ?)";
                        $st = $conexion->prepare($sql);
                        $st->execute([$paso_id, $audio, $foto, $video]);
                    }
                }

                parent::desconectar( $conexion );

                header('Location: ../admin/admin-tareas.php');
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                
                header('Location: ../admin/crear_tareas.php');
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que modifica en la tabla tareas una tarea con los datos correspondientes */
        public static function modificarTarea($titulo, $ruta_documento, $numero_pasos, $pasos, $id_tarea, $numero_pasos_totales) {
            $conexion = parent::conectar();
            $conexion->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

            $sql="UPDATE " . TABLA_TAREAS . " SET titulo = :titulo, ruta_documento = :ruta_documento, numero_pasos = :numero_pasos WHERE id = :id_tarea";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":titulo", $titulo, PDO::PARAM_STR );
                $st->bindValue( ":ruta_documento", $ruta_documento, PDO::PARAM_STR );
                $st->bindValue( ":numero_pasos", $numero_pasos, PDO::PARAM_INT );
                $st->bindValue(":id_tarea", $id_tarea, PDO::PARAM_INT);
                $st->execute();

                // Eliminamos los registros relacionados en la tabla multimedia para eliminar los pasos
                // de la tareasin que de un error debido a la clave externa
                $sql = "DELETE m FROM " . TABLA_MULTIMEDIA . " m JOIN " . TABLA_PASOS . " p ON m.paso_id = p.id
                        WHERE p.tarea_id = :id_tarea";
                $st = $conexion->prepare($sql);
                $st->bindValue(":id_tarea", $id_tarea, PDO::PARAM_INT);
                $st->execute();

                // Borramos los pasos existentes de la tarea
                $sql = "DELETE FROM " . TABLA_PASOS . " WHERE tarea_id = :id_tarea";
                $st = $conexion->prepare($sql);
                $st->bindValue( ":id_tarea", $id_tarea, PDO::PARAM_INT );
                $st->execute();

                // Iteramos a través de los pasos y datos multimedia para insertar los nuevos pasos
                for ($i = 1, $orden = 0; $i <= $numero_pasos_totales; $i++) {

                    if($pasos[$i]["descripcion"] != null){
                        $descripcion = $pasos[$i]["descripcion"];
                        $video = $pasos[$i]["video"];
                        $foto = $pasos[$i]["foto"];
                        $audio = $pasos[$i]["audio"];
                        $orden++;
                        
                        // Insertamos datos de los pasos en la tabla "pasos"
                        $sql = "INSERT INTO " . TABLA_PASOS . "(tarea_id, orden, descripcion) VALUES (?, ?, ?)";
                        $st = $conexion->prepare($sql);
                        $st->execute([$id_tarea, $orden, $descripcion]);
                        $paso_id = $conexion->lastInsertId();
                        
                        // Insertamos datos de multimedia en la tabla "multimedia"
                        $sql = "INSERT INTO " . TABLA_MULTIMEDIA . "(paso_id, audio, foto, video) VALUES (?, ?, ?, ?)";
                        $st = $conexion->prepare($sql);
                        $st->execute([$paso_id, $audio, $foto, $video]);
                    }
                }

                parent::desconectar( $conexion );

                header('Location: ../admin/admin-tareas.php');
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que inserta una relacion entre una tarea y un alumno en la tabla tarea_alumno*/
        public static function asignarTarea($id_tarea, $id_alumno) {
            $conexion = parent::conectar();

            $tareas = new Tareas();

            // Solo si la tarea no ha sido ya asociada al alumno hacemos la inserción en la BD
            if(!$tareas->existeTareaAlumno($id_tarea, $id_alumno)){
                $sql="INSERT INTO " . TABLA_TAREA_ALUMNO . "(tarea_id, alumno_id) VALUES (?, ?)";

                try {
                    $st = $conexion->prepare( $sql );
                    $st->execute([$id_tarea, $id_alumno]);
                    parent::desconectar( $conexion );

                    return true;
                } catch ( PDOException $e ) {
                    parent::desconectar( $conexion );
                    
                    return false;
                }
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que comprueba si existe un alumno con la identificacion pasada y una tarea
        con esa identificacion pasada */
        public function existeTareaAlumno($id_tarea, $id_alumno) {
            $conexion = parent::conectar();
    
            $sql = "SELECT alumno_id FROM " . TABLA_TAREA_ALUMNO . " WHERE tarea_id = :id_tarea AND alumno_id = :id_alumno";
            
            try {
                $st = $conexion->prepare($sql);
                $st->bindValue( ":id_tarea", $id_tarea, PDO::PARAM_INT );
                $st->bindValue( ":id_alumno", $id_alumno, PDO::PARAM_INT );
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );
                
                if($fila) return true;
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );

                return false;
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve un array de todos los alumnos asignados a una tarea */
        public function obtenerAlumnosAsignados($id_tarea) {
            $conexion = parent::conectar();
    
            $sql = "SELECT alumno_id FROM " . TABLA_TAREA_ALUMNO . " WHERE tarea_id = ?";
            
            try {
                $st = $conexion->prepare($sql);
                $st->execute([$id_tarea]);
                $alumnosAsignados = $st->fetchAll(PDO::FETCH_ASSOC);
                parent::desconectar($conexion);
    
                return $alumnosAsignados;
            } catch (PDOException $e) {
                parent::desconectar($conexion);
                return [];
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que elimina todas las asignaciones alummno-tarea de la tarea pasada */
        public function eliminarTareaAlumno($id_tarea) {
            $conexion = parent::conectar();
    
            $sql = "DELETE FROM " . TABLA_TAREA_ALUMNO . " WHERE tarea_id = ?";
    
            try {
                $st = $conexion->prepare($sql);
                $st->execute([$id_tarea]);
                parent::desconectar($conexion);
    
                return true;
            } catch (PDOException $e) {
                parent::desconectar($conexion);
                return false;
            }
        }
        /****************************************************************************************/


        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que elimina todos los alumnos de la base de datos que no se han pasado
        de la tarea correspondiente */
        public function eliminarAlumnosTarea($id_alumnos, $id_tarea) {
            $conexion = parent::conectar();

            foreach ($id_alumnos as $id_alumno) {
                $sql = "DELETE FROM " . TABLA_TAREA_ALUMNO . " WHERE alumno_id != :id_alumno AND tarea_id = :id_tarea";
    
                try {
                    $st = $conexion->prepare($sql);
                    $st->bindValue( ":id_alumno", $id_alumno, PDO::PARAM_INT );
                    $st->bindValue( ":id_tarea", $id_tarea, PDO::PARAM_INT );
                    $st->execute();
                    parent::desconectar($conexion);
        
                    return true;
                } catch (PDOException $e) {
                    parent::desconectar($conexion);
                    return false;
                }
            }
        }
        /****************************************************************************************/
    }
 ?>