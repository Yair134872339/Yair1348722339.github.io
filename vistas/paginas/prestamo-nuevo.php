<div class="container">
    <h3 class="text-uppercase px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar un prestamo</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>

            <a href="<?php echo urlServidor; ?>prestamo-listar/"><i class="text-info fa-solid fa-clipboard-list fa-fw"></i>
                &nbsp;
                Lista de prestamo</a>

        </li>
        <li>

            <a href="<?php echo urlServidor; ?>prestamo-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i>
                &nbsp;
                Agregar prestamo</a>


        </li>
        <li>
            <a href="<?php echo urlServidor; ?>prestamo-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i>
                &nbsp;
                Buscar prestamo</a>

        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3">
        <div class="card mb-4">
            <div class="card-body mx-4">
                <form action="<?php echo urlServidor; ?>rutas/libroRuta.php" method="post" class="Formulario" data-form="guardar">
                    <div class="container">
                        <legend class="text-center text-uppercase fs-6 mb-3">Información general</legend>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="mb-4">
                                    <input type="text" name="libro_codigo_guardar" class="form-control form-control-sm text-center" placeholder="Código del libro">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-12">
                                <div class="mb-4">
                                    <input type="text" name="libro_titulo_guardar" class="form-control form-control-sm text-center" placeholder="Titulo del libro">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-4">
                                    <select name="libro_cliente_guardar" class="form-select form-select-sm text-center" arial-label="Default select example">
                                        <?php
                                        require_once "./controladores/libroControlador.php";
                                        $controlador_libro = new libroControlador();
                                        $datos_cliente = $controlador_libro->seleccionar_tabla_controlador("clientees");
                                        if ($datos_cliente->rowCount() > 0) {
                                            $clientees = $datos_cliente->fetchAll();
                                        ?>
                                            <option value="" selected> Seleccione un cliente</option>
                                            <?php foreach ($clientees as $cliente) { ?>
                                                <option value="<?php echo $cliente['cliente_id']; ?>"><?php echo $cliente['cliente_nombre'].' '.$cliente['cliente_apellido']; ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="" selected>No hay clientees registrados</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-4">
                                    <select name="libro_editorial_guardar" class="form-select form-select-sm text-center" arial-label="Default select example">
                                        <?php
                                        $datos_editorial = $controlador_libro->seleccionar_tabla_controlador("editoriales");
                                        if ($datos_editorial->rowCount() > 0) {
                                            $editoriales = $datos_editorial->fetchAll();
                                        ?>
                                            <option value="" selected> Seleccione una editorial</option>
                                            <?php foreach ($editoriales as $editorial) { ?>
                                                <option value="<?php echo $editorial['editorial_id']; ?>">
                                                    <?php echo $editorial['editorial_nombre']; ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="" selected>No hay editoriales registrados</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-4">
                                    <select name="libro_categoria_guardar" class="form-select form-select-sm text-center" arial-label="Default select example">
                                        <?php
                                        $datos_categoria = $controlador_libro->seleccionar_tabla_controlador("categorias");
                                        if ($datos_categoria->rowCount() > 0) {
                                            $categorias = $datos_categoria->fetchAll();
                                        ?>
                                            <option value="" selected> Seleccione una categoria</option>
                                            <?php foreach ($categorias as $categoria) { ?>
                                                <option value="<?php echo $categoria['categoria_id']; ?>">
                                                    <?php echo $categoria['categoria_nombre']; ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="" selected>No hay categorias registrados</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <!-- Botones  -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-secondary">Guardar</button>
                            <button type="reset" class="btn btn-sm btn-primary">Limpiar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>