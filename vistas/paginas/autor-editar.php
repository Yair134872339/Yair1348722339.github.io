<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de editar los autores
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>autor-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de autores</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>autor-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un autor</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>autor-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar autor</a>			
		</li>
	</ul>
</div>
<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/autorControlador.php";
				$controlador_autor = new autorControlador();
				$datos_autor = $controlador_autor->Seleccionar_autor_controlador("unico", $pagina[1]);
				if ($datos_autor->rowCount() == 1) {
					$campos = $datos_autor->fetch();
				?>
					<form action="<?php echo urlServidor; ?>rutas/autorRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="autor_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Informacion Personal
							</legend>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="autor_nombre_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['autor_nombre']; ?>">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="autor_apellido_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['autor_apellido']; ?>">
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