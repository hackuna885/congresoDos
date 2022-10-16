<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';


// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$correoUrl = (isset($_POST['correoUrl'])) ? $_POST['correoUrl'] : '';
$passUsr = (isset($_POST['passUsr'])) ? $_POST['passUsr'] : '';


// Conexion a DB
$con = new SQLite3("../data/data.db");

if ($opcion === 1) {
	if($correoUrl === '' || $passUsr === ''){
		echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Llena todos los campos
			</div>
			');
	}else{
		$correoUrl = preg_replace('([^A-Za-z0-9])', '', $correoUrl);
		$criptPass = md5($passUsr);
		
		$cs = $con -> query("SELECT * FROM registroUsr WHERE correoMd5 = '$correoUrl'");
	
		while ($resul = $cs -> fetchArray()) {
			$nombre = $resul['nombre'];
			$correo = $resul['correo'];
			$correoMd5 = $resul['correoMd5'];
		}
		
		$correoMd5 = (isset($correoMd5)) ?  $correoMd5 : '';

		if($correoMd5 === $correoUrl){
			$cs = $con -> query("UPDATE registroUsr SET password = '$passUsr', passDecrypt = '$criptPass'  WHERE correoMd5 = '$correoUrl'");

			// ##################################
			// Inicia enviar correo
			// ##################################


			$mail = new PHPMailer(true);

			try {
				//Server settings
				// $mail->SMTPDebug = 2;    //Sirve como guía para detectar errores de envió
				$mail->CharSet = 'UTF-8';
		
				$mail->isSMTP();
		
				$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'infocorreosmtp@gmail.com';                     // SMTP username
				$mail->Password   = '123Sistemas2021';                               // SMTP password
				$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 587;                                    // TCP port to connect to
		
				//PARA PHP 5.6 Y POSTERIOR
				$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
		
				//Recipients
				$mail->setFrom('infocorreosmtp@gmail.com', 'Info Correo');
				$mail->addAddress($correo);     //Correo de Salida
				// $mail->addBCC('oliver.velazquez@corsec.com.mx');
				// $mail->addAttachment('logoCorsec.png');  //Archivo Adjunto
		
				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				// $mail->msgHTML(file_get_contents('ejemplo.html'), __DIR__);     //Se envio archivo en HTML pero $mail->Body debe estar desactivado
				$mail->Subject = 'Cambio de contraseña - Universidad Tecnológica Fidel Velázquez';
				$mail->Body    = '
				<h1>¡Hola '.$nombre.'!</h1>
				<br>
				<p>Contraseña restablecida, exitosamente.</p>
				<br>
				<p>Tu nueva contraseña es: <b>'.$passUsr.'</b></p>
				';
		
				$mail->send();
				echo json_encode('correcto');
			} catch (Exception $e) {
				$errorMSg = "No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
				echo json_encode($errorMSg);
			}
		

			// ##################################
			// Termina enviar correo
			// ##################################			

		}else{

			echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				¡Error! Correo no registrado.
			</div>
			');

		}
	}
}else{
	echo json_encode('');
}

$con -> close();

 ?>