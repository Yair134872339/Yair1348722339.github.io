<?php

if ($peticionRuta) {
    require_once "../modelos/libroModelo.php";
} else {
    require_once "./modelos/libroModelo.php";
}

class libroControlador extends libroModelo{
    
    /**Funcion para listar los libro */
    public function listar_libro_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda) {
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libro WHERE (libro_codigo LIKE '%$busqueda%' OR libro_titulo LIKE '%$busqueda%' OR libro_autor LIKE '%$busqueda%' OR libro_editorial LIKE '%$busqueda%'OR libro_categoria LIKE '%$busqueda%') ORDER BY libro_codigo ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libro INNER JOIN autor ON libro.libro_autor = autor.autor_id INNER JOIN editorial ON libro.libro_editorial = editorial.editorial_id INNER JOIN categoria ON libro.libro_categoria = categoria.categoria_id ORDER BY libro_codigo ASC LIMIT $inicio, $registros";
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
                            <th scope="col">Titulo</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Editorial</th>
                            <th scope="col">Categoria</th>
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
                            <td>'.$dato['libro_codigo'].'</td>
                            <td>'.$dato['libro_titulo'].'</td>
                            <td>'.$dato['autor_nombre'].' '.$dato['autor_apellido'].'</td>
                            <td>'.$dato['editorial_nombre'].'</td>
                            <td>'.$dato['categoria_nombre'].'</td>                           
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'ejemplar-nuevo/'.$dato['libro_id'].'/" class="btn btn-info btn-sm"><i class="fas fa-file"></i></a>
                                <a href="'.urlServidor.'libro-editar/'.$dato['libro_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>
                                <form action="'.urlServidor.'rutas/libroRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="libro_id_eliminar" value="'.$dato['libro_id'].'">
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
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de libro</a>
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
    /**Funcion para selecconar un libro */
    public function seleccionar_libro_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return libroModelo::seleccionar_libro_modelo($tipo, $id);
    }

    /**Funcion para agregar un libro  */
    public function agregar_libro_controlador(){
        /**recibiendo datos del formulario */
        $codigo = principalModelo::limpiar_cadena($_POST['libro_codigo_guardar']);
        $titulo = principalModelo::limpiar_cadena($_POST['libro_titulo_guardar']);
        $autor = principalModelo::limpiar_cadena($_POST['libro_autor_guardar']);
        $editorial = principalModelo::limpiar_cadena($_POST['libro_editorial_guardar']);
        $categoria = principalModelo::limpiar_cadena($_POST['libro_categoria_guardar']);        

        /**comprobando campos vacios  */
        if ($codigo == "" || $titulo == "" || $autor == "" || $editorial == "" || $categoria == "") {
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
        
        if (principalModelo::verificar_datos("[0-9]{1,5}", $codigo)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El codigo del libro no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,25}", $titulo)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El nombre del libro no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[0-9]{1,4}", $autor)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "El autor no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (principalModelo::verificar_datos("[0-9]{1,3}", $editorial)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La editorial no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        if (principalModelo::verificar_datos("[0-9]{1,2}", $categoria)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "¡Ocurrio un error!",
                "Texto" => "La categoria no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_libro = [
            "codigo"=>$codigo,
            "titulo"=>$titulo,
            "autor"=>$autor,
            "editorial"=>$editorial,
            "categoria"=>$categoria            
        ];

        $agregar_libro = libroModelo::agregar_libro_modelo($datos_libro);

        if ($agregar_libro->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Libro registrado!",
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
    }
    /**Funcion para actualizar un usuario */
    public function actualizar_libro_controlador(){
        $id = principalModelo::limpiar_cadena($_POST['libro_id_actualizar']);
        $checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM libro WHERE libro_id = '$id'");
        if ($checar_id->rowCount()<=0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se ha encontrado el libro en el sistema.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos = $checar_id->fetch();
        }
        $codigo = principalModelo::limpiar_cadena($_POST['libro_codigo_actualizar']);       
        $titulo = principalModelo::limpiar_cadena($_POST['libro_titulo_actualizar']);
        $autor = principalModelo::limpiar_cadena($_POST['libro_autor_actualizar']);
        $editorial = principalModelo::limpiar_cadena($_POST['libro_editorial_actualizar']);
        $categoria = principalModelo::limpiar_cadena($_POST['libro_categoria_actualizar']);
        
        /**Comprobar campos vacios */
        if ($codigo == "" || $titulo == "" || $autor == "" || $editorial== "" || $categoria== "") {
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

        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,25}", $titulo)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El nombre no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}", $autor)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El area no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }   
               

        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ()#., ]{1,150}", $editorial)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"La descripion no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ()#., ]{1,150}", $categoria)){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"La descripion no coincide con el formato solicitado.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_libro =[
            "codigo"=>$codigo,
            "titulo"=>$titulo,
            "autor"=>$autor,
            "editorial"=>$editorial,
            "categoria"=>$categoria,                
            "id"=>$id
        ];

        if(libroModelo::actualizar_libro_modelo($datos_libro)) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Libro actualizado!",
                "Texto"=>"los datos del libro han sido actualizados.",
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
    public function eliminar_libro_controlador() {
        $id =principalModelo::limpiar_cadena($_POST['libro_id_eliminar']);

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

        $checar_usuario =principalModelo::ejecutar_consulta_simple("SELECT libro_id FROM libro WHERE libro_id = '$id'");
        if ($checar_usuario->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El libro que intenta eliminar no existe en el sistema.",
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
                "Texto"=>"No tiene permisos para eliminar libro.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_libro = libroModelo::eliminar_libro_modelo($id);

        if ($eliminar_libro->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Libro eliminado!",
                "Texto"=>"El libro fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el libro intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

    public function seleccionar_tabla_controlador($tipo){
        $tipo = principalModelo::limpiar_cadena($tipo);
        return libroModelo::seleccionar_tabla_modelo($tipo);
    }

}