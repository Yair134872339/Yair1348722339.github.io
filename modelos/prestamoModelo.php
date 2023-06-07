<?php

require_once "principalModelo.php";

class prestamoModelo extends principalModelo{
    
    /**Función para seleccionar un usuario*/
    protected static function seleccionar_prestamo_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM prestamo WHERE prestamo_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT prestamo_id FROM prestamo WHERE prestamo_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un usuario*/
    protected static function agregar_prestamo_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO prestamo VALUE    (null, :codigo, :titulo,
        :cliente, :editorial, :categoria)");
        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->bindParam(":titulo", $datos['titulo']);
        $sql->bindParam(":cliente", $datos['cliente']);
        $sql->bindParam(":editorial", $datos['editorial']);
        $sql->bindParam(":categoria", $datos['categoria']);         
        $sql->execute();
        return $sql;   
    }
/**Funcion para actualizar un usuario  */
protected static function actualizar_prestamo_modelo($datos)
{
    $sql = principalModelo::conectar()->prepare("UPDATE prestamo SET prestamo_codigo = :codigo, prestamo_titulo = :titulo, prestamo_cliente = :cliente, prestamo_editorial = :editorial, prestamo_categoria = :categoria WHERE prestamo_id = :id AND prestamo_id != 1");
    $sql->bindParam(":codigo", $datos['codigo']);
    $sql->bindParam(":titulo", $datos['titulo']);
    $sql->bindParam(":cliente", $datos['cliente']);
    $sql->bindParam(":editorial", $datos['editorial']);
    $sql->bindParam(":categoria", $datos['categoria']);          
    $sql->execute();
    return $sql;   
   
}

    /**Funcion para eliminar un usuario */
    protected static function eliminar_prestamo_modelo($id) {
        $sql = principalModelo::conectar()->prepare("DELETE FROM prestamo WHERE prestamo_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }

    protected static function seleccionar_tabla_modelo($tipo) {
        if ($tipo == "clientes") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM cliente");
        } elseif ($tipo == "editoriales") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM editorial");
        } else if ($tipo == "categorias") {
            $sql = principalModelo::conectar()->prepare("SELECT * FROM categoria");
        }
        $sql->execute();
        return $sql;
    }

}