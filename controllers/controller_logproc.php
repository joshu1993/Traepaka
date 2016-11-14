<?php
/* ========================================================================================
Recoge login y password del formulario de login Login.php. Accede a la bd y comprueba si
el login existe, si no existe informa. Despues comprueba si la password coincide, si no coincide informa.
Si el login existe y la password coincide redirige a Menu.php
=========================================================================================== */

//incluimos las funciones de conexion para tener la conexion a la bd
include '../modelo/connect_DB.php';
//Recogemos las variables que vienen por POST desde el formulario
$login= $_POST['login'];
$pass= $_POST['pass'];

//Conectar con la bd
$db = new Database();

$ExisteLogin = 'SELECT * FROM Usuario WHERE dni = \''. $login . '\'';
$ResultadoExisteLogin = $db->consulta($ExisteLogin) or die('No se puede comprobar si existe login');

	if (mysqli_num_rows($ResultadoExisteLogin)==1)
	{
	//si existe el login
	//sacamos la fila de usuario del recordset
	$TuplaLogin = mysqli_fetch_array($ResultadoExisteLogin);
	//comprobamos si el atributo PASSWORD coincide con lo introducido por el usuario como password para ese login


	if ($TuplaLogin['password'] == $pass)
	{
		session_start();
		$_SESSION['login_usuario'] = $login;
		$_SESSION['tipo'] = $TuplaLogin['tipousuario'];
		$_SESSION['idioma'] = $TuplaLogin['idioma'];
        $_SESSION['nombre'] = $TuplaLogin['nombreusuario'];
		 
		//Redirige a su menu correspondiente
		header('Location:../vistas/menu.php');
	}
	else
		//la pass introducida por el usuario no es correcta para ese login
		{
			echo 'Error al introducir la password para ese login';
		}
	}
	//si es incorrecta
	else
	{
	echo 'Error, no existe ese login';

	}

?>
