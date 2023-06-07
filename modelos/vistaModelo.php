<?php

class vistaModelo
{

    /*==== Modelo para obtener las vistas ====*/
    protected static function obtener_vistas_modelo($vistas)
    { /*insertar los menus*/
        $listaBlanca = ["home","usuario-nuevo", "usuario-listar", "usuario-buscar", "usuario-editar", "usuario-eliminar", "libro-nuevo", "libro-listar", "libro-buscar", "libro-editar", "libro-eliminar", "autor-nuevo", "autor-listar", "autor-editar","autor-eliminar", "autor-buscar", "categoria-nuevo", "categoria-listar", "categoria-editar", "categoria-buscar", "categoria-eliminar",
        "ejemplar-nuevo", "ejemplar-listar", "ejemplar-editar", "ejemplar-buscar", "ejemplar-eliminar", "editorial-nuevo", "editorial-listar", "editorial-editar", "editorial-eliminar", "editorial-buscar",
        "prestamo-nuevo", "prestamo-listar", "prestamo-editar", "prestamo-eliminar", "prestamo-buscar",
        "cliente-nuevo", "cliente-listar", "cliente-editar", "cliente-eliminar", "cliente-buscar"]; 
        if (in_array($vistas, $listaBlanca)) {
            if (is_file("./vistas/paginas/" . $vistas . ".php")) {
                $contenido = "./vistas/paginas/" . $vistas . ".php";
            } else {
                $contenido = "404";
            }
        } else if ($vistas == "login" || $vistas == "index") {
            $contenido = "login";
        } else {
            $contenido = "404";
        }
        return $contenido;
    }
}
