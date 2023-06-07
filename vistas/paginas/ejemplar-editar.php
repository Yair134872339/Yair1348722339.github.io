<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de editar los ejemplar
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>ejemplar-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de ejemplar</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>ejemplar-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un ejemplar</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>ejemplar-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar ejemplar</a>			
		</li>
	</ul>
</div>
<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/ejemplarControlador.php";
				$controlador_ejemplar = new ejemplarControlador();
				$datos_ejemplar = $controlador_ejemplar->Seleccionar_ejemplar_controlador("unico", $pagina[1]);
				if ($datos_ejemplar->rowCount() == 1) {
					$campos = $datos_ejemplar->fetch();
				?>
					<form action="<?php echo urlServidor; ?>rutas/ejemplarRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="ejemplar_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Informacion Personal
							</legend>
                            <div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="ejemplar_codigo_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['ejemplar_codigo']; ?>">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="ejemplar_nombre_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['ejemplar_nombre']; ?>">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="ejemplar_estado_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['ejemplar_estado']; ?>">
								</div>
							</div>														
								<div class="text-center mt-2">
									<button type="submit" class="btn btn-success">Actualizar</button>
									<button type="reset" class="btn btn-danger">Cancelar</button>
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