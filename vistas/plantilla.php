<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./vistas/modulos/link.php"; ?>
    <title><?php echo sistema; ?></title>
</head>
<body>
    <?php
$peticionRuta = false;
require_once "./controladores/vistaControlador.php";
$vistaControlador = new vistaControlador();/** controlador_vista */
$vistas = $vistaControlador->obtener_vistas_controlador(); /** controlador_vista */

if ($vistas == "login" || $vistas == "404") {
    require_once "./vistas/paginas/" . $vistas .".php";
} else {
    session_start(['name'=>'biblioteca']);
    require_once "./controladores/loginControlador.php";
    $controlador_login = new loginControlador();
	if(!isset($_SESSION['id_b']) || !isset($_SESSION['nombre_b']) || !isset($_SESSION['apellido_b']) || !isset($_SESSION['usuario_b']) || !isset($_SESSION['privilegio_b'])) {
		echo $controlador_login->forzar_cierre_sesion_controlador();
	   exit();
   }

   $pagina = explode("/", $_GET['views']);

   include "./vistas/modulos/sidebar.php";
?>
   <!--Contenido de la Pagina-->
   <section class="full-box dashboard-contentPage scroll">
	   <!--Navbar-->
	   <?php
		   include "./vistas/modulos/navbar.php";
		   include $vistas;
	   ?>
   </section>
<?php
   include "./vistas/modulos/logout.php";
}
   include "./vistas/modulos/script.php";
?>
</body>
</html>