<?php

if ($peticionRuta) {
    require_once "../modelos/usuarioModelo.php";
} else {
    require_once "./modelos/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo{
    
    /**Funcion para listar los usuarios */
    public function listar_usuario_controlador($pagina, $registros,
        $privilegio, $id, $url, $busqueda) {
        $pagina = principalModelo::limpiar_cadena($pagina);
        $registros = principalModelo::limpiar_cadena($registros);
        $privilegio = principalModelo::limpiar_cadena($privilegio);
        $id = principalModelo::limpiar_cadena($id);
        $busqueda = principalModelo::limpiar_cadena($busqueda);
        $url = urlServidor.$url."/";
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1; 
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros):0;

        if (isset($busqueda) && $busqueda !=""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE((usuario_id != '$id' AND usuario_id != '1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_direccion LIKE '%$busqueda%' OR usuario_telefono LIKE '%$busqueda%' OR usuario_correo LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE usuario_id != '$id' AND usuario_id != '1' ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
        }

        $conexion = principalModelo::conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();
        $npaginas = ceil($total / $registros);

        $tabla = '
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="fs-8">
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr> 
                    </thead>
                    <tbody class="text-center fs-7">
   
        ';
        if ($total >= 1 && $pagina <= $npaginas) {
            $contador = $inicio + 1;
            $paginacion_inicio = $inicio + 1;
            foreach ($datos as $dato) {
                $tabla.='
                        <tr>
                            <td>'.$contador.'</td>
                            <td>'.$dato['usuario_nombre'].' '.$dato['usuario_apellido'].'</td>
                            <td>'.$dato['usuario_correo'].'</td>
                            <td>'.$dato['usuario_usuario'].'</td>
                            <td>'.$dato['usuario_estado'].'</td>
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'usuario-editar/'.$dato['usuario_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>
                                <form action="'.urlServidor.'rutas/usuarioRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="usuario_id_eliminar" value="'.$dato['usuario_id'].'">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                ';  
                $contador++;         
             }
             $paginacion_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla.= '
                        <tr>
                            <td colspan="6">
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de usuarios</a>
                            </td>
                        </tr>
                ';
            }else{
                $tabla.= '
                        <tr>
                            <td colspan="6">
                                No hay registros en el sistema.
                            </td>
                        </tr>
                ';
            }
        }
        $tabla.='
                    </tbody>
                </table>
            </div>
            <div class="row d-flex aling-items-center">
        ';
        if ($total >= 1 && $pagina <= $npaginas) {
            $tabla.= '
                <div class="col-md-6 col-12">
                    <p class="float-md-start text-center fs-7 mb-0">Mostrando registros del <strong>'.$paginacion_inicio.'</strong> al <strong'.$paginacion_final.'</strong> de un total de <strong>'.$total.'</strong></p>
                </div>
            ';
            $tabla.= principalModelo::paginador_tablas($pagina, $npaginas, $url, 7);
        }
        return $tabla;

    }
    /**Funcion para selecconar un usuario */
    public function seleccionar_usuario_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return usuarioModelo::seleccionar_usuario_modelo($tipo, $id);
    }

    /**Funcion para agregar un usuario  */
    public function agregar_usuario_controlador(){
        /**recibiendo datos del formulario */
        $nombre = principalModelo::limpiar_cadena($_POST['usuario_nombre_guardar']);
        $apellido = principalModelo::limpiar_cadena($_POST['usuario_apellido_guardar']);
        $telefono = principalModelo::limpiar_cadena($_POST['usuario_telefono_guardar']);
        $direccion = principalModelo::limpiar_cadena($_POST['usuario_direccion_guardar']);
        $correo = principalModelo::limpiar_cadena($_POST['usuario_correo_guardar']);
        $usuario = principalModelo::limpiar_cadena($_POST['usuario_usuario_guardar']);
        $clave_1 = principalModelo::limpiar_cadena($_POST['usuario_clave_uno_guardar']);
        $clave_2 = principalModelo::limpiar_cadena($_POST['usuario_clave_dos_guardar']);
        $estado = principalModelo::limpiar_cadena($_POST['usuario_estado_guardar']);
        $privilegio = principalModelo::limpiar_cadena($_POST['usuario_privilegio_guardar']);

        /**comprobando campos vacios  */
        if ($nombre == "" || $apellido == "" || $telefono == "" || $direccion == "" || $correo == "" || $usuario == "" || $clave_1 == "" || $clave_2 == "" || $estado == "" || $privilegio == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "No has llenado todos los campos que son requeridos",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        /**comprobar integridad de los campos */
        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $nombre)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El nombre no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}", $apellido)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El apellido no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[0-9]{10,13}", $telefono)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El telefono no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ()#., ]{4,150}", $direccion)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La direccion no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-Z]{1,30}", $usuario)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La cuenta no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (
            principalModelo::verificar_datos("[a-zA-Z0-9$@]{1,30}", $clave_1) ||
            principalModelo::verificar_datos("[a-zA-Z0-9$@]{8,50}", $clave_2)
        ) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "Las contraseñas no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $checar_correo = principalModelo::ejecutar_consulta_simple("SELECT usuario_correo FROM usuarios WHERE usuario_correo ='$correo'");
            if ($checar_correo->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "¡Ocurrio un error!",
                    "Texto" => "El correo ingresado ya esta registrado en el sistema",
                    "Icon" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El correo ingresado no es valido",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $checar_usuario = principalModelo::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario ='$usuario'");
        if ($checar_correo->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El correo ingresado ya esta registrado en el sistema",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        if ($clave_1 != $clave_2) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "Las contraseñas no coninciden",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        } else {
            $clave = principalModelo::encriptar($clave_1);
        }

        if (principalModelo::verificar_datos("[a-zA-Z]{9,12}", $estado)) {
            if ($estado != "Habilitada" || $estado != "Desabilitada" || $estado != "Bloqueada") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "¡Ocurrio un error!",
                    "Texto" => "EL estado selccionado no es valido",
                    "Icon" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        if ($privilegio < 1 || $privilegio > 3) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "EL privilegio selccionado no es valido",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_usuario = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "telefono" => $telefono,
            "direccion" => $direccion,
            "correo" => $correo,
            "usuario" => $usuario,
            "clave" => $clave,
            "estado" => $estado,
            "privilegio" => $privilegio
        ];

        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario);

        if ($agregar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Usuario registrado!",
                "Texto" => "Los datos se guardaron con exito en el sistema",
                "Icon" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "Simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "No se guardaron los datos en el sistema",
                "Icon" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    }
    /**Funcion para actualizar un usuario  */
    public function actualizar_usuario_controlador(){
        $id = principalModelo::limpiar_cadena($_POST['usuario_id_actualizar']);
        $checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE usuario_id = '$id'");
        if ($checar_id->rowCount()<=0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se ha encontrado el usuario en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos = $checar_id->fetch();
        }
        $nombre = principalModelo::limpiar_cadena($_POST['usuario_nombre_actualizar']);
        $apellido = principalModelo::limpiar_cadena($_POST['usuario_apellido_actualizar']);
        $telefono = principalModelo::limpiar_cadena($_POST['usuario_telefono_actualizar']);
        $direccion = principalModelo::limpiar_cadena($_POST['usuario_direccion_actualizar']);
        $correo = principalModelo::limpiar_cadena($_POST['usuario_correo_actualizar']);
        $usuario = principalModelo::limpiar_cadena($_POST['usuario_usuario_actualizar']);
        
        if (isset($_POST['usuario_estado_actualizar'])){
            $estado = principalModelo::limpiar_cadena($_POST['usuario_estado_actualizar']);
        }else{
            $estado = $campos['usuario_estado'];
        }
        if (isset($_POST['usuario_privilegio_actualizar'])){
            $privilegio = principalModelo::limpiar_cadena($_POST['usuario_privilegio_actualizar']);
        }else{
            $privilegio = $campos['usuario_privilegio'];
        }

        $admin_usuario = principalModelo::limpiar_cadena($_POST['admin_usuario']);
        $admin_clave = principalModelo::limpiar_cadena($_POST['admin_clave']);
        $tipo_cuenta = principalModelo::limpiar_cadena($_POST['tipo_cuenta']);

        /**Comprobar campos vacios */
        if ($nombre == "" || $apellido == "" || $telefono == "" || $direccion == "" || $correo == "" || $usuario == "" || $admin_usuario == "" || $admin_clave == "") {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No has llenado todos los camppos que son requeridos.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        } 

        /**Comprobar integridad de los campos*/
        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $nombre)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El nombre no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}", $apellido)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El apellido no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }   
        
        if(principalModelo::verificar_datos("[0-9]{10,13}", $telefono)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El telefono no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ()#., ]{1,150}", $direccion)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"La dirección no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-Z0-9]{1,30}", $usuario)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El nombre de la cuenta coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-Z0-9 ]{1,30}", $admin_usuario)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El nombre de usuario no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-Z0-9$@.-]{8,20}", $admin_clave)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"La contraseña no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $admin_clave = principalModelo::encriptar($admin_clave);

        if($estado !="Habilitada" && $estado != "Desabilitada" && $estado != "Bloqueada"){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El estado seleccionado no es válido.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($privilegio < 1 || $privilegio > 3) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El privilegio seleccionado no es válido.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit(); 
        }

        if($usuario != $campos['usuario_usuario']){
            $checar_usuario = principalModelo::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = '$usuario'");
            if($checar_usuario->rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"El nombre del usuario ya se encuentra registrado.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        if($correo != $campos['usuario_correo']){
            if(filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $checar_correo = principalModelo::ejecutar_consulta_simple("SELECT usuario_correo FROM usuarios WHERE usuario_correo = '$correo'");
            if($checar_correo->rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"El correo ingresado ya esta registrado en el sistema.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"El correo ingresado  o es valido.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                exit();       
            }      
        }

        if ($_POST['usuario_clave_uno_actualizar'] != "" || $_POST['usuario_clave_dos_actualizar'] != ""){
            if($_POST['usuario_clave_uno_actualizar'] != $_POST['usuario_clave_dos_actualizar']) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"Las contraseñas nuevas no coinciden.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                exit();    
            }else{
                if(principalModelo::verificar_datos("[a-zA-Z0-9$@.-]{8, 30}", $_POST ['usuario_clave_uno_actualizar'])|| principalModelo::verificar_datos("[a-zA-Z0-9$@.-]{8,30}", $_POST['usuario_clave_dos_actualizar'])) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"¡Ocurrio un error!",
                        "Texto"=>"Las contraseñas no coinciden con el formato solicitado.",
                        "Icon"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                }
                $clave = principalModelo::encriptar($_POST['usuario_clave_uno_actualizar']);
            }
        }else{
            $clave = $campos['usuario_clave'];
        }

        if ($tipo_cuenta == "propia"){
            $checar_cuenta =principalModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_usuario = '$admin_usuario' AND usuario_clave = '$admin_clave'AND usuario_id = '$id'");
        } else {
            session_start(['name'=>'biblioteca']);
            if($_SESSION['privilegio_b'] !=1) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"¡Ocurrio un error!",
                    "Texto"=>"No tienes los permisos necesarios para actualizar los datos.",
                    "Icon"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }
            $checar_cuenta = principalModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_usuario = '$admin_usuario' AND usuario_clave = '$admin_clave' LIMIT 1");
        }

        if($checar_cuenta->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El nombre y la contraseña no son validas.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();   
        }

        $datos_usuario =[
            "nombre"=>$nombre,
            "apellido"=>$apellido,
            "telefono"=>$telefono,
            "direccion"=>$direccion,
            "correo"=>$correo,
            "usuario"=>$usuario,
            "clave"=>$clave,
            "estado"=>$estado,
            "privilegio"=>$privilegio,
            "id"=>$id
        ];

        if(usuarioModelo::actualizar_usuario_modelo($datos_usuario)) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Usuario actualizado!",
                "Texto"=>"los datos del usuario han sido actualizados.",
                "Icon"=>"success"
            ];
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se han podido actualizar los datos, intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
           
    }

    /**Funcion para eliminar un usuario */
    public function eliminar_usuario_controlador($id) {
        $id =principalModelo::limpiar_cadena($_POST['usuario_id_eliminar']);

        if(principalModelo::verificar_datos("[0-9]{1,3}", $id)) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El identificador del usuario no es valido.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit(); 
        }
        if($id == 1) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el usuario principal del sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $checar_usuario =principalModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_id = '$id'");
        if ($checar_usuario->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El usuario que intenta eliminar no existe en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        session_start(['name'=>'biblioteca']);
        if($_SESSION['privilegio_b'] !=1) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No tiene permisos para eliminar usuarios.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_usuario = usuarioModelo::eliminar_usuario_modelo($id);

        if ($eliminar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Usuario eliminado!",
                "Texto"=>"El usuario fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el usuario, intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

}