<?php 
include_once 'interface.php';

class Categoria implements iModel {
	
    private $id_categoria;
    private $nombre_categoria;

    public function __construct($id_categoria="" , $nombre_categoria="") {
        $this->id_categoria = $id_categoria;
        $this->nombre_categoria = $nombre_categoria;
    }

    private function getid_categoria ($pk){
        $db = new Database();

        $query = 'SELECT id_categoria FROM Categoria WHERE id_categoria = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        $result->free();
        $db->desconectar();

        return $id;
    }
    
    private function getnombre_categoria ($pk){
        $db = new Database();
        
        $query = 'SELECT nombre_categoria FROM Categoria WHERE id_categoria = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $nombre_categoria = $row[0];

        $result->free();
        $db->desconectar();
        
        return $nombre_categoria;
    }

          
    //Comprueba si existe
    public function exists ($pk) {
        $db = new Database();
        
        //Comprueba si ya existe ese categoria
        $consultaCategoria = 'SELECT * FROM Categoria WHERE id_categoria = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaCategoria) or die('ERROR: No se ha podido ejecutar la consulta de categoria');
        
        //Si Row=0 no encontró al categoria
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
        
        $sqlCategoria = $db->consulta("SELECT * FROM Categoria");
        $arrayCategoria = array();
        while ($row_Categoria = mysqli_fetch_assoc($sqlCategoria))
            $arrayCategoria[] = $row_Categoria;
        
        $db->desconectar();
        return $arrayCategoria;
    }
    
    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre_categoria
        $catnombre_categoria = $this->getnombre_categoria($pk);

        //Crear array asociativo con los datos de la $pk
        $Categoria = array("id_categoria"=>$pk, "nombre_categoria"=>$catnombre_categoria);
        
        return $Categoria;
    }
    
    //Modifica los datos del objeto con la $pk, y lo guarda segun los datos de $objeto anterior
    //No se modifica la pk, que es el login, el id_categoria en la BD
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);
			
            $oldnombre_categoria = $datos['nombre_categoria'];
            $newnombre_categoria = $objeto->nombre_categoria;
		
            if ($oldnombre_categoria != $newnombre_categoria){
                $sql = 'UPDATE Categoria SET nombre_categoria=\''. $newnombre_categoria . '\' WHERE id_categoria = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el nombre del Categoria');
            }
		
            
            $result = true;      
            $db->desconectar();
            return $result;
        }else {
            return false;
        }
    }
    
    //Crea el objeto anterior en la tabla de la bd
        $db = new Database();
        
        if ($objeto->exists($objeto->id_categoria) == false) 
        {
             //Introduce un nuevo Categoria en la tabla Categoria
            $insertaCat = "INSERT INTO Categoria (id_categoria, nombre_categoria) 
				VALUES ('$objeto->id_categoria', '$objeto->nombre_categoria')";
            $db->consulta($insertaCat) or die('ERROR: No se ha podido crear la categoria');
            return true;
        } else return false;
        
        $db->desconectar();
    }
    
    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Categoria WHERE id_categoria = \'' .  $pk .  '\'') or die('ERROR: No se ha podido eliminar la categoria');
			$db->desconectar();
			return result;
    }
}
?>