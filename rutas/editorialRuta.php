<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['editorial_codigo_guardar']) || isset($_POST['editorial_id_actualizar']) || isset($_POST['editorial_id_eliminar'])){
  /**Instancia al controlador de editorial */
    require_once "../controladores/editorialControlador.php";
    $controlador_editorial = new editorialControlador();
    
    /**guardar un editorial */
    if (isset($_POST['editorial_nombre_guardar']) && isset($_POST['editorial_nombre_guardar'])){
        echo $controlador_editorial->agregar_editorial_controlador();
    } 
     /**eliminar un editorial */
     if (isset($_POST['editorial_id_eliminar'])){
        echo $controlador_editorial->eliminar_editorial_controlador();
    } 
    /**Actualizar un editorial */
    if (isset($_POST['editorial_id_actualizar'])){
        echo $controlador_editorial->actualizar_editorial_controlador();
    } 
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
