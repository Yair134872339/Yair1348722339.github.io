<?php

session_start(['name'=>'biblioteca']);
require_once "../config/app.php";

if (isset($_POST['buscar_palabra']) || isset($_POST['eliminar_busqueda'])) {

    $urls = [
        "usuario"=>"usuario-buscar",
        "libro"=>"libro-buscar",
        "autor"=>"autor-buscar",
        "editorial"=>"editorial-buscar",
        "categoria"=>"categoria-buscar",
        "prestamo"=>"prestamo-buscar",
        "ejemplares"=>"ejemplares-buscar",
        "cliente"=>"cliente-buscar"       
    ];

    if (isset($_POST['modulo'])) {
        $modulo = $_POST['modulo'];
        if (!isset($urls[$modulo])) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No podemos procesar la busqueda",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }else {
        $alerta = [
            "Alerta"=>"simple",
            "Titulo"=>"¡Ocurrio un error!",
            "Texto"=>"Nose ha podido realizar la busqueda",
            "Icon"=>"error"
        ];
        echo json_encode($alerta);
            exit();        
    }

    if ($modulo == "reporte") {
        //programas de logica.
    } else {
        $nombre_busqueda = "busqueda_".$modulo;
        if (isset($_POST['buscar_palabra'])) {
            if ($_POST['buscar_palabra'] == "") {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"Introduzca una palabra para empezar la busqueda.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                    exit();
            }
           $_SESSION[$nombre_busqueda] = $_POST['buscar_palabra'];
        }

        if (isset($_POST['eliminar_busqueda'])) {
            unset($_SESSION[$nombre_busqueda]);
        }
    }

    $url = $urls[$modulo];
    $alerta = [
        "Alerta"=>"redireccionar",
        "URL"=>urlServidor.$url."/"
    ];

    echo json_encode($alerta);
    
} else {
    session_unset();
    session_destroy();
    header("Location: ".urlServidor."login/");
    exit();
    
}