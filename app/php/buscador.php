<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$txtBuscador = (isset($_POST['txtBuscador'])) ? $_POST['txtBuscador'] : '';

// Conexion a DB
$con = new SQLite3("../data/data.db") or die("Problemas para conectar");

// Opciones del CRUD
switch ($opcion) {
    // Insertar
    case 1 :
        
        break;
    // Leer
    case 4 :
        $cs = $con -> query("SELECT * FROM vEmpledosComodin WHERE comodin LIKE '%$txtBuscador%'");
        $datos = array();
        $i = 0;

        while ($resul = $cs -> fetchArray()) {
            $datos[$i]['id'] = $resul['id'];
            $datos[$i]['comodin'] = $resul['comodin'];
            $datos[$i]['numEmpleado'] = $resul['numEmpleado'];
            $datos[$i]['clv'] = $resul['clv'];
            $datos[$i]['nombreCompleto'] = $resul['nombreCompleto'];
            $datos[$i]['depto'] = $resul['depto'];
            $datos[$i]['area'] = $resul['area'];
            $datos[$i]['numPuesto'] = $resul['numPuesto'];
            $datos[$i]['puesto'] = $resul['puesto'];
            $datos[$i]['sexo'] = $resul['sexo'];
            $datos[$i]['fechaAlta'] = $resul['fechaAlta'];
            $datos[$i]['tel'] = $resul['tel'];
            $datos[$i]['telDos'] = $resul['telDos'];
            $datos[$i]['correo'] = $resul['correo'];
            $datos[$i]['correoDos'] = $resul['correoDos'];
            $datos[$i]['clasidicacion'] = $resul['clasidicacion'];
            $datos[$i]['estatus'] = $resul['estatus'];
            $datos[$i]['cumplenos'] = $resul['cumplenos'];
            $datos[$i]['numEmpleadoReal'] = $resul['numEmpleadoReal'];
            $i++;
        
        }

        break;
}

$datos = (isset($datos) ? $datos : '');
echo json_encode($datos);

$con -> close();


?>