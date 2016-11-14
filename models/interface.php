<!--
===========================================================================
Interfaz del modelo de proyecto. Son las funciones que todos implementan
Como no todos necesitan los mismos parametros, las clases con pk compuestas no hacen implements de iModel, pero tienen estas clases igualmente
============================================================================
-->

<?php
include_once 'connect_DB.php';

//Interfaz del modelo => funciones que las clases deben implementar
interface iModel {
    //Comprueba si existe, devuelve true si existe, o false si no
    public function exists ($pk);
    //Devuelve un array asociativo de la tabla de la clase
    public function listar();
    /*Devuelve un array asociativo de $pk con sus datos.
		Los atributos se llaman igual que en la clase del modelo*/
    public function consultar ($pk);
    //Modifica los datos del objeto con $pk, y lo guarda segun los datos de $objecto pasado
    //Devuelve true si modifico correctamente
    public function modificar ($pk, $objeto);
    //Crea el objeto pasado en la tabla de la base de datos
    //Devuelve true si creo correctamente
    public function crear($objeto); 
    //Elimina de la base de datos segun la primary key pasada
    //Devuelve true si elimino correctamente
    public function eliminar($pk); 
}

?>