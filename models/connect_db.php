<?php

/*===========================================================================================================
Clase de la base de datos, establece la conexion con la base de datos gimnasio usando MySQL improved (mysqli)
Creado por: Edgard Ruiz Gonzalez   
Fecha: 01/11/2016
=============================================================================================================
*/

class Database {

    var $conexion;
    
    public function __construct($host="localhost",$user="admingym",
                                $pass="admingym", $db="gimnasio"){
        $this->conexion = mysqli_connect($host, $user, $pass, $db);
        
        // Check connection
        if (mysqli_connect_errno()){
          echo "Fallo al conectar con la base de datos: " . mysqli_connect_error();
        }
    }
    
    public function consulta($sentencia){
        return mysqli_query($this->conexion,$sentencia);
    }
    
    public function desconectar(){
        $this->conexion->close();
    }
}

?>




