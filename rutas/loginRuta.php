<?php

$peticionRuta = true;

require_once "../config/app.php";

if (isset($_POST['nombre']) && isset($_POST['usuario'])){
    require_once "../controladores/loginControlador.php";
    $controlador_login = new loginControlador();
    echo $controlador_login->cerrar_sesion_controlador();
}else{
    session_start(['name'=>'empresa']);
    session_unset();
    session_destroy();
    header("Location:" .urlServidor."login/");
    exit();
}