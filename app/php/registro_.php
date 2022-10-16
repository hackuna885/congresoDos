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

include_once 'info.php';
// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nUsr = (isset($_POST['nUsr'])) ? mb_strtoupper($_POST['nUsr'], 'utf-8') : '';
$aPat = (isset($_POST['aPat'])) ? mb_strtoupper($_POST['aPat'], 'utf-8') : '';
$aMat = (isset($_POST['aMat'])) ? mb_strtoupper($_POST['aMat'], 'utf-8') : '';
$nInst = (isset($_POST['nInst'])) ? mb_strtoupper($_POST['nInst'], 'utf-8') : '';
$rfc = (isset($_POST['rfc'])) ? mb_strtoupper($_POST['rfc'], 'utf-8'): '';
$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
$nCorreo = (isset($_POST['nCorreo'])) ? $_POST['nCorreo'] : '';
$passUsr = (isset($_POST['passUsr'])) ? $_POST['passUsr'] : '';


$nUsr= eliminar_tildes($nUsr);
$aPat= eliminar_tildes($aPat);
$aMat= eliminar_tildes($aMat);
$nInst= eliminar_tildes($nInst);
$rfc= eliminar_tildes($rfc);

// Conexion a DB
$con = new SQLite3("../data/data.db");

if ($opcion === 1) {
	if($nUsr === '' || $aPat === '' || $aMat === '' || $nInst === '' || $rfc === '' || $tel === '' || $nCorreo === '' || $passUsr === ''){
		echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Llena todos los campos
			</div>
			');
	}else{
		
		$rfcCript = md5($rfc);
		$correoCript = md5($nCorreo);
		$passCript = md5($passUsr);

		$nombreComUsr = $nUsr.' '.$aPat.' '.$aMat;
		$userMd5 = md5($nombreComUsr);

		$varNavega = $info["browser"];	
		$varVersio = $info["version"];
		$varSitemaO = $info["os"];
		$fechaCap = date('d-m-Y');
		$horaCap = date('g:i:s a');
		$fechaHoraReg = $fechaCap . ' ' . $horaCap;



		
		$cs = $con -> query("SELECT correoMd5 FROM registroUsr WHERE correoMd5 = '$correoCript'");
	
		while ($resul = $cs -> fetchArray()) {
			$correoMd5 = $resul['correoMd5'];
		}
		
		

				
		$correoMd5 = (isset($correoMd5)) ?  $correoMd5 : '';

		if($correoMd5 === $correoCript){

			echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				¡Error! Correo registrado anteriormente
			</div>
			');

		}else{
			$cs = $con -> query("INSERT INTO registroUsr (nombre,aPaterno,aMaterno,nombreCom,institucion,rfc,tel,userMd5,correo,correoMd5,password,passDecrypt,usrNavega,usrSO,usrVerSO,usrFechaHoraReg,tipoUsuario,usrActivo) VALUES('$nUsr','$aPat','$aMat','$nombreComUsr','$nInst','$rfc','$tel','$userMd5','$nCorreo','$correoCript','$passCript','$passUsr','$varNavega','$varVersio','$varSitemaO','$fechaHoraReg','0','0')");

			// ##################################
			// Inicia enviar correo
			// ##################################

			$csDos = $con -> query("SELECT MAX(id) AS ultimoRegis FROM registroUsr");
	
			while ($resulDos = $csDos -> fetchArray()) {
				$ultimoRegis = $resulDos['ultimoRegis'];

				if ($ultimoRegis > 2600 && $ultimoRegis < 2700) {
					$correoDeEnvio = 'atencioncongreso7@utfv.edu.mx';
				}elseif ($ultimoRegis > 2701 && $ultimoRegis < 2800) {
					$correoDeEnvio = 'atencioncongreso8@utfv.edu.mx';
				}elseif ($ultimoRegis > 2801 && $ultimoRegis < 2900) {
					$correoDeEnvio = 'atencioncongreso9@utfv.edu.mx';
				}elseif ($ultimoRegis > 2901 && $ultimoRegis < 3000) {
					$correoDeEnvio = 'atencioncongreso10@utfv.edu.mx';
				}elseif ($ultimoRegis > 3001 && $ultimoRegis < 3100) {
					$correoDeEnvio = 'atencioncongreso6@utfv.edu.mx';
				}elseif ($ultimoRegis > 3101 && $ultimoRegis < 3200) {
					$correoDeEnvio = 'atencioncongreso5@utfv.edu.mx';
				}elseif ($ultimoRegis > 3201 && $ultimoRegis < 3300) {
					$correoDeEnvio = 'atencioncongreso4@utfv.edu.mx';
				}elseif ($ultimoRegis > 3301 && $ultimoRegis < 3400) {
					$correoDeEnvio = 'atencioncongreso3@utfv.edu.mx';
				}elseif ($ultimoRegis > 3401 && $ultimoRegis < 3500) {
					$correoDeEnvio = 'atencioncongreso2@utfv.edu.mx';
				}elseif ($ultimoRegis > 3501 && $ultimoRegis < 3600) {
					$correoDeEnvio = 'atencioncongreso10@utfv.edu.mx';
				}else{
					$correoDeEnvio = 'atencioncongreso8@utfv.edu.mx';
				}
			}

			
	


			$mail = new PHPMailer(true);

				//Server settings
				// $mail->SMTPDebug = 2;    //Sirve como guía para detectar errores de envió
				$mail->CharSet = 'UTF-8';
		
				$mail->isSMTP();
		
				$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $correoDeEnvio;                     // SMTP username
				$mail->Password   = '@123Atencion2021';                               // SMTP password
				$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 587;                                    // TCP port to connect to
		
				//PARA PHP 5.6 Y POSTERIOR
				$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
		
				//Recipients
				$mail->setFrom($correoDeEnvio, 'XVII CONGRESO INTERNACIONAL');
				$mail->addAddress($nCorreo);     //Correo de Salida
				// $mail->addBCC('oliver.velazquez@corsec.com.mx');
				$mail->addAttachment('video.jpg');  //Archivo Adjunto
		
				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				// $mail->msgHTML(file_get_contents('ejemplo.html'), __DIR__);     //Se envio archivo en HTML pero $mail->Body debe estar desactivado
				$mail->Subject = 'XVII CONGRESO INTERNACIONAL DE ADMINISTRACIÓN Y NEGOCIOS 2021';
				$mail->Body    = '
				<h1>¡Hola '.$nombreComUsr.'!</h1>
				<br>
				<p>
				<b>Felicidades has concluido el Pre-Registro.</b>
				<br>
				<br>
				<table>
					<tr>
						<td><b>Usuario:</b></td>
						<td>'.$nCorreo.'</td>
					</tr>
					<tr>
						<td><b>Password:</b></td>
						<td>'.$passUsr.'</td>
					</tr>
				</table>
				<br>
				<br>
				Recuerda generar tu línea de captura en el portal del Gobierno del Estado:
				<br>
				<a href="https://sfpya.edomexico.gob.mx/recaudacion/">https://sfpya.edomexico.gob.mx/recaudacion/</a>
				<br>
				si tienes dudas de como generar tu línea de captura, te recomendamos ver el siguiente video:
				</p>
				<br>
				<table style="text-align: center;">
					<tr>
						<td>
							<a href="https://youtu.be/eb3uH6P38Do"><img src="video.jpg" alt="Video Tutorial"></a>
							<br>
							<a href="https://youtu.be/eb3uH6P38Do">https://youtu.be/eb3uH6P38Do</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>también puedes descargar el siguiente manual en PDF:</p>
							<a href="https://utfv.net/congreso/manual/fichaPago.pdf">Manual.pdf</a>
						</td>
					</tr>
				</table>
				<br>
				<p>
					Nota: una vez realizado tu pago, nos pondremos en contacto contigo para notificarte que tu usuario esta activo y podrás ingresar a la plataforma de:
					<br>
					<br>
					<a href="">
						XVII CONGRESO INTERNACIONAL DE ADMINISTRACIÓN Y NEGOCIOS 2021
					</a>			

				</p>
				<p>
					<b>Si tienes duda del estatus de tú usuario, puedes verificarlo en siguiente link:</b>
					<br>
					<a href="https://congreso.utfv.net/#/inicio-estatus">https://congreso.utfv.net/#/inicio-estatus</a>
				</p>
				';
		
				$mail->send();


			echo json_encode('correcto');			
		

		// ##################################
		// Termina enviar correo
		// ##################################

		}
	}
}else{
	echo json_encode('');
}

$con -> close();

 ?>