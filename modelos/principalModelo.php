<?php

if ($peticionRuta) {
    require_once "../config/server.php";
} else {
    require_once "./config/server.php";
}

class principalModelo{
    /**Funcion conectar a la BD */
    protected static function conectar(){
        $conexion = new PDO(pdo, usuario, clave);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }

    /**Funcion para ejecutar consultas simples */
    protected static function ejecutar_consulta_simple($consulta){
        $sql = self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    /**Funcion encriptar cadenas */
    public function encriptar($cadena){
        $salida = false;
        $lp = hash('sha256', llave_primaria);
        $li = substr(hash('sha256', llave_inversa), 0, 16);
        $salida = openssl_encrypt($cadena, metodo, $lp, 0, $li);
        $salida = base64_encode($salida);
        return $salida;
    }

    /**Funcion desencriptar cadenas */
    protected static function desencriptar($cadena){
        $lp = hash('sha256', llave_primaria);
        $li = substr(hash('sha256', llave_inversa), 0, 16);
        $salida = openssl_decrypt(base64_decode($cadena), metodo, $lp, 0, $li);
        return $salida;
    }

    /**Funcion verificar datos */
    protected static function verificar_datos($filtro, $cadena){
        if (preg_match("/^" . $filtro . "$/", $cadena)) {
            return false;
        } else {
            return true;
        }
    }

    /**Funcion limpiar cadena */
    protected static function limpiar_cadena($cadena){
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src>", "", $cadena);
        $cadena = str_ireplace("<script type>", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(" ;", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        $cadena = stripslashes($cadena);
        $cadena = trim($cadena);
        return $cadena;
    }

    /***función para paginar tablas*/
    protected static function paginador_tablas($pagina, $npaginas, $url, $botones){
        $tabla = '
        <div class = "col-md-6 col-12">
            <nav aria-label="page navigation">
                <ul class = "pagination pagination-sm float-md-end justify-content-center 
                mb-0">
';
        if ($pagina <= 1) {
            $tabla.= '
                    <li class = "page-item disabled">
                    <a class = "page-link">
                        <i class = "fa-solid fa-angles-left"></i> 
                    </a>
                    </li>   
        ';
        } else {
            $tabla.= '
            <li class="page-item">
               <a href="' .$url.($pagina - 1). '/" class="page-link">
                  <i class="fa-solid fa-angles-left"></i>
               </a>
            </li>
            <li class "page-item">
                <a class="page-link" href="' .$url. '1/">1</a>
            </li>
            <li class="page-item">
                <a class = "page-link">
                   <i class = "fa-solid fa-ellipsis"></i>
                </a>
            </li>
            ';
        }
        $aux = 0;
        for ($i = $pagina; $i <= $npaginas; $i++) {
            if ($aux >= $botones) {
                break;
            }
            if ($pagina == $i) {
                $tabla.= '
                <li class="page-item active" aria-current="page">
                   <a href="' .$url. $i. '/" class = "page-link">' .$i. '</a>
                </li>';
            } else {
                $tabla.= '
                <li class="page-item">
                   <a href="' .$url.$i. '/" class = "page-link">' .$i. '</a>
                </li>';
            }
            $aux++;
        }
        if ($pagina == $npaginas) {
            $tabla.= '
            <li class = "page-item disable">
               <a class = "page-link">
                 <i class = "fa-solid fa-angles-right"></i>
               </a>
            </li>     
    ';
        } else {
            $tabla.= '
            <li class="page-item">
               <a class="page-link">
                 <i class= "fa-solid fa-ellipsis"></i>
               </a>
            </li>
            <li class="page-item">
               <a href="'.$url.$npaginas. '"class="page-link">' .$npaginas. '</a>
            </li>
            <li class="page-item">
               <a href="'.$url($pagina + 1).'/" class="page-link">
                 <i class="fa-solid fa-angles-right"></i>
               </a>
            </li>
    ';
        }
        $tabla.= '
                    </ul>
              </nav>
        </div>
        ';
        return $tabla;
    }
}
