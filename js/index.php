<?php
session_start();
if (!(isset($_SESSION['login'])))
	header('location:../vistas/menu.php');
else
	header('location:../vistas/login.php');

?>