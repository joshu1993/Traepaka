<?php
session_start();
if (!(isset($_SESSION['login'])))
	header('location:../vistas/index_traepaka.php');
else
	header('location:../vistas/login.php');
?>