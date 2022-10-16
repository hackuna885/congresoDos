<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$usuario = (isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : '';
$pass = (isset($_POST['txtPws'])) ? $_POST['txtPws'] : '';

// Conexion a DB
$con = new SQLite3("../data/data.db");

if ($opcion === 1) {
	if($usuario === '' || $pass === ''){
		echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Llena todos los campos
			</div>
			');
	}else{
	
		$usuarioCript = md5($usuario);
		$passCript = md5($pass);
	
		
		$cs = $con -> query("SELECT * FROM registroUsr WHERE correoMd5 = '$usuarioCript'");
	
		while ($resul = $cs -> fetchArray()) {
			$nombre = $resul['nombreCom'];
			$correo = $resul['correo'];
			$correoMd5 = $resul['correoMd5'];
			$passDecrypt = $resul['passDecrypt'];
			$tipoUsuario = $resul['tipoUsuario'];
			$usrActivo = $resul['usrActivo'];
		}
		
		$correoMd5 = (isset($correoMd5)) ?  $correoMd5 : '';
		$passDecrypt = (isset($passDecrypt)) ?  $passDecrypt : '';
		
		/*VALIDACIÓN DE CORREO*/
	
		if($correoMd5 === $usuarioCript){
	
			/*VALIDACIÓN DE PASSWORD*/
	
			if($passDecrypt === $passCript){
	
				/*VALIDACIÓN DE USUARIO ACTIVO*/
				
				if($usrActivo === '1'){
	
					$_SESSION['nombre'] = $nombre;
					$_SESSION['correo'] = $correo;
					$_SESSION['correoMd5'] = $correoMd5;
					$_SESSION['tipoUsuario'] = $tipoUsuario;
	
					echo json_encode('
					<meta http-equiv="REFRESH" content="0; url=home/inicio.app">
					');
				}else{
					echo json_encode('
					<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
						Tu usuario esta bloqueado o inactivo
					</div>
					');
				}
	
			}else{
				echo json_encode('
				<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
					Contraseña no valida
				</div>
				');
			}
		}else{
			echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Usuario no valido
			</div>
			');
		}
	}
}else{
	echo json_encode('');
}

$con -> close();

 ?>