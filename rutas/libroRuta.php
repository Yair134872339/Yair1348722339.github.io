<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['libro_codigo_guardar']) || isset($_POST['libro_id_actualizar']) || isset($_POST['libro_id_eliminar'])){
    /**Instancia al controlador de libro */
    require_once "../controladores/libroControlador.php";
    $controlador_libro = new libroControlador();
    /**guardar un libro */
    if (isset($_POST['libro_codigo_guardar']) && isset($_POST['libro_titulo_guardar'])){
        echo $controlador_libro->agregar_libro_controlador();
    }
     /**eliminar un libro */
     if (isset($_POST['libro_id_eliminar'])){
        echo $controlador_libro->eliminar_libro_controlador();
    } 
    /**Actualizar un libro */
    if (isset($_POST['libro_id_actualizar'])){
        echo $controlador_libro->actualizar_libro_controlador();
    } 
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
