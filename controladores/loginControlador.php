<?php

if ($peticionRuta) {
    require_once "../modelos/loginModelo.php";
} else {
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo {

    /**Funcion para iniciar sesion */
    public function iniciar_sesion_controlador() {
        $usuario = principalModelo::limpiar_cadena($_POST['login_usuario']);
        $clave = principalModelo::limpiar_cadena($_POST['login_clave']);

        /**Comprobar campos vacios */
        if ($usuario == "" || $clave == "" ) {
            echo '
                <script>
                    Swal.fire({
                        title: "¡Ocurrió un error!",
                        text: "No has llenado todos los campos que son requeridos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
            ';
            exit();
        }

        /**comprobar integridad de los campos */
        if (principalModelo::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
            echo'
                <script>
                    Swal.firel({
                        title: "¡Ocurrio un error!",
                        text: "El nombre del usuario no coincide con el formato solicitado",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script> 
            ';
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-Z0-9$@.-]{8,50}", $clave)) {
            echo'
                <script>
                    Swal.firel({
                        title: "¡Ocurrio un error!",
                        text: "La clave del usuario no coincide con el formato solicitado",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script> 
            ';
            exit();
        }

        $clave = principalModelo::encriptar($clave);

        $datos = [
            "usuario" => $usuario,
            "clave" => $clave
        ];

        $datos_login = loginModelo::iniciar_sesion_modelo($datos);
        if ($datos_login->rowCount() == 1) {
            $fila = $datos_login->fetch();
            session_start(['name'=>'biblioteca']);
            $_SESSION['id_b'] = $fila['usuario_id'];
            $_SESSION['nombre_b'] = $fila['usuario_nombre'];
            $_SESSION['apellido_b'] = $fila['usuario_apellido'];
            $_SESSION['usuario_b'] = $fila['usuario_usuario'];
            $_SESSION['privilegio_b'] = $fila['usuario_privilegio'];

            return header("Location:".urlServidor."home/");
        }else {
            echo '
                <script>
                    Swal.fire({
                        title: "¡Ocurrio un error!",
                        text: "El usuario o la clave son incorrectos",
                        icon: "Error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
            ';
            exit();
        }
    }
   /**Funcion para cerrar la sesion */
   public function cerrar_sesion_controlador() {
    session_start(['name'=>'biblioteca']);
    $nombre = principalModelo::limpiar_cadena($_POST['nombre']);
    $usuario = principalModelo::limpiar_cadena($_POST['usuario']);
    
    if ($nombre == $_SESSION['nombre_b'] && $usuario == $_SESSION['usuario_b']) {
        session_unset();
        session_destroy();
        $alerta = [
            "Alerta"=>"redireccionar",
            "URL"=>urlServidor."login/"
        ];
    } else {
        $alerta = [
            "Alerta"=>"simple",
            "Titulo"=>"¡Ocurrio un error!",
            "Texto"=>"No se pudo cerrar la sesion en el sistema",
            "Tipo"=>"error"
        ];
    }
    echo json_encode($alerta);
}

/**Funcion para forzar el cierre de sesion */
public function forzar_cierre_sesion_controlador() {
    session_unset();
    session_destroy();
    if (headers_sent()) {
        return "<script> window.location.href='".urlServidor."login/'; <script>";
    }else{
        return header ("Location: ".urlServidor."login/");
    }
}
}