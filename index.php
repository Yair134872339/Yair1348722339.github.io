<?php

require_once "./config/app.php";
require_once "./controladores/vistaControlador.php";

$plantilla = new vistaControlador();
$plantilla->obtener_plantilla_controlador();

?>
