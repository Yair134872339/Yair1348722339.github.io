<?php

if ($peticionRuta) {
    require_once "../modelos/categoriaModelo.php";
} else {
    require_once "./modelos/categoriaModelo.php";
}

class categoriaControlador extends categoriaModelo{
    
    /**Funcion para listar los categoria */
    public function listar_categoria_controlador($pagina, $registros,
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM categoria WHERE (categoria_nombre LIKE '%$busqueda%') ORDER BY categoria_nombre ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio, $registros";
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
                            <td>'.$dato['categoria_nombre'].'</td>                                                  
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'categoria-editar/'.$dato['categoria_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>   
                                <form action="'.urlServidor.'rutas/categoriaRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="categoria_id_eliminar" value="'.$dato['categoria_id'].'">
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
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de categoria</a>
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
    /**Funcion para selecconar un categoria */
    public function seleccionar_categoria_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return categoriaModelo::seleccionar_categoria_modelo($tipo, $id);
    }

    /**Funcion para agregar un categoria  */
    public function agregar_categoria_controlador(){
        /**recibiendo datos del formulario */        
        $nombre = principalModelo::limpiar_cadena($_POST['categoria_nombre_guardar']);

        /**comprobando campos vacios  */
        if ($nombre == "") {
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

        $datos_categoria = [            
            "nombre" => $nombre                              
        ];

        $agregar_categoria = categoriaModelo::agregar_categoria_modelo($datos_categoria);

        if ($agregar_categoria->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Categoria registrada!",
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
    public function actualizar_categoria_controlador(){
        $id = principalModelo::limpiar_cadena($_POST['categoria_id_actualizar']);
        $checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM categoria WHERE categoria_id = '$id'");
        if ($checar_id->rowCount()<=0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se ha encontrado el categoria en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos = $checar_id->fetch();
        }
        $nombre = principalModelo::limpiar_cadena($_POST['categoria_nombre_actualizar']);               

        /**Comprobar campos vacios */
        if ($nombre == "") {
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
        
        
       
        $datos_categoria =[            
            "nombre"=>$nombre,                                  
            "id"=>$id
        ];

        if(categoriaModelo::actualizar_categoria_modelo($datos_categoria)) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Categoria actualizado!",
                "Texto"=>"los datos del categoria han sido actualizados.",
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
    public function eliminar_categoria_controlador() {
        $id =principalModelo::limpiar_cadena($_POST['categoria_id_eliminar']);

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

        $checar_categoria =principalModelo::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id = '$id'");
        if ($checar_categoria->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El categoria que intenta eliminar no existe en el sistema.",
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
                "Texto"=>"No tiene permisos para eliminar categoria.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_categoria = categoriaModelo::eliminar_categoria_modelo($id);

        if ($eliminar_categoria->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Categoria eliminado!",
                "Texto"=>"El categoria fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el categoria intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

}