<?php 
include_once 'interface.php';

class Anuncio implements iModel {
	
    private $id_anuncio;
    private $fecha;
    private $nombre_Anuncio;
    private $descripcion_Anuncio;
    private $precio;
    
    public function __construct($id_anuncio="" , $fecha="", $nombre_Anuncio="", $descripcion_Anuncio="", $precio="") {
        $this->id_anuncio = $id_anuncio;
        $this->fecha = $fecha;
        $this->nombre_Anuncio = $nombre_Anuncio;
        $this->descripcion_Anuncio = $descripcion_Anuncio;
        $this->precio = $precio;        
    }

    private function getid_anuncio ($pk){
        $db = new Database();

        $query = 'SELECT id_anuncio FROM Anuncio WHERE id_anuncio = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        $result->free();
        $db->desconectar();

        return $id;
    }

    public function getfecha ($pk){
        $db = new Database();
        
        $query = 'SELECT fecha FROM Anuncio WHERE id_anuncio = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $fecha = $row[0];

        $result->free();
        $db->desconectar();
        
        return $fecha;
    }
    
    private function getnombre_Anuncio ($pk){
        $db = new Database();
        
        $query = 'SELECT nombre_Anuncio FROM Anuncio WHERE id_anuncio = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $nombre_Anuncio = $row[0];

        $result->free();
        $db->desconectar();
        
        return $nombre_Anuncio;
    }

    private function getdescripcion_Anuncio ($pk){
        $db = new Database();
        
        $query = 'SELECT descripcion_Anuncio FROM Anuncio WHERE id_anuncio = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $descripcion_Anuncio = $row[0];

        $result->free();
        $db->desconectar();
        
        return $descripcion_Anuncio;
    }
    
    public function getprecio ($pk){
        $db = new Database();
        
        $query = 'SELECT precio FROM Anuncio WHERE id_anuncio = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $precio = $row[0];

        $result->free();
        $db->desconectar();
        
        return $precio;
    }
          
    //Comprueba si existe
    public function exists ($pk) {
        $db = new Database();
        
        //Comprueba si ya existe ese Anuncio
        $consultaAnuncio = 'SELECT * FROM Anuncio WHERE id_anuncio = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaAnuncio) or die('ERROR: No se ha podido ejecutar la consulta de Anuncio');
        
        //Si Row=0 no encontró al Anuncio
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
        
        $sqlAnuncio = $db->consulta("SELECT * FROM Anuncio");
        $arrayAnuncio = array();
        while ($row_Anuncio = mysqli_fetch_assoc($sqlAnuncio))
            $arrayAnuncio[] = $row_Anuncio;
        
        $db->desconectar();
        return $arrayAnuncio;
    }
    
    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre_Anuncio
        $pronombre_Anuncio = $this->getnombre_Anuncio($pk);

        //Obtener contraseña
        $proFecha = $this->getfecha($pk);

        //Obtener el descripcion_Anuncio
        $prodescripcion_Anuncio = $this->getdescripcion_Anuncio($pk);

        //Obtener precio de Anuncio
        $proprecio = $this->getprecio($pk);

        //Crear array asociativo con los datos de la $pk
        $Anuncio = array("id_anuncio"=>$pk, "nombre_Anuncio"=>$pronombre_Anuncio, "fecha"=>$proFecha, "descripcion_Anuncio"=>$prodescripcion_Anuncio,  "precio" => $proprecio);
        
        return $Anuncio;
    }
    
    //Modifica los datos del objeto con la $pk, y lo guarda segun los datos de $objeto anterior
    //No se modifica la pk, que es el login, el id_anuncio en la BD
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);
			
            $oldnombre_Anuncio = $datos['nombre_Anuncio'];
            $newnombre_Anuncio = $objeto->nombre_Anuncio;
		
            if ($oldnombre_Anuncio != $newnombre_Anuncio){
                $sql = 'UPDATE Anuncio SET nombre_Anuncio=\''. $newnombre_Anuncio . '\' WHERE id_anuncio = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el nombre del Anuncio');
            }
		
            $olddescripcion_Anuncio = $datos['descripcion_Anuncio'];
            $newdescripcion_Anuncio = $objeto->descripcion_Anuncio;
		
            if ($olddescripcion_Anuncio != $newdescripcion_Anuncio){
                $sql = 'UPDATE Anuncio SET descripcion_Anuncio=\''. $newdescripcion_Anuncio . '\' WHERE id_anuncio = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar la descripcion del Anuncio');
            }
					
						$oldprecio = $datos['precio'];
            $newprecio = $objeto->precio;
		
            if ($oldprecio != $newprecio){
                $sql = 'UPDATE Anuncio SET precio=\''. $newprecio . '\' WHERE id_anuncio = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el precio del Anuncio');
            }

            $result = true;
        
            $oldFecha = $datos['fecha'];
            $newFecha = $objeto->fecha;

            if (($oldFecha != $newFecha) && ($newFecha != "1993-09-17")){
                 $result = $this->setfecha($oldFecha, $newFecha, $pk);
            }
        
            $db->desconectar();
            return $result;
        }else {
            return false;
        }
    }
    
    //Crea el objeto anterior en la tabla de la bd
        $db = new Database();
        
        if ($objeto->exists($objeto->id_anuncio) == false) 
        {
             //Introduce un nuevo Anuncio en la tabla Anuncio
            $insertaPro = "INSERT INTO Anuncio (id_anuncio, fecha, nombre_Anuncio, descripcion_Anuncio, precio) 
				VALUES ('$objeto->id_anuncio','$objeto->fecha','$objeto->nombre_Anuncio','$objeto->descripcion_Anuncio','$objeto->precio')";
            $db->consulta($insertaPro) or die('ERROR: No se ha podido crear el Anuncio');
            return true;
        } else return false;
        
        $db->desconectar();
    }
    
    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Anuncio WHERE id_anuncio = \'' .  $pk .  '\'') or die('ERROR: No se ha podido eliminar el Anuncio');
			$db->desconectar();
			return result;
    }
}
?>