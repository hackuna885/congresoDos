<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'info.php';
// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$nCorreo = (isset($_POST['nCorreo'])) ? $_POST['nCorreo'] : '';
$passUsr = (isset($_POST['passUsr'])) ? $_POST['passUsr'] : '';


// Conexion a DB
$con = new SQLite3("../data/data.db");

if ($opcion === 1) {
	if($nCorreo === '' || $passUsr === ''){
		echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Llena todos los campos
			</div>
			');
	}else{
		
		$correoCript = md5($nCorreo);
		$passCript = md5($passUsr);

		
		$cs = $con -> query("SELECT correoMd5,password,usrActivo  FROM registroUsr WHERE correoMd5 = '$correoCript'");
	
		while ($resul = $cs -> fetchArray()) {
			$correoMd5 = $resul['correoMd5'];
			$password = $resul['password'];
			$usrActivo = $resul['usrActivo'];
		}
		
		$correoMd5 = (isset($correoMd5)) ?  $correoMd5 : '';

		if($correoMd5 == ''){

			echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				¡Error! Correo no registrado
			</div>
			');

		}else{

			if($passCript === $password){

				if($usrActivo == 1){
					echo json_encode('correcto');
				}else{
	
					echo json_encode('
					<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
						¡No tenemos tú pago registrado, verifícalo más tarde!
					</div>
					');	
				}
			}else{
				echo json_encode('
					<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
					¡Error! Contraseña no valida
					</div>
					');
			}




		}
	}
}else{
	echo json_encode('');
}

$con -> close();

 ?>