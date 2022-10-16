<?php
$nombre = (isset($nombre)) ? mb_strtoupper($nombre, 'utf-8') : '';
?>
<html>
    <head>
        <title>XVII Congreso Nacional de Administración y Negocios 2021</title>
    </head>
    <style>
        @page { margin: 0px; }
        html {
            height: 100%;
        }
        body {
            font-family: sans-serif;
            font-size: 10pt;
            margin: 0px;
        }
        div.cert {
            width: 1053px;
            /* width: 1122px; */
            position: absolute;
            top: 0;
            left: 0;
        }
        div.cert img {
            width: 100%;            
        }
        .nombre{
            position: absolute;
            width: 900px;
            height: 30px;
            margin-top: 430px;
            margin-left: 105px;
            text-align: center;
            /* background-color: rgba(255, 0, 0, 0.5); */
        }
        .infoReco1{
            position: absolute;
            width: 900px;
            height: 45px;
            margin-top: 470px;
            /* margin-left: 166px; */
            margin-left: 105px;
            text-align: center;
            /* background-color: rgba(255, 0, 0, 0.5); */
        }
        .firma{
            position: absolute;
            width: 190px;
            height: 153px;
            margin-top: 510px;
            margin-left: 126px;
            text-align: center;
            z-index: 0;
        }
        .infoReco2{
            position: absolute;
            width: 800px;
            height: 48px;
            margin-top: 600px;
            margin-left: 161px;
            text-align: center;
        }
        .infoReco3{
            position: absolute;
            width: 800px;
            height: 15px;
            margin-top: 648px;
            margin-left: 161px;
            text-align: right;
        }
    </style>
    <body>
        <div class="cert">
            <h1 class="nombre">
                <?php echo $nombre;?>
            </h1>
            <div class="infoReco1">
                Por su participación de los días 8, 9 y 10 de Octubre del 2021
                <br>
                Ciudad Nicolas Romero Estado de México, a 10 de Octubre del 2021
                <br>
                ¨El mundo Empresarial Ante los Retos de la Pandemia y la Nueva Normalidad¨
            </div>
            <div class="infoReco3">
                
            </div>
            <img src="../../img/reco.jpg">
        </div>
    </body>
</html>