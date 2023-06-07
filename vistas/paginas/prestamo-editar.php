<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de editar los prestamo
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>prestamo-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de prestamo</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>prestamo-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un prestamo</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>prestamo-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar prestamo</a>			
		</li>
	</ul>
</div>
<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/prestamoControlador.php";
				$controlador_prestamo = new prestamoControlador();
				$datos_prestamo = $controlador_prestamo->Seleccionar_prestamo_controlador("unico", $pagina[1]);
				if ($datos_prestamo->rowCount() == 1) {
					$campos = $datos_prestamo->fetch();
				?>
					<form action="<?php echo urlServidor; ?>rutas/prestamoRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="prestamo_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Actualizar prestamo
							</legend>
                            <div class="col-lg-5 col-md-4 col-12">
								<div class="mb-3">
									<input name="prestamo_codigo_actualizar" type="text-center" class="form-control form-control-sm" value="<?php echo $campos['prestamo_codigo']; ?>">
								</div>
							</div>
							<div class="text-center col-lg-5 col-md-4 col-12">
								<div class="mb-3">
									<input name="prestamo_nombre_actualizar" type="text-center" class="form-control form-control-sm" value="<?php echo $campos['prestamo_nombre']; ?>">
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