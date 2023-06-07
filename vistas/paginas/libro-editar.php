<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de editar los libro
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>libro-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de libro</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>libro-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un libro</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>libro-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar libro</a>			
		</li>
	</ul>
</div>
<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/libroControlador.php";
				$controlador_libro = new libroControlador();
				$datos_libro = $controlador_libro->Seleccionar_libro_controlador("unico", $pagina[1]);
				if ($datos_libro->rowCount() == 1) {
					$campos = $datos_libro->fetch();
				?>
					<form action="<?php echo urlServidor; ?>rutas/libroRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="libro_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Actualizar libro
							</legend>
							<div class="container">
                        <legend class="text-center text-uppercase fs-6 mb-3">Información general</legend>
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="mb-4">
                                    <input type="text-center" name="libro_codigo_actualizar" class="form-control form-control-sm text-center" value="<?php echo $campos['libro_codigo']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-12">
                                <div class="mb-4">
                                    <input type="text-center" name="libro_titulo_actualizar" class="form-control form-control-sm text-center" value="<?php echo $campos['libro_titulo']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-4">
                                    <select name="libro_autor_actualizar" class="form-select form-select-sm text-center" value="<?php echo $campos['libro_autor']; ?>">> 
                                        <?php
                                        require_once "./controladores/libroControlador.php";
                                        $controlador_libro = new libroControlador();
                                        $datos_autor = $controlador_libro->seleccionar_tabla_controlador("autores");
                                        if ($datos_autor->rowCount() > 0) {
                                            $autores = $datos_autor->fetchAll();
                                        ?>
                                            <option value="" selected> Seleccione un autor</option>
                                            <?php foreach ($autores as $autor) { ?>
                                                <option value="<?php echo $autor['autor_id']; ?>"><?php echo $autor['autor_nombre'].' '.$autor['autor_apellido']; ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="" selected>No hay autores registrados</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="mb-4">
                                    <select name="libro_editorial_actualizar" class="form-select form-select-sm text-center" arial-label="Default select example">
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
                                    <select name="libro_categoria_actualizar" class="form-select form-select-sm text-center" arial-label="Default select example">
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
														
								<div class="text-center mt-2">
									<button type="submit" class="btn btn-sm btn-success">Actualizar</button>
									<button type="reset" class="btn btn-sm btn-danger">Cancelar</button>
								</div>
							</div>
					</form>
				<?php } else {
				?>
					<div class="alert alert-danger text-center mb-0" role="alert">
						<p><i class="fa-solid fa-circle-info fa-5x"></i></p>
						<h5>¡Ocurrió un error!</h5>
						<p class="mb-0">No podemos mostrar la información solicitada.</p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</body>