<?php
session_start();	

//Si es el usuario test, redirige a la pagina de tests
if($_SESSION['login_usuario'] == 'test'){
    header('Location: ../pruebas.html');
}else 
//Sino redirige a la pagina principal segun el tipo de usuario
if (isset($_SESSION['tipo'])){
	switch ($_SESSION['tipo'])
	{
		case 'admin':
			header('Location: admin_menu.php');
			break;
		case 'usuario':
			header('Location: usuario_menu.php');
			break;
		//En el caso de ser null significa que es un usuario
		case 'deportista':
			header('Location: usuario_menu.php');
			break;
		default:
			header('Location: login.php');
			break;
	}
}else {
	header('Location: login.php');
}

?>