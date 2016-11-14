<?php
    include_once "../modelo/model_producto.php";

    //Conectar con el modelo de Producto
    $productos = new Producto();
    
    //Array asociativo de la tabla Usuario
    $arrayProductos = $Productos->listar();
?>