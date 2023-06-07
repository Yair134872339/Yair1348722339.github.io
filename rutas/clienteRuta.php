<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['cliente_nombre_guardar']) || isset($_POST['cliente_id_actualizar']) || isset($_POST['cliente_id_eliminar'])){
  /**Instancia al controlador de cliente */
    require_once "../controladores/clienteControlador.php";
    $controlador_cliente = new clienteControlador();
    
    /**guardar un cliente */
    if (isset($_POST['cliente_nombre_guardar']) && isset($_POST['cliente_nombre_guardar'])){
        echo $controlador_cliente->agregar_cliente_controlador();
    } 
     /**eliminar un cliente */
     if (isset($_POST['cliente_id_eliminar'])){
        echo $controlador_cliente->eliminar_cliente_controlador();
    } 
    /**Actualizar un cliente */
    if (isset($_POST['cliente_id_actualizar'])){
        echo $controlador_cliente->actualizar_cliente_controlador();
    } 
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
