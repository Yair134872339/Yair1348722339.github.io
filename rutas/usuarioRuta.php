<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['usuario_nombre_guardar']) || isset($_POST['usuario_id_actualizar']) || isset($_POST['usuario_id_eliminar'])){
  /**Instancia al controlador de usuario */
    require_once "../controladores/usuarioControlador.php";
    $controlador_usuario = new usuarioControlador();
    /**guardar un usuario */
    if (isset($_POST['usuario_nombre_guardar']) && isset($_POST['usuario_usuario_guardar'])){
        echo $controlador_usuario->agregar_usuario_controlador();
    } 
    /**actualizar un usuario */
    if (isset($_POST['usuario_id_actualizar'])){
        echo $controlador_usuario->actualizar_usuario_controlador();
    }
    /**eliminar un usuario */
    if (isset($_POST['usuario_id_eliminar'])){
        echo $controlador_usuario->eliminar_usuario_controlador($_POST['usuario_id_eliminar']);
    }
}else{
    session_start(['name'=>'empresa']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}