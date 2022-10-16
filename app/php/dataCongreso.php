<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);
// Conexion a DB
$con = new SQLite3("../data/data.db");
$cs = $con -> query("SELECT * FROM registroUsr");
$datos = array();
$i = 0;
	
	while ($resul = $cs -> fetchArray()) {
		$datos[$i]['id'] = $resul['id'];
		$datos[$i]['nombre'] = $resul['nombre'];
		$datos[$i]['aPaterno'] = $resul['aPaterno'];
		$datos[$i]['aMaterno'] = $resul['aMaterno'];
		$datos[$i]['institucion'] = $resul['institucion'];
		$datos[$i]['rfc'] = $resul['rfc'];
		$datos[$i]['tel'] = $resul['tel'];
		$datos[$i]['correo'] = $resul['correo'];
		$datos[$i]['password'] = $resul['password'];
		$datos[$i]['pago'] = $resul['usrActivo'];
		$i++;

	}

	$datos = (isset($datos) ? $datos : '');		
echo json_encode($datos);

$con -> close();

 ?>