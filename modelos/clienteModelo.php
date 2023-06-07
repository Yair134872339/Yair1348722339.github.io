<?php

require_once "principalModelo.php";

class clienteModelo extends principalModelo{
    
    /**Función para seleccionar un cliente*/
    protected static function seleccionar_cliente_modelo($tipo, $id){
        if($tipo == "unico"){
            $sql = principalModelo::conectar()->prepare("SELECT * FROM cliente WHERE cliente_id = :id");
            $sql->bindParam(":id", $id);
        }elseif($tipo == "contar"){
            $sql = principalModelo::conectar()->prepare("SELECT cliente_id FROM cliente WHERE cliente_id != '1'");
        }
        $sql->execute();
        return $sql;
    }

    /**Función apra agregar un cliente*/
    protected static function agregar_cliente_modelo($datos){
        $sql = principalModelo::conectar()->prepare("INSERT INTO cliente VALUE(null, :nombre, :apellido, :direccion, :telefono)");
        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":direccion", $datos['direccion']);
        $sql->bindParam(":telefono", $datos['telefono']);                 
        $sql->execute();
        return $sql;   
    }

/**Funcion para actualizar un cliente  */
protected static function actualizar_cliente_modelo($datos){
    $sql = principalModelo::conectar()->prepare("UPDATE cliente SET cliente_nombre = :nombre, cliente_apellido = :apellido, cliente_direccion = :direccion, cliente_telefono = :telefono WHERE cliente_id = :id AND cliente_id != 1");
    $sql->bindParam(":nombre", $datos['nombre']);   
    $sql->bindParam(":apellido", $datos['apellido']);
    $sql->bindParam(":direccion", $datos['direccion']);
    $sql->bindParam(":telefono", $datos['telefono']);   
    $sql->bindParam(":id", $datos['id']);
    $sql->execute();
    return $sql;
}

  /**Funcion para eliminar un cliente */
protected static function eliminar_cliente_modelo($id){
    $sql = principalModelo::conectar()->prepare("DELETE FROM cliente WHERE cliente_id = :id");
    $sql->bindParam(":id", $id);
    $sql->execute();
    return $sql;
}

protected static function seleccionar_tabla_modelo($tipo) {
    if($tipo == "cliente"){
        $sql = principalModelo::conectar()->query("SELECT * FROM cliente");
    }elseif($tipo == "cliente"){
        $sql = principalModelo::conectar()->prepare("SELECT * FROM cliente");
    }
    $sql->execute();
    return $sql;
}
}