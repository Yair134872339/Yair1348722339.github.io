<?php

if ($peticionRuta) {
    require_once "../modelos/clienteModelo.php";
} else {
    require_once "./modelos/clienteModelo.php";
}

class clienteControlador extends clienteModelo{
    
    /**Funcion para listar los cliente */
    public function listar_cliente_controlador($pagina, $registros,
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_direccion LIKE '%$busqueda%'OR cliente_telefono LIKE '%$busqueda%' ) ORDER BY cliente_nombre ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio, $registros";
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
                            <th scope="col">nombre</th>
                            <th scope="col">apellido</th>
                            <th scope="col">direccion</th>  
                            <th scope="col">telefono</th>                           
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
                            <td>'.$dato['cliente_nombre'].'</td>
                            <td>'.$dato['cliente_apellido'].'</td> 
                            <td>'.$dato['cliente_direccion'].'</td>
                            <td>'.$dato['cliente_telefono'].'</td>                          
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'cliente-editar/'.$dato['cliente_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>
                                <form action="'.urlServidor.'rutas/clienteRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="cliente_id_eliminar" value="'.$dato['cliente_id'].'">
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
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de cliente</a>
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
    /**Funcion para selecconar un cliente */
    public function seleccionar_cliente_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return clienteModelo::seleccionar_cliente_modelo($tipo, $id);
    }

    /**Funcion para agregar un cliente  */
    public function agregar_cliente_controlador(){
        /**recibiendo datos del formulario */
        $nombre = principalModelo::limpiar_cadena($_POST['cliente_nombre_guardar']);
        $apellido = principalModelo::limpiar_cadena($_POST['cliente_apellido_guardar']); 
        $direccion = principalModelo::limpiar_cadena($_POST['cliente_direccion_guardar']); 
        $telefono = principalModelo::limpiar_cadena($_POST['cliente_telefono_guardar']); 

        /**comprobando campos vacios  */
        if ($nombre == "" || $apellido == "" || $direccion == "" || $telefono == "") {
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

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $apellido)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El apellido no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $direccion)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La dirección no coincide con el formato solicitado",
                "Icon" => "error"
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


        $datos_cliente = [
            "nombre" => $nombre,
            "apellido" => $apellido ,
            "direccion" => $direccion,
            "telefono" => $telefono                     
        ];

        $agregar_cliente = clienteModelo::agregar_cliente_modelo($datos_cliente);

        if ($agregar_cliente->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Cliente registrado!",
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
    /**Funcion para actualizar un usuario */
    public function actualizar_cliente_controlador(){
        $id = principalModelo::limpiar_cadena($_POST['cliente_id_actualizar']);
        $checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id = '$id'");
        if ($checar_id->rowCount()<=0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se ha encontrado el cliente en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos = $checar_id->fetch();
        }
        $nombre = principalModelo::limpiar_cadena($_POST['cliente_nombre_actualizar']);
        $apellido = principalModelo::limpiar_cadena($_POST['cliente_apellido_actualizar']);  
        $direccion = principalModelo::limpiar_cadena($_POST['cliente_direccion_actualizar']); 
        $telefono = principalModelo::limpiar_cadena($_POST['cliente_telefono_actualizar']);                 

         /**comprobando campos vacios  */
         if ($nombre == "" || $apellido == "" || $direccion == "" || $telefono == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "No has llenado todos los campos que son requeridos",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
        

        /**Comprobar integridad de los campos */
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

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $apellido)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El apellido no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $direccion)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La dirección no coincide con el formato solicitado",
                "Icon" => "error"
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
        $datos_cliente =[
            "nombre"=>$nombre,
            "apellido"=>$apellido,
            "direccion"=>$direccion,
            "telefono"=>$telefono,                       
            "id"=>$id
        ];

        if(clienteModelo::actualizar_cliente_modelo($datos_cliente)) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Cliente actualizado!",
                "Texto"=>"los datos del cliente han sido actualizados.",
                "Icon"=>"success"
            ];

        }else{+
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
    public function eliminar_cliente_controlador() {
        $id =principalModelo::limpiar_cadena($_POST['cliente_id_eliminar']);

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

        $checar_usuario =principalModelo::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id = '$id'");
        if ($checar_usuario->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El cliente que intenta eliminar no existe en el sistema.",
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
                "Texto"=>"No tiene permisos para eliminar cliente.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_cliente = clienteModelo::eliminar_cliente_modelo($id);

        if ($eliminar_cliente->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Cliente eliminado!",
                "Texto"=>"El cliente fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el cliente intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }
     
    public function seleccionar_tabla_controlador($tipo){
        $tipo = principalModelo::limpiar_cadena($tipo);
        return clienteModelo::seleccionar_tabla_modelo($tipo);
    }

}