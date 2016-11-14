<?php
session_start();
if (!(isset($_SESSION['login'])))
	header('location:./vistas/traepaka_index.php');
else
	header('location:./vistas/menu.php');
?>


