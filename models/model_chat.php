<?php 
include_once 'interface.php';

class Chat implements iModel {
	
    private $id_chat;
    private $fecha;
    private $nombre_chat;
    private $mensaje;
    
    public function __construct($id_chat="" , $fecha="", $nombre_chat="", $mensaje="") {
        $this->id_chat = $id_chat;
        $this->fecha = $fecha;
        $this->nombre_chat = $nombre_chat;
        $this->mensaje = $mensaje;       
    }

    private function getid_chat ($pk){
        $db = new Database();

        $query = 'SELECT id_chat FROM Chat WHERE id_chat = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        $result->free();
        $db->desconectar();

        return $id;
    }

    public function getfecha ($pk){
        $db = new Database();
        
        $query = 'SELECT fecha FROM Chat WHERE id_chat = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $fecha = $row[0];

        $result->free();
        $db->desconectar();
        
        return $fecha;
    }
    
    private function getnombre_chat ($pk){
        $db = new Database();
        
        $query = 'SELECT nombre_chat FROM Chat WHERE id_chat = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $nombre_chat = $row[0];

        $result->free();
        $db->desconectar();
        
        return $nombre_chat;
    }

    private function getmensaje ($pk){
        $db = new Database();
        
        $query = 'SELECT mensaje FROM Chat WHERE id_chat = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $mensaje = $row[0];

        $result->free();
        $db->desconectar();
        
        return $mensaje;
    }
          
    //Comprueba si existe
    public function exists ($pk) {
        $db = new Database();
        
        //Comprueba si ya existe ese chat
        $consultaChat = 'SELECT * FROM Chat WHERE id_chat = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaChat) or die('ERROR: No se ha podido ejecutar la consulta de chat');
        
        //Si Row=0 no encontró al chat
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
        
        $sqlChat = $db->consulta("SELECT * FROM Chat");
        $arrayChat = array();
        while ($row_Chat = mysqli_fetch_assoc($sqlChat))
            $arrayChat[] = $row_Chat;
        
        $db->desconectar();
        return $arrayChat;
    }
    
    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre_chat
        $chtnombre_chat = $this->getnombre_chat($pk);

        //Obtener contraseña
        $chtFecha = $this->getfecha($pk);

        //Obtener el mensaje
        $chtmensaje = $this->getmensaje($pk);

        //Obtener precio de Chat
        $chtprecio = $this->getprecio($pk);

        //Crear array asociativo con los datos de la $pk
        $Chat = array("id_chat"=>$pk, "nombre_chat"=>$pronombre_chat, "fecha"=>$proFecha, "mensaje"=>$promensaje);
        
        return $Chat;
    }
    
    //Modifica los datos del objeto con la $pk, y lo guarda segun los datos de $objeto anterior
    //No se modifica la pk, que es el login, el id_chat en la BD
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);
			
            $oldnombre_chat = $datos['nombre_chat'];
            $newnombre_chat = $objeto->nombre_chat;
		
            if ($oldnombre_chat != $newnombre_chat){
                $sql = 'UPDATE Chat SET nombre_chat=\''. $newnombre_chat . '\' WHERE id_chat = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el nombre del Chat');
            }
		
            $oldmensaje = $datos['mensaje'];
            $newmensaje = $objeto->mensaje;
		
            if ($oldmensaje != $newmensaje){
                $sql = 'UPDATE Chat SET mensaje=\''. $newmensaje . '\' WHERE id_chat = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar la descripcion del Chat');
            }
					
						$oldprecio = $datos['precio'];
            $newprecio = $objeto->precio;
		
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
        
        if ($objeto->exists($objeto->id_chat) == false) 
        {
             //Introduce un nuevo chat en la tabla Chat
            $insertaCht = "INSERT INTO Chat (id_chat, fecha, nombre_chat, mensaje) 
				VALUES ('$objeto->id_chat','$objeto->fecha','$objeto->nombre_chat','$objeto->mensaje')";
            $db->consulta($insertaCht) or die('ERROR: No se ha podido crear el chat');
            return true;
        } else return false;
        
        $db->desconectar();
    }
    
    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Chat WHERE id_chat = \'' .  $pk .  '\'') or die('ERROR: No se ha podido eliminar el chat');
			$db->desconectar();
			return result;
    }
}
?>