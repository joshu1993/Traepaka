<?php
include_once 'interface.php';

class Tabla implements iModel  {

    private $idtabla;
    private $nombretabla;
    private $niveldificultad;

    public function __construct($idtabla="" , $nombretabla="", $niveldificultad="") {

		$this->idtabla = $idtabla;
        $this->nombretabla = $nombretabla;
        $this->niveldificultad = $niveldificultad;
    }

		/*-------------------------- GET DE CADA ATRIBUTO ----------------------------------------*/


		/* FALTAN LOS GETTERS DE LOS IDS*/
		private function getitabla ($pk){
        $db = new Database();

        $query = 'SELECT idtabla FROM Tabla WHERE idtabla = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        /* array numérico */
        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        /* liberar la serie de resultados */
        $result->free();
        $db->desconectar();

        return $id;
    }

		private function getnombretabla ($pk){
        $db = new Database();

        $query = 'SELECT nombretabla FROM Tabla WHERE idtabla = \'' . $pk .  '\''; 
        $result = $db->consulta($query);

        /* array numérico */
        $row = $result->fetch_array(MYSQLI_NUM);
        $nombretabla = $row[0];

        /* liberar la serie de resultados */
        $result->free();
        $db->desconectar();

        return $nombretabla;
    }

    private function getniveldificultad ($pk){
        $db = new Database();

        $query = 'SELECT niveldificultad FROM Tabla WHERE idtabla = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        /* array numérico */
        $row = $result->fetch_array(MYSQLI_NUM);
        $niveldificultad = $row[0];

        /* liberar la serie de resultados */
        $result->free();
        $db->desconectar();

        return $niveldificultad;
    }


    //Comprueba si existe la tabla
     //Comprueba si existe
    public function exists ($pk) {
        $db = new Database();
        
        //Comprueba si ya existe la actividad
        $consultaActividad = 'SELECT * FROM Tabla WHERE idtabla = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaActividad) or die('Error al ejecutar la consulta de tabla');
        
        // Si el numero de filas es 0 significa que no encontro el usuario
        if (mysqli_num_rows($resultado) == 0){
            $db->desconectar();
            return false;
        } else {
            $db->desconectar();
            return true;
        }
    }

    //Devuelve un array asociativo de la tabla de la clase
    public function listar(){
        $db = new Database();

        $sqlTabla = $db->consulta("SELECT * FROM Tabla");
        $arrayTabla = array();
        while ($row_tabla = mysqli_fetch_assoc($sqlTabla))
            $arrayTabla[] = $row_tabla;

        $db->desconectar();
        return $arrayTabla;
    }

    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre actividad
        $actnombretabla = $this->getnombretabla($pk);
        //Obtener la hora de inicio
        $actniveldificultad = $this->getniveldificultad($pk);
		

        //Crear array asoc con los datos de $pk
        $tabla = array("idtabla"=>$pk, "nombretabla"=>$actnombretabla, "niveldificultad"=>$actniveldificultad);

        return $tabla;
    }

    //Modifica los datos del objeto con $pk, y lo guarda segun los datos de $objeto pasado
    //No se modifica la primary key, que es la id de actividad
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);

            $oldnombretabla = $datos['nombretabla'];
            $newnombretabla = $objeto->nombretabla;

            if ($oldnombretabla != $newnombretabla){
                $sql = 'UPDATE Tabla SET nombretabla=\''. $newnombretabla . '\' WHERE idtabla = \'' . $pk . '\'';

                $db->consulta($sql) or die('Error al modificar el nombretabla');
            }

            $oldniveldificultad = $datos['niveldificultad'];
            $newniveldificultad = $objeto->niveldificultad;

            if ($oldniveldificultad != $newniveldificultad){
                $sql = 'UPDATE Tabla SET niveldificultad=\''. $newniveldificultad . '\' WHERE idtabla = \'' . $pk . '\'';

                $db->consulta($sql) or die('Error al modificar el nivel de dificultad');
            }

						

						$result = true;

            $db->desconectar();
            return $result;
        }else {
            return false;
        }
    }

    //Crea el objeto pasado en la tabla de la base de datos, si devuelve fue bien devuelve true
    public function crear($objeto){
        $db = new Database();

        if ($objeto->exists($objeto->idtabla) == false)
        {
             //Inserta la tabla en la tabla tabla
            $insertaTabla = "INSERT INTO Tabla (idtabla, nombretabla, niveldificultad)
				VALUES ('$objeto->idtabla','$objeto->nombretabla','$objeto->niveldificultad')";
            $db->consulta($insertaTabla) or die('Error al crear la actividad');
            return true;
        } else return false;

        $db->desconectar();
    }


    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Tabla WHERE idtabla = \'' .  $pk .  '\'') or die('Error al eliminar la tabla');
			$db->desconectar();
			return result;
    }


}

?>
