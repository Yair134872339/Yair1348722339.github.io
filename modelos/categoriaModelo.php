<?php

require_once "principalModelo.php";

class categoriaModelo extends principalModelo{
    
    /**Función para seleccionar un usuario*/
    protected static function seleccionar_categoria_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM categoria WHERE categoria_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT categoria_id FROM categoria WHERE categoria_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un usuario*/
    protected static function agregar_categoria_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO categoria VALUE(null, :nombre)");        
        $sql->bindParam(":nombre", $datos['nombre']);                
        $sql->execute();
        return $sql;   
    }
 /**Funcion para actualizar un categoria  */
 protected static function actualizar_categoria_modelo($datos){
    $sql = principalModelo::conectar()->prepare("UPDATE categoria SET categoria_nombre = :nombre WHERE categoria_id = :id AND categoria_id != 1");
    $sql->bindParam(":nombre", $datos['nombre']);       
    $sql->bindParam(":id", $datos['id']);
    $sql->execute();
    return $sql;
}

  /**Funcion para eliminar un categoria */
protected static function eliminar_categoria_modelo($id){
    $sql = principalModelo::conectar()->prepare("DELETE FROM categoria WHERE categoria_id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    return $sql;
}
}