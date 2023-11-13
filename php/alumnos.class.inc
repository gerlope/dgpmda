<?php
    require_once ('datos_object.class.inc');

    // Cada instancia de la clase Alumnos se corresponde con una fila/registro de la tabla del mismo nombre
    class Alumnos extends DataObject {

        /****************************************************************************************/
        /****************************************************************************************/
        /* Constructor */
        protected $datos = array(
            "nombre" => "",
            "apellidos" => "",
            "password"=>"",
            "aula"=>"",
            "perfil_visualizacion"=>"",
            "ruta_foto"=>""
        );
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que devuelve el alumno con el id pasado */
        public static function obtenerAlumno($id) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS . " WHERE id = :id";

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
        /* Funcion que devuelve todos los alumnos de la BD */
        public static function obtenerAlumnos( ) {
            $conexion = parent::conectar();
            $sql = "SELECT * FROM " . TABLA_ALUMNOS;

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
        /* Funcion que inserta en la tabla alumnos un alumno con los datos correspondientes */
        public static function insertarAlumno($nombre, $apellidos, $password, $aula, $perfil_visualizacion, $ruta_foto) {
            $conexion = parent::conectar();

            $sql="INSERT INTO " . TABLA_ALUMNOS . "(nombre, apellidos, password, aula, perfil_visualizacion, ruta_foto) VALUES (?, ?, ?, ?, ?, ?)";

            try {
                $st = $conexion->prepare( $sql );
                $st->execute([$nombre, $apellidos, $password, $aula, $perfil_visualizacion, $ruta_foto]);
                $fila = $st->fetch();
                parent::desconectar( $conexion );

                header('Location: ../admin/admin-tareas.php');
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                
                header('Location: ../admin/alta_alumnos.php');
            }
        }
        /****************************************************************************************/

        /****************************************************************************************/
        /****************************************************************************************/
        /* Funcion que modifica en la tabla alumnos un alumno con los datos correspondientes */
        public static function modificarAlumno($nombre, $apellidos, $aula, $perfil_visualizacion, $password, $ruta_foto, $id_alumno) {
            $conexion = parent::conectar();
            $conexion->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

            $sql="UPDATE " . TABLA_ALUMNOS . " SET nombre = :nombre, apellidos = :apellidos, aula = :aula, perfil_visualizacion = :perfil_visualizacion, password = :password, ruta_foto = :ruta_foto WHERE id = :id_alumno";

            try {
                $st = $conexion->prepare( $sql );
                $st->bindValue( ":nombre", $nombre, PDO::PARAM_STR );
                $st->bindValue( ":apellidos", $apellidos, PDO::PARAM_STR );
                $st->bindValue( ":aula", $aula, PDO::PARAM_STR );
                $st->bindValue( ":perfil_visualizacion", $perfil_visualizacion, PDO::PARAM_STR );
                $st->bindValue( ":password", $password, PDO::PARAM_STR );
                $st->bindValue( ":ruta_foto", $ruta_foto, PDO::PARAM_STR );
                $st->bindValue(":id_alumno", $id_alumno, PDO::PARAM_STR);
                $st->execute();
                $fila = $st->fetch();
                parent::desconectar( $conexion );

                header('Location: ../admin/admin-tareas.php');
            } catch ( PDOException $e ) {
                parent::desconectar( $conexion );
                die( "Consulta fallada: " . $e->getMessage() );
            }
        }
        /****************************************************************************************/
    }
 ?>