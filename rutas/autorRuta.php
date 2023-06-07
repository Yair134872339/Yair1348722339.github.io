<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['autor_nombre_guardar']) || isset($_POST['autor_id_actualizar']) || isset($_POST['autor_id_eliminar'])){
  /**Instancia al controlador de autor */
    require_once "../controladores/autorControlador.php";
    $controlador_autor = new autorControlador();
    
    /**guardar un autor */
    if (isset($_POST['autor_nombre_guardar']) && isset($_POST['autor_nombre_guardar'])){
        echo $controlador_autor->agregar_autor_controlador();
    } 
     /**eliminar un autor */
     if (isset($_POST['autor_id_eliminar'])){
        echo $controlador_autor->eliminar_autor_controlador();
    } 
    /**Actualizar un autor */
  
   if (isset($_POST['autor_id_actualizar'])){
    echo $controlador_autor->actualizar_autor_controlador();
}
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
