<!--
===========================================================================
Controlador index vacio
Creado por: Edgard Ruiz  Gonzalez
Fecha: 01/11/2016
============================================================================
-->



<?php
session_start();
if (!(isset($_SESSION['login'])))
	header('location:../vistas/menu.php');
else
	header('location:../vistas/login.php');

?>