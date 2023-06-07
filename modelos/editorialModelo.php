<?php

require_once "principalModelo.php";

class editorialModelo extends principalModelo{
    
    /**Función para seleccionar un editorial*/
    protected static function seleccionar_editorial_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM editorial WHERE editorial_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT editorial_id FROM editorial WHERE editorial_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un editorial*/
    protected static function agregar_editorial_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO editorial VALUE(null, :codigo, :nombre)");
        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->bindParam(":nombre", $datos['nombre']);              
        $sql->execute();
        return $sql;   
    }

/**Funcion para actualizar un editorial  */
protected static function actualizar_editorial_modelo($datos){
    $sql = principalModelo::conectar()->prepare("UPDATE editorial SET editorial_codigo = :codigo, editorial_nombre = :nombre WHERE editorial_id = :id AND editorial_id != 1");
    $sql->bindParam(":codigo", $datos['codigo']);   
    $sql->bindParam(":nombre", $datos['nombre']);   
    $sql->bindParam(":id", $datos['id']);
    $sql->execute();
    return $sql;
}

  /**Funcion para eliminar un editorial */
protected static function eliminar_editorial_modelo($id){
    $sql = principalModelo::conectar()->prepare("DELETE FROM editorial WHERE editorial_id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    return $sql;
}
protected static function seleccionar_tabla_modelo($tipo) {
    if($tipo == "editorial"){
        $sql = principalModelo::conectar()->query("SELECT * FROM editorial");
    }elseif($tipo == "editorial"){
        $sql = principalModelo::conectar()->prepare("SELECT * FROM editorial");
    }
    $sql->execute();
    return $sql;
}

}