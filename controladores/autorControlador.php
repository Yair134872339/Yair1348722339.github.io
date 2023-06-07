<?php

if ($peticionRuta) {
    require_once "../modelos/autorModelo.php";
} else {
    require_once "./modelos/autorModelo.php";
}

class autorControlador extends autorModelo{
    
    /**Funcion para listar los autor */
    public function listar_autor_controlador($pagina, $registros,
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM autor WHERE (autor_nombre LIKE '%$busqueda%' OR autor_apellido LIKE '%$busqueda%') ORDER BY autor_nombre ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM autor ORDER BY autor_nombre ASC LIMIT $inicio, $registros";
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
                            <th scope="col">Apellido</th>                            
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
                            <td>'.$dato['autor_nombre'].'</td>
                            <td>'.$dato['autor_apellido'].'</td>                                                       
                            <td class="d-flex justify-content-center">
                                <a href="'.urlServidor.'autor-editar/'.$dato['autor_id'].'/" class="btn btn-warning btn-sm mx-1"><i class="fas fa-pen"></i></a>   
                                <form action="'.urlServidor.'rutas/autorRuta.php" method="POST" class="Formulario" data-form="eliminar" autocomplete="off">
                                    <input type="hidden" name="autor_id_eliminar" value="'.$dato['autor_id'].'">
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
                                <a href="'.$url.'"class="btn btn-sm btn-primary">Recargar la lista de autor</a>
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
    /**Funcion para selecconar un autor */
    public function seleccionar_autor_controlador($tipo, $id){
        $tipo = principalModelo::limpiar_cadena($tipo);
        $id = principalModelo::limpiar_cadena($id);
        return autorModelo::seleccionar_autor_modelo($tipo, $id);
    }

    /**Funcion para agregar un autor  */
    public function agregar_autor_controlador(){
        /**recibiendo datos del formulario */        
        $nombre = principalModelo::limpiar_cadena($_POST['autor_nombre_guardar']);
        $apellido = principalModelo::limpiar_cadena($_POST['autor_apellido_guardar']);
               

        /**comprobando campos vacios  */
        if ($nombre == "" || $apellido == "") {
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
                "Texto" => "El nombre no coincide con el formato solicitado",
                "Icon" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
       

        $datos_autor = [            
            "nombre" => $nombre,
            "apellido" => $apellido                     
        ];

        $agregar_autor = autorModelo::agregar_autor_modelo($datos_autor);

        if ($agregar_autor->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Autor registrado!",
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

   /**Funcion para actualizar un autor  */
	public function actualizar_autor_controlador() {
		$id = principalModelo::limpiar_cadena($_POST['autor_id_actualizar']);
		$checar_id = principalModelo::ejecutar_consulta_simple("SELECT * FROM autor WHERE autor_id = '$id'");
		if ($checar_id->rowCount() <= 0) {
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"¡Ocurrio un error!",
				"Texto"=>"No se ha encontrado el alumno en el sistema.",
				"Icon"=>"error"
			];
			echo json_encode($alerta);
			exit();
		}else{
			$campos = $checar_id->fetch();
		}
		
		$nombre = principalModelo::limpiar_cadena($_POST['autor_nombre_actualizar']);
		$apellido = principalModelo::limpiar_cadena($_POST['autor_apellido_actualizar']);
		
		/**Comprobar campos vacios */
		if ( $nombre == "" || $apellido == ""  ) {
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
		if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,25}", $nombre)){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"¡Ocurrio un error!",
				"Texto"=>"El nombre no coincide con el formato solicitado.",
				"Icon"=>"error"
			];
			echo json_encode($alerta);
			exit();
		}

		if(principalModelo::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}", $apellido)){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"¡Ocurrio un error!",
				"Texto"=>"El apellido no coincide con el formato solicitado.",
				"Icon"=>"error"
			];
			echo json_encode($alerta);
			exit();
		}  		
	
		$datos_autor =[
			"nombre"=>$nombre,
			"apellido"=>$apellido,			
			"id"=>$id
		];

		if(autorModelo::actualizar_autor_modelo($datos_autor)) {
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"¡Autor actualizado!",
				"Texto"=>"Los datos del alumno han sido actualizados.",
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
    public function eliminar_autor_controlador() {
        $id =principalModelo::limpiar_cadena($_POST['autor_id_eliminar']);

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

        $checar_autor =principalModelo::ejecutar_consulta_simple("SELECT autor_id FROM autor WHERE autor_id = '$id'");
        if ($checar_autor->rowCount()<= 0) {
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"El autor que intenta eliminar no existe en el sistema.",
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
                "Texto"=>"No tiene permisos para eliminar autor.",
                "Icon"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_autor = autorModelo::eliminar_autor_modelo($id);

        if ($eliminar_autor->rowCount() == 1) {
            $alerta = [
                "Alerta"=>"recargar",
                "Titulo"=>"¡Autor eliminado!",
                "Texto"=>"El autor fue eliminado del sistema exitosamente.",
                "Icon"=>"success"
            ];  
        }else{
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"¡Ocurrio un error!",
                "Texto"=>"No se puede eliminar el autor intente de nuevo.",
                "Icon"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

}