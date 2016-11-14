<?php
include_once '../modelo/model_usuario.php';

session_start();

$usu = new Usuario();
$idUsu = $_SESSION['login_usuario'];

if($usu->setIdioma('eng', $idUsu)){
	$_SESSION["idioma"] = 'eng';
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>