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