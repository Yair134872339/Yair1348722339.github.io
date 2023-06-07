<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['ejemplar_libro_guardar']) || isset($_POST['ejemplar_id_actualizar']) || isset($_POST['ejemplar_id_eliminar'])){
  /**Instancia al controlador de ejemplares */
    require_once "../controladores/ejemplarControlador.php";
    $controlador_ejemplar = new ejemplarControlador();
    
    /**guardar un ejemplares */
    if (isset($_POST['ejemplar_libro_guardar']) && isset($_POST['ejemplar_codigo_guardar'])){
        echo $controlador_ejemplar->agregar_ejemplar_controlador();
    } 
     /**eliminar un ejemplares */
     if (isset($_POST['ejemplar_id_eliminar'])){
        echo $controlador_ejemplar->eliminar_ejemplar_controlador();
    } 
    /**Actualizar un ejemplares */
    if (isset($_POST['ejemplar_id_actualizar'])){
        echo $controlador_ejemplar->actualizar_ejemplar_controlador();
    } 
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
