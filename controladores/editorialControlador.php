<?php

if ($peticionRuta) {
    require_once "../modelos/editorialModelo.php";
} else {
    require_once "./modelos/editorialModelo.php";
}

class editorialControlador extends editorialModelo{
    
    /**Funcion para listar los editorial */
    public function listar_editorial_controlador($pagina, $registros,
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM editorial WHERE (editorial_codigo LIKE '%$busqueda%' OR editorial_nombre) ORDER BY editorial_codigo ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM editorial ORDER BY editorial_codigo ASC LIMIT $inicio, $registros";
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
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>                            
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
                            <td>'.$dato['editorial_codigo'].'</td>
                            <td>'.$dato['editorial_nombre'].'</td>                          
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'editorial-editar/'.$dato['editorial_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>
                                <form action="'.urlServidor.'rutas/editorialRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="editorial_id_eliminar" value="'.$dato['editorial_id'].'">
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
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de editorial</a>
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
    /**Funcion para selecconar un editorial */
    public function seleccionar_editorial_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return editorialModelo::seleccionar_editorial_modelo($tipo, $id);
    }

    /**Funcion para agregar un editorial  */
    public function agregar_editorial_controlador(){
        /**recibiendo datos del formulario */
        $codigo = principalModelo::limpiar_cadena($_POST['editorial_codigo_guardar']);
        $nombre = principalModelo::limpiar_cadena($_POST['editorial_nombre_guardar']);        
        /**comprobando campos vacios  */
        if ($codigo == "" || $nombre == "") {
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
        
        if (principalModelo::verificar_datos("[0-9]{5,6}", $codigo)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El codigo no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

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


        $datos_editorial = [
            "codigo" => $codigo,
            "nombre" => $nombre                       
        ];

        $agregar_editorial = editorialModelo::agregar_editorial_modelo($datos_editorial);

        if ($agregar_editorial->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Editorial registrado!",
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
    public function actualizar_editorial_controlador(){
        $id = principalModelo::limpiar_cadena($_POST['editorial_id_actualizar']);
        $checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM editorial WHERE editorial_id = '$id'");
        if ($checar_id->rowCount()<=0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se ha encontrado el editorial en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos = $checar_id->fetch();
        }
        $codigo = principalModelo::limpiar_cadena($_POST['editorial_codigo_actualizar']);
        $nombre = principalModelo::limpiar_cadena($_POST['editorial_nombre_actualizar']);                

        /**Comprobar campos vacios */
        if ($codigo == "" || $nombre == "") {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No has llenado todos los camppos que son requeridos.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        } 

        /**Comprobar integridad de los campos */

        
        if(principalModelo::verificar_datos("[0-9]{5,6}", $codigo)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El codigo no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

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


        $datos_editorial =[
            "codigo"=>$codigo,
            "nombre"=>$nombre,                        
            "id"=>$id
        ];

        if(editorialModelo::actualizar_editorial_modelo($datos_editorial)) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Editorial actualizado!",
                "Texto"=>"los datos del editorial han sido actualizados.",
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
    public function eliminar_editorial_controlador() {
        $id =principalModelo::limpiar_cadena($_POST['editorial_id_eliminar']);

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

        $checar_usuario =principalModelo::ejecutar_consulta_simple("SELECT editorial_id FROM editorial WHERE editorial_id = '$id'");
        if ($checar_usuario->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El editorial que intenta eliminar no existe en el sistema.",
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
                "Texto"=>"No tiene permisos para eliminar editorial.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_editorial = editorialModelo::eliminar_editorial_modelo($id);

        if ($eliminar_editorial->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Editorial eliminado!",
                "Texto"=>"El editorial fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el editorial intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }
    
    public function seleccionar_tabla_controlador($tipo){
        $tipo = principalModelo::limpiar_cadena($tipo);
        return editorialModelo::seleccionar_tabla_modelo($tipo);
    }

}