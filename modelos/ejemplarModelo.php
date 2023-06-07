<?php

require_once "principalModelo.php";

class ejemplarModelo extends principalModelo{
    
    /**Función para seleccionar un ejemplar*/
    protected static function seleccionar_ejemplar_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM ejemplar WHERE ejemplar_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT ejemplar_id FROM ejemplar WHERE ejemplar_id != '1'");
        } elseif($tipo == "libros"){
            $sql = principalModelo::conectar()->prepare("SELECT libro_id, libro_codigo FROM libro WHERE libro_id = :id");
            $sql->bindParam(":id", $id);
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un ejemplar*/
    protected static function agregar_ejemplar_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO ejemplar VALUE(null, :codigo, :libro, :estado)");
        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->bindParam(":libro", $datos['libro']);
        $sql->bindParam(":estado", $datos['estado']);               
        $sql->execute();
        return $sql;   
    }

/**Funcion para actualizar un ejemplar  */
protected static function actualizar_ejemplar_modelo($datos){
    $sql = principalModelo::conectar()->prepare("UPDATE ejemplar SET ejemplar_codigo = :codigo, ejemplar_libro = :libro, ejemplar_estado = :estado WHERE ejemplar_id = :id AND ejemplar_id != 1");
    $sql->bindParam(":codigo", $datos['codigo']);   
    $sql->bindParam(":libro", $datos['libro']);
    $sql->bindParam(":estado", $datos['estado']);   
    $sql->bindParam(":id", $datos['id']);
    $sql->execute();
    return $sql;
}

  /**Funcion para eliminar un ejemplar */
protected static function eliminar_ejemplar_modelo($id){
    $sql = principalModelo::conectar()->prepare("DELETE FROM ejemplar WHERE ejemplar_id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    return $sql;
}
}