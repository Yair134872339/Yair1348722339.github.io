<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de editar las cliente
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>cliente-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de clientees</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>cliente-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar una cliente</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>cliente-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar cliente</a>			
		</li>
	</ul>
</div>
<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/clienteControlador.php";
				$controlador_cliente = new clienteControlador();
				$datos_cliente = $controlador_cliente->Seleccionar_cliente_controlador("unico", $pagina[1]);
				if ($datos_cliente->rowCount() == 1) {
					$campos = $datos_cliente->fetch();
				?>
					<form action="<?php echo urlServidor; ?>rutas/clienteRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="cliente_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Informacion Personal
							</legend>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="cliente_nombre_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['cliente_nombre']; ?>">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="cliente_apellido_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['cliente_apellido']; ?>">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="cliente_direccion_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['cliente_direccion']; ?>">
								</div>
							</div>
                            <div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="cliente_telefono_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['cliente_telefono']; ?>">
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