<?php 
include_once 'interface.php';

class Usuario implements iModel {
	
    private $dni;
    private $password;
    private $nombre_usuario;
    private $correo_usuario;
    private $tipo_usuario;
    private $idioma;
    
    public function __construct($dni="" , $password="", $nombre_usuario="", $correo_usuario="", $tipo_usuario="usuario", $idioma="esp") {
        $this->dni = $dni;
        $this->password = $password;
        $this->nombre_usuario = $nombre_usuario;
        $this->correo_usuario = $correo_usuario;
        $this->tipo_usuario = $tipo_usuario;
        $this->idioma = $idioma;
        
    }

    private function getdni ($pk){
        $db = new Database();

        $query = 'SELECT dni FROM Usuario WHERE dni = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $id = $row[0];

        $result->free();
        $db->desconectar();

        return $id;
    }
    
    private function getnombre_usuario ($pk){
        $db = new Database();
        
        $query = 'SELECT nombre_usuario FROM Usuario WHERE dni = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $nombre_usuario = $row[0];

        $result->free();
        $db->desconectar();
        
        return $nombre_usuario;
    }

    private function getcorreo_usuario ($pk){
        $db = new Database();
        
        $query = 'SELECT correo_usuario FROM Usuario WHERE dni = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $correo_usuario = $row[0];

        $result->free();
        $db->desconectar();
        
        return $correo_usuario;
    }
    
    public function gettipo_usuario ($pk){
        $db = new Database();
        
        $query = 'SELECT tipo_usuario FROM Usuario WHERE dni = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $tipo_usuario = $row[0];

        $result->free();
        $db->desconectar();
        
        return $tipo_usuario;
    }
    
    public function getpassword ($pk){
        $db = new Database();
        
        $query = 'SELECT password FROM Usuario WHERE dni = \'' . $pk .  '\'';
        $result = $db->consulta($query);

        $row = $result->fetch_array(MYSQLI_NUM);
        $pass = $row[0];

        $result->free();
        $db->desconectar();
        
        return $pass;
    }

    //True o false dependiendo de si se cambió de forma correcta
    private function setpassword($oldPass, $newPass, $pk){
        //Comprueba que oldpass no coincida con la de la PK en la bd, si ocurre hace un update con newPass
        $db = new Database();
        $pass = $this->getpassword($pk);

        if(strcmp($oldPass, $pass)!== 0){ return false;}
        //Comprueba que la password nueva no sea cadena vacía en MD5
                else if (strcmp($newPass, "")!== 0){
                $sql = 'UPDATE Usuario SET password=\''. $newPass . '\' WHERE Usuario.dni = \'' . $pk .  '\'' ;
                $db->consulta($sql) or die('ERROR: No se ha podido modificar la contraseña');
                $result = $db->consulta($sql);
                $db->desconectar();

                return $result;
        }else return true;
    }
    
		//Este metodo se llama cada vez que se cambia el idioma en la navBar lateral
		//Método al que se llama en cada cambio de idioma, devuelve true si se hizo de forma correcta
     public function setidioma ($newidioma, $pk){
		$db = new Database();

		$sql = 'UPDATE Usuario SET idioma = \'' .$newidioma. '\' WHERE Usuario.dni = \'' .  $pk .  '\'';

		$resultado = $db->consulta($sql) or die('ERROR: No se ha podido ejecutar la consulta de modificar idioma');
		$db->desconectar();

			return $resultado;
    }
    
    //Comprueba si existe
    public function exists ($pk) {
        $db = new Database();
        
        //Comprueba si ya existe ese usuario
        $consultaUsuario = 'SELECT * FROM Usuario WHERE dni = \'' .  $pk .  '\'';
        $resultado = $db->consulta($consultaUsuario) or die('ERROR: No se ha podido ejecutar la consulta de usuario');
        
        //Si Row=0 no encontró al usuario
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
        
        $sqlUsuario = $db->consulta("SELECT * FROM Usuario");
        $arrayUsuario = array();
        while ($row_usuario = mysqli_fetch_assoc($sqlUsuario))
            $arrayUsuario[] = $row_usuario;
        
        $db->desconectar();
        return $arrayUsuario;
    }
    
    //Devuelve un array asociativo de la tabla de la clase de los usuarios
    public function listarDeportistas(){
        $db = new Database();
        
        $result = $db->consulta("SELECT * FROM Usuario WHERE tipo_usuario='usuario'");
        $arrayUsuarios = array();
        while ($row_usuario = mysqli_fetch_assoc($result))
            $arrayUsuarios[] = $row_usuario;
        
        $db->desconectar();
        return $arrayUsuarios;
    }
    
    //Muestra los datos de la $pk indicada. Devuelve una array asociativo
    public function consultar ($pk){
        //Obtener el nombre_usuario
        $usunombre_usuario = $this->getnombre_usuario($pk);

        //Obtener contraseña
        $usuPass = $this->getpassword($pk);

        //Obtener el correo_usuario
        $usucorreo_usuario = $this->getcorreo_usuario($pk);

        //Obtener tipo_usuario de usuario
        $usutipo_usuario = $this->gettipo_usuario($pk);

        //Crear array asociativo con los datos de la $pk
        $usuario = array("dni"=>$pk, "nombre_usuario"=>$usunombre_usuario, "password"=>$usuPass, "correo_usuario"=>$usucorreo_usuario,  "tipo_usuario" => $tipo_usuario);
        
        return $usuario;
    }
    
    //Modifica los datos del objeto con la $pk, y lo guarda segun los datos de $objeto anterior
    //No se modifica la pk, que es el login, el dni en la BD
    public function modificar ($pk, $objeto) {
        $db = new Database();
        //Guardar los datos del objeto $pk antes de modificar
        if ($this->exists($pk)){
            $datos = $this->consultar($pk);
			
            $oldnombre_usuario = $datos['nombre_usuario'];
            $newnombre_usuario = $objeto->nombre_usuario;
		
            if ($oldnombre_usuario != $newnombre_usuario){
                $sql = 'UPDATE Usuario SET nombre_usuario=\''. $newnombre_usuario . '\' WHERE dni = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el nombre de usuario');
            }
		
            $oldcorreo_usuario = $datos['correo_usuario'];
            $newcorreo_usuario = $objeto->correo_usuario;
		
            if ($oldcorreo_usuario != $newcorreo_usuario){
                $sql = 'UPDATE Usuario SET correo_usuario=\''. $newcorreo_usuario . '\' WHERE dni = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el correo del usuario');
            }
					
						$oldtipo_usuario = $datos['tipo_usuario'];
            $newtipo_usuario = $objeto->tipo_usuario;
		
            if ($oldtipo_usuario != $newtipo_usuario){
                $sql = 'UPDATE Usuario SET tipo_usuario=\''. $newtipo_usuario . '\' WHERE dni = \'' . $pk .  '\'' ;

                $db->consulta($sql) or die('ERROR: No se ha podido modificar el tipo_usuario');
            }

            $result = true;
        
            $oldPass = $datos['password'];
            $newPass = $objeto->password;

            if (($oldPass != $newPass) && ($newPass != "d41d8cd98f00b204e9800998ecf8427e")){
                 $result = $this->setpassword($oldPass, $newPass, $pk);
            }
        
            $db->desconectar();
            return $result;
        }else {
            return false;
        }
    }
    
    //Crea el objeto anterior en la tabla de la bd
        $db = new Database();
        
        if ($objeto->exists($objeto->dni) == false) 
        {
             //Introduce al nuevo usuario en la tabla usuario
            $insertaUsu = "INSERT INTO Usuario (dni, password, nombre_usuario, correo_usuario, tipo_usuario, idioma) 
				VALUES ('$objeto->dni','$objeto->password','$objeto->nombre_usuario','$objeto->correo_usuario','$objeto->tipo_usuario', '$objeto->idioma')";
            $db->consulta($insertaUsu) or die('ERROR: No se ha podido crear el usuario');
            return true;
        } else return false;
        
        $db->desconectar();
    }
    
    //Elimina de la base de datos segun la primary key pasada
    public function eliminar($pk){
			$db = new Database();
			$result = $db->consulta('DELETE FROM Usuario WHERE dni = \'' .  $pk .  '\'') or die('ERROR: No se ha podido eliminar el usuario');
			$db->desconectar();
			return result;
    }
}
?>