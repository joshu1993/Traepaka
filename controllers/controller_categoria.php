<?php
    include_once "../modelo/model_categoria.php";

    //Conectar con el modelo de Usuario
    $categorias = new Categoria();
    
    //Array asociativo de la tabla Usuario
    $arrayCategorias = $categorias->listar();
?>