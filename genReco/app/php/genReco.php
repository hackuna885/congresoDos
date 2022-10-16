<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$idCorreoMd5 = (isset($_GET['id'])) ? $_GET['id'] : '';

if ($idCorreoMd5 != '') {
    // Conexion a DB
    $con = new SQLite3("../data/data.db");
    $cs = $con -> query("SELECT nombreCom FROM registroUsr WHERE correoMd5 = '$idCorreoMd5'");
	
		while ($resul = $cs -> fetchArray()) {
			$nombre = $resul['nombreCom'];
		}

        $nombre = isset($nombre) ? $nombre : '';
        if ($nombre != '') {

            $dompdf = new Dompdf();
            ob_start();
            include "./plantilla.php";
            $html = ob_get_clean();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', 'landscape');
            $dompdf->render();
            $dompdf->stream('reconocimiento');
            // $contenido = $dompdf->output();
            // $rutaGuardado = "forms/";
            // $nombreDelDocumento = $nombreArch;
            // $bytes = file_put_contents($rutaGuardado.$nombreDelDocumento, $contenido);

        }else{
            echo '<script>alert("Error de Usuario")</script>';
        }
    
}else{
    echo '<script>alert("Usuario no encontrado")</script>';
}



?>