<!--
===========================================================================
Funcion que se llama en cada vista, para controlar si ese usuario tiene permisos para acceder a dicha pagina.
Tambien hace un include de las cabeceras (css) y el footer (js) que necesitan todas las paginas para no repetir codigo, y si el usuario tiene los permisos correctos devuelve la ruta relativa para importar el idioma del usuario.

Ya que es una funcion, tiene su propio scope y por eso el include de los idiomas directamente hecho dentro de la funcion no sirve/funciona. Las vistas no pueden acceder a las variables, por eso solo se pasa la ruta, y es la propia vista la que realiza el include.

Creado por: Edgard Ruiz Gonzalez
Fecha: 01/11/2016
============================================================================
-->

<?php
/*La vista en concreto le pasa por parámetro el tipo de usuario que debe estar permitido, y la ruta necesaria para retroceder a la "raiz" de nuestro proyecto (por ej. ../)*/
function permisos ($tipo, $ruta){
	session_start();
	
	//Si no hay una sesion iniciada, redirige al login
	if(!$_SESSION){
		header('Location:' .$ruta. 'vistas/login.php');
	}
	//Si que hay sesion
	else{
		//Si no existe la variable de sesion del usuario logueado, redirige al login
		if (!isset($_SESSION["tipo"])){
			header('Location:' .$ruta. 'vistas/login.php');
		}
        //Si el usuario logueado no es el usuario de prueba y
		//tampoco no es el tipo permitido, redirige a su menu principal
		else if (($_SESSION["tipo"] != $tipo) && ($_SESSION["login_usuario"] != 'test')){
			header('location:' .$ruta. 'vistas/menu.php');
		}
		//Si el usuario logueado es el permitido
		else {
			include_once '' .$ruta. 'vistas/header.php';
			include_once '' .$ruta. 'vistas/footer.php';
			
			//Escoge el idioma por defecto si no tiene uno el usuario
			if(!$_SESSION["idioma"]){
				$includeIdioma = $ruta."modelo/esp.php";	
				return $includeIdioma;
			}
			/*Si el usuario tiene definido un idioma, cambia el idioma de la pagina, devolviendo la direccion del archivo a importar*/
			else{
				$includeIdioma = $ruta."modelo/".$_SESSION['idioma'].".php";	
				return $includeIdioma;
			};
		}
    }
}

?>