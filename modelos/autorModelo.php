<?php

require_once "principalModelo.php";

class autorModelo extends principalModelo{
    
    /**Función para seleccionar un usuario*/
    protected static function seleccionar_autor_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM autor WHERE autor_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT autor_id FROM autor WHERE autor_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un usuario*/
    protected static function agregar_autor_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO autor VALUE(null, :nombre,
        :apellido )");        
        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);             
        $sql->execute();
        return $sql;   
    }
 /**Funcion para actualizar un autor  */
 protected static function actualizar_autor_modelo($datos){
    $sql = principalModelo::conectar()->prepare("UPDATE autor SET autor_nombre = :nombre, autor_apellido = :apellido WHERE autor_id = :id AND autor_id != 1");
    $sql->bindParam(":nombre", $datos['nombre']);
    $sql->bindParam(":apellido", $datos['apellido']);   
    $sql->bindParam(":id", $datos['id']);
    $sql->execute();
    return $sql;
}

  /**Funcion para eliminar un autor */
protected static function eliminar_autor_modelo($id){
    $sql = principalModelo::conectar()->prepare("DELETE FROM autor WHERE autor_id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    return $sql;
}
}