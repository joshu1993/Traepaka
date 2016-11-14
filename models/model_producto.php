<?php 
include_once 'interface.php';

class Producto implements iModel {
	
    private $id_producto;
    private $fecha;
    private $nombre_producto;
    private $descripcion_producto;
    private $precio;
    
    public function __construct($id_producto="" , $fecha="", $nombre_producto="", $descripcion_producto="", $precio="") {
        $this->id_producto = $id_producto;
        $this->fecha = $fecha;
        $this->nombre_producto = $nombre_producto;
        $this->descripcion_producto = $descripcion_producto;
        $this->precio = $precio;        
    }

    private function getid_producto ($pk){
        $db = new Database();

        $query = 'SELECT id_producto FROM Producto WHERE id_producto = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        $result->free();
        $db->desconectar();

        return $id;
    }

    public function getfecha ($pk){
        $db = new Database();
        
        $query = 'SELECT fecha FROM Producto WHERE id_producto = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $fecha = $row[0];

        $result->free();
        $db->desconectar();
        
        return $fecha;
    }
    
    private function getnombre_producto ($pk){
        $db = new Database();
        
        $query = 'SELECT nombre_producto FROM Producto WHERE id_producto = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $nombre_producto = $row[0];

        $result->free();
        $db->desconectar();
        
        return $nombre_producto;
    }

    private function getdescripcion_producto ($pk){
        $db = new Database();
        
        $query = 'SELECT descripcion_producto FROM Producto WHERE id_producto = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $descripcion_producto = $row[0];

        $result->free();
        $db->desconectar();
        
        return $descripcion_producto;
    }
    
    public function getprecio ($pk){
        $db = new Database();
        
        $query = 'SELECT precio FROM Producto WHERE id_producto = \'' . $pk .  '\'';
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
        
        //Comprueba si ya existe ese Producto
        $consultaProducto = 'SELECT * FROM Producto WHERE id_producto = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaProducto) or die('ERROR: No se ha podido ejecutar la consulta de producto');
        
        //Si Row=0 no encontró al Producto
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
        
        $sqlProducto = $db->consulta("SELECT * FROM Producto");
        $arrayProducto = array();
        while ($row_Producto = mysqli_fetch_assoc($sqlProducto))
            $arrayProducto[] = $row_Producto;
        
        $db->desconectar();
        return $arrayProducto;
    }
    
    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre_producto
        $pronombre_producto = $this->getnombre_producto($pk);

        //Obtener contraseña
        $proFecha = $this->getfecha($pk);

        //Obtener el descripcion_producto
        $prodescripcion_producto = $this->getdescripcion_producto($pk);

        //Obtener precio de Producto
        $proprecio = $this->getprecio($pk);

        //Crear array asociativo con los datos de la $pk
        $Producto = array("id_producto"=>$pk, "nombre_producto"=>$pronombre_producto, "fecha"=>$proFecha, "descripcion_producto"=>$prodescripcion_producto,  "precio" => $proprecio);
        
        return $Producto;
    }
    
    //Modifica los datos del objeto con la $pk, y lo guarda segun los datos de $objeto anterior
    //No se modifica la pk, que es el login, el id_producto en la BD
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);
			
            $oldnombre_producto = $datos['nombre_producto'];
            $newnombre_producto = $objeto->nombre_producto;
		
            if ($oldnombre_producto != $newnombre_producto){
                $sql = 'UPDATE Producto SET nombre_producto=\''. $newnombre_producto . '\' WHERE id_producto = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el nombre del producto');
            }
		
            $olddescripcion_producto = $datos['descripcion_producto'];
            $newdescripcion_producto = $objeto->descripcion_producto;
		
            if ($olddescripcion_producto != $newdescripcion_producto){
                $sql = 'UPDATE Producto SET descripcion_producto=\''. $newdescripcion_producto . '\' WHERE id_producto = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar la descripcion del producto');
            }
					
						$oldprecio = $datos['precio'];
            $newprecio = $objeto->precio;
		
            if ($oldprecio != $newprecio){
                $sql = 'UPDATE Producto SET precio=\''. $newprecio . '\' WHERE id_producto = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el precio del producto');
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
        
        if ($objeto->exists($objeto->id_producto) == false) 
        {
             //Introduce un nuevo producto en la tabla Producto
            $insertaPro = "INSERT INTO Producto (id_producto, fecha, nombre_producto, descripcion_producto, precio) 
				VALUES ('$objeto->id_producto','$objeto->fecha','$objeto->nombre_producto','$objeto->descripcion_producto','$objeto->precio')";
            $db->consulta($insertaPro) or die('ERROR: No se ha podido crear el producto');
            return true;
        } else return false;
        
        $db->desconectar();
    }
    
    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Producto WHERE id_producto = \'' .  $pk .  '\'') or die('ERROR: No se ha podido eliminar el producto');
			$db->desconectar();
			return result;
    }
}
?>