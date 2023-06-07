<div class="container">
    <h3 class="text-uppercase text-center px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar un
        ejemplar</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>ejemplar-listar/"><i class="text-info fa-solid fa-clipboard-list fa-fw"></i>
                    &nbsp;
                    Lista de ejemplar</a>
            </span>

        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>ejemplar-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i>
                    &nbsp;
                    Buscar  ejemplar</a>
            </span>
        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3" style="width: 67rem;">
        <div class="card">
            <div class="card-body">
            <?php
			require_once "./controladores/libroControlador.php";
			$controlador_libro = new libroControlador();
			$datos_libro = $controlador_libro->Seleccionar_libro_controlador("unico", $pagina[1]);
			if ($datos_libro->rowCount() == 1) {
				$campo = $datos_libro->fetch();
			?>
            <form action="<?php echo urlServidor; ?>rutas/ejemplarRuta.php" method="post" class="Formulario" data-form="guardar">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="ejemplar_codigo_guardar" type="text" class="form-control form-control-sm"
                                    placeholder="Codigo del ejemplar">
                            </div>
                        </div>
                        <input type="hidden" name="ejemplar_libro_guardar" value="<?php echo $pagina[1]; ?>">
                        <div class="col-lg-5 col-md-6 col-12">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-sm text-center" value="<?php echo $campo
                                ['libro_titulo']; ?>" disabled>
                            </div>
                        </div>  
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <select name="ejemplar_estado_guardar" class="form-select form-select-sm">
                                    <option value="Disponible">Disponible</option>
                                    <option value="Maltratado">Maltratado</option>
                                </select>
                            </div>
                        </div>                     
                        
                        <!-- Botones  -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-secondary">Guardar</button>
                            <button type="reset" class="btn btn-sm btn-primary+">Limpiar</button>
                        </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>