<?php

require_once "principalModelo.php";

class libroModelo extends principalModelo{
    
    /**Función para seleccionar un usuario*/
    protected static function seleccionar_libro_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM libro WHERE libro_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT libro_id FROM libro WHERE libro_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un usuario*/
    protected static function agregar_libro_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO libro VALUE    (null, :codigo, :titulo,
        :autor, :editorial, :categoria)");
        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->bindParam(":titulo", $datos['titulo']);
        $sql->bindParam(":autor", $datos['autor']);
        $sql->bindParam(":editorial", $datos['editorial']);
        $sql->bindParam(":categoria", $datos['categoria']);         
        $sql->execute();
        return $sql;   
    }
/**Funcion para actualizar un usuario  */
protected static function actualizar_libro_modelo($datos)
{
    $sql = principalModelo::conectar()->prepare("UPDATE libro SET libro_codigo = :codigo, libro_titulo = :titulo, libro_autor = :autor, libro_editorial = :editorial, libro_categoria = :categoria WHERE libro_id = :id AND libro_id != 1");
    $sql->bindParam(":codigo", $datos['codigo']);
    $sql->bindParam(":titulo", $datos['titulo']);
    $sql->bindParam(":autor", $datos['autor']);
    $sql->bindParam(":editorial", $datos['editorial']);
    $sql->bindParam(":categoria", $datos['categoria']);          
    $sql->execute();
    return $sql;   
   
}

    /**Funcion para eliminar un usuario */
    protected static function eliminar_libro_modelo($id) {
        $sql = principalModelo::conectar()->prepare("DELETE FROM libro WHERE libro_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    protected static function seleccionar_tabla_modelo($tipo) {
        if ($tipo == "autores") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM autor");
        } elseif ($tipo == "editoriales") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM editorial");
        } else if ($tipo == "categorias") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM categoria");
        }
        $sql->execute();
        return $sql;
    }

}