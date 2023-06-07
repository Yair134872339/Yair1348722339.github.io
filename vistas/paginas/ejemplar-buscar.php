
<div class="container">
    <h3 class="text-uppercase px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i>modulo de buscar un ejemplar</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
    <li>
      <a href="<?php echo urlServidor; ?>ejemplar-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i> &nbsp; Lista de ejemplar</a>
        </li>
        <li>
            <a href="<?php echo urlServidor; ?>ejemplar-buscar/"><i class="fa-solid fa-magnifying-glas fa-fw"></i> &nbsp; buscar ejemplar</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3">
        <div class="card">
            <div class="card-body">
                <?php if(!isset($_SESSION['busqueda_ejemplar']) && empty($_SESSION['busqueda_ejemplar'])) { ?>
                    <form action="<?php echo urlServidor; ?>rutas/buscadorRuta.php" method="post" class="Formulario" data-form="default" autovomplete="off">
                        <input type="hidden" name="modulo" value="ejemplar">
                            <div class=contairner">
                                <div class="row justify-content-center"> 
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" name="buscar_palabra" class="form-control form-control-sm" placeholder="¿que ejemplar estas buscando?">
                                        </div>
                                    </div>
                                    <div classs="col-lg-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-search"></i>&nbsp;Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php } else { ?>
                            <form action="<?php echo urlServidor; ?>rutas/buscadorRuta.php" method= "post" class="Formulario" data-form="buscar" autocomplete="off">
                            <input type="hidden" name="modulo" value="ejemplar">
                            <input type="hidden" name="eliminar_busqueda" value="eliminar">
                            <div class="contairner text-center">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-0">
                                            <p>Resultados de la busqueda <strong><?php echo $_SESSION['busqueda_ejemplar']; ?>
                                        </strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class=fa-solid fa-trash"></i>&nbsp;Eliminar busqueda</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            <?php
                require_once "./controladores/ejemplarControlador.php";
                $controlador_ejemplar = new ejemplarControlador();
                echo $controlador_ejemplar->listar_ejemplar_controlador($pagina [1], 10, $_SESSION['privilegio_b'],
                $_SESSION['id_b'], $pagina[0], $_SESSION['busqueda_ejemplar']);
            }
            ?>
            </div>
        </div>
    </div>
</div>