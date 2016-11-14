<?php
session_start();

//Si no hay una sesion iniciada, redirige al login
if(!$_SESSION){
	header('Location: login.php');
}
//Si que hay sesion
else{
	//Si no existe la variable de sesion del usuario logueado, redirige al login
	if (!isset($_SESSION["tipo"])){
		header('Location: login.php');
	}else {
		//Si el usuario logueado
		//Escoge el idioma por defecto si no tiene uno el usuario
		if(!$_SESSION["idioma"]){
			include_once '../modelo/esp.php';
		}
		//Si el usuario si que tiene definido un idioma cambia la pagina.
		else{
			include_once '../modelo/'.$_SESSION["idioma"].'.php';
		}

		include_once('../controladores/ctrl_usuario.php');
		//Obtiene el nombre del usuario a modificar de la URL
		if(isset($_SESSION["login_usuario"])){
				$usuario = $_SESSION["login_usuario"];
				//Obtiene los datos del usuario en un array asociativo
				$u = new Usuario();
				$usu = $u->consultar($usuario);
		}
	}
}
?>


<html>
<head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Mobile first -->
        
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        <link rel="stylesheet" type="text/css" href="../css/login.css"/>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<title>perfil</title>
</head>
	<?php include_once 'header.php'; ?>
	<body class="left-sidebar">
		<!-- Wrapper -->
			<div id="wrapper">
			<!-- Include de la barra lateral -->
			<?php	include_once 'nav.php';?>
				<!-- Contenido -->
					<div id="content">
						<div class="inner">
							<!--INICIO SECCIÓN-->
									<header><h1 id="logo"><a><?php echo $idioma['perfil']; ?></a></h1></header>
										<!--INICIO TABLA-->
										<form id='FormModificar_Usuario' name="perfil" action='../controladores/ctrl_mod_perfil.php' method='post' >
													<table class='default'>
														<tr> 
																<td>Login:</td> 
																<td><input type='text' disabled class='text' value='<?php echo $usu['idUsuario']; ?>' / name='login'></td>
															<input type='hidden' class='text' value='<?php echo $usu['idUsuario']; ?>' / name='login'>
														</tr>
														<tr>
															<td><?php echo $idioma['perfil_correo']; ?></td>
															<td><input type='email' class='text' value="<?php echo $usu['email']; ?>" / name='email' required></td>	
														</tr>
														<tr>
															<td><?php echo $idioma['perfil_nombre']; ?></td>
																<td><input type='text' class='text' value="<?php echo $usu['nombre']; ?>"/ name='nombre' required></td>
														</tr>
														<tr>
															<td><?php echo $idioma['perfil_contrasena']; ?></td>
															<td><input type='password' required/ name='Password_Usuario' id='Password_Usuario'></td>						
														</tr>
													</table>
												<table class='alternative'>
													<tr>
														<td width='30%'></td>
														<td width='10%' colspan='4'><input type='submit' onclick="cifrar()" name='accion' value='<?php echo $idioma['guardar']; ?>'></a></td>
								<td width='25%'></td>
													</tr>
												</table>
											</form>
						</div>
										<!-- FIN TABLA -->
						</div>
				</div>
			</div>
	</body>

	<script src="../js/md5.js" type="text/javascript"></script> 
    <script>
        function cifrar(){
            var input_pass = document.getElementById("Password_Usuario");
            input_pass.value = hex_md5(input_pass.value);
        }
    </script>
<?php include_once 'footer.php'; ?>
</html>