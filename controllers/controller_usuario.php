<?php
    include_once "../modelo/model_usuario.php";

    //Conectar con el modelo de Usuario
    $usuarios = new Usuario();
    
    //Array asociativo de la tabla Usuario
    $arrayUsuarios = $usuarios->listar();

    //Array asociativo de los deportistas de la BD, usador por el entrenador en a_nuevo_usu.php
    $usuarios = $usuarios->listarUsuarios();
?>