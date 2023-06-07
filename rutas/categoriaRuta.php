<?php

$peticionRuta = true;
require_once "../config/app.php";

if(isset($_POST['categoria_nombre_guardar']) || isset($_POST['categoria_id_actualizar']) || isset($_POST['categoria_id_eliminar'])){
  
    /**Instancia al controlador de categoria */
    require_once "../controladores/categoriaControlador.php";
    $controlador_categoria = new categoriaControlador();
   
    /**guardar un categoria */
    if (isset($_POST['categoria_nombre_guardar']) && isset($_POST['categoria_nombre_guardar'])){
        echo $controlador_categoria->agregar_categoria_controlador();
    } 
    
    /**eliminar un categoria */
     if (isset($_POST['categoria_id_eliminar'])){
        echo $controlador_categoria->eliminar_categoria_controlador();
    } 
    
    /**Actualizar un categoria */
    if (isset($_POST['categoria_id_actualizar'])){
        echo $controlador_categoria->actualizar_categoria_controlador();
    } 
    
} else {
    session_start(['name'=>'biblioteca']);
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
}
