<div class="container">
	<h3 class="text-uppercase text-center px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de usuarios</h3>
</div>
<?php if ($_SESSION['privilegio_b'] == 1) { ?>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
		<a href="<?php echo urlServidor; ?>usuario-listar/" ><i class="text-info fa-solid fa-clipboard-list fa-fw"></i> &nbsp; Lista de usuarios</a>
		</li>
		<li>
			<a href="<?php echo urlServidor; ?>usuario-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un usuario</a>
		</li>
		<li>
			<a href="<?php echo urlServidor; ?>usuario-buscar"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar usuario</a>
		</li>
	</ul>
</div>
<?php }
?>

<body>
	<div class="container">
		<div class="card card-body">
			<div class="row">
				<?php
				require_once "./controladores/usuarioControlador.php";
				$controlador_usuario = new usuarioControlador();
				$datos_usuario = $controlador_usuario->Seleccionar_usuario_controlador("unico", $pagina[1]);
				if ($datos_usuario->rowCount() == 1) {
					$campos = $datos_usuario->fetch();
				?>

					<form action="<?php echo urlServidor; ?>rutas/usuarioRuta.php" method="post" class="Formulario" data-form="actualizar" autocomplete="off">
						<div class="row">
							<input type="hidden" name="usuario_id_actualizar" value="<?php echo $pagina[1]; ?>">
							<legend class="mb-3"><i class="fa-regular fa-address-card"></i>&nbsp; Informacion Personal
							</legend>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="usuario_nombre_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['usuario_nombre']; ?>">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="usuario_apellido_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['usuario_apellido']; ?>">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="mb-3">
									<input name="usuario_telefono_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['usuario_telefono']; ?>">
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-12">
								<div class="mb-3">
									<input name="usuario_direccion_actualizar" type="text" class="form-control form-control-sm" value="<?php echo $campos['usuario_direccion']; ?>">
								</div>
							</div>
							<legend class="mb-3"><i class="fa-solid fa-user-lock mb-3"></i>&nbsp; Informacion de la cuenta
							</legend>

							<div class="col-lg-6 col-md-6 col-12">
								<div class="mb-3">
									<input type="email" name="usuario_correo_actualizar" class="form-control form-control-sm" value="<?php echo $campos['usuario_correo']; ?>">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12">
								<div class="mb-3">
									<input type="text" name="usuario_usuario_actualizar" class="form-control form-control-sm" value="<?php echo $campos['usuario_usuario']; ?>">
								</div>
							</div>

							<legend class="mb-3"><i class="fa-solid fa-lock"></i>&nbsp; Nueva contraseña</legend>
							<p class="fs-7 text-center">Para actualizar la contraseña debe escribir una nueva y volver a
								escribir. En caso que no desee cambiarla debe dejar los campos en blanco.</p>

							<div class="col-md-6">
								<div class="mb-3">
									<input type="password" name="usuario_clave_uno_actualizar" class="form-control form-control-sm" placeholder="Nueva contraseña del usuario">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<input type="password" name="usuario_clave_dos_actualizar" class="form-control form-control-sm" placeholder="Confirmar la nueva contraseña del usuario">
								</div>
							</div>

							<?php if ($_SESSION['privilegio_b'] == 1 && $campos['usuario_id'] != 1) { ?>

								<div class="col-lg-6 col-md-6 col-12">
									<divc lass="mb-3">
										<select name="usuario_estado_actualizar" class="form-select form-select-sm">
											<option value="Habilitada" <?php if ($campos['usuario_estado'] == "Habilitada") {
																			echo 'selected=""';
																		} ?>> 1 - Habilitada</option>
											<option value="Desabilitada" <?php if ($campos['usuario_estado'] == "Desabilitada") {
																				echo 'selected=""';
																			} ?>> 2 - Desabilitada</option>
											<option value="Bloqueda" <?php if ($campos['usuario_estado'] == "Bloqueada") {
																			echo 'selected=""';
																		} ?>> 3 - Bloqueada</option>
										</select>
								</div>

								<div class="col-lg-6 col-md-6 col-12">
									<div class="mb-3">
										<select name="usuario_privilegio_actualizar" class="form-select form-select-sm">
											<option value="1" <?php if ($campos['usuario_privilegio'] == 1) {
																	echo 'selected=""';
																} ?>> 1 - Registrar, actualizar y borrar</option>
											<option value="2" <?php if ($campos['usuario_privilegio'] == 2) {
																	echo 'selected=""';
																} ?>> 2 - Registrar y actualizar</option>
											<option value="3" <?php if ($campos['usuario_privilegio'] == 3) {
																	echo 'selected=""';
																} ?>> 3 - Registrar</option>
										</select>
									</div>
								</div>

							<?php } ?>
							<p class="fs-7 text-center">Para actualizar los datos escriba su usuario y contraseña con la que
								inicio sesion en el sistema.</p>

							<div class="col-lg-6 col-md-6 col-12">
								<div class="mb-3">
									<input type="text" name="admin_usuario" class="form-control form-control-sm" placeholder="Usuario">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12">
								<div class="mb-3">
									<input type="password" name="admin_clave" class="form-control form-control-sm" placeholder="Contraseña">
								</div>
							</div>
							<div>
								<?php if ($_SESSION['id_b'] != $pagina[1]) { ?>
									<input type="hidden" name="tipo_cuenta" value="impropia">
								<?php } else { ?>
									<input type="hidden" name="tipo_cuenta" value="propia">
								<?php } ?>
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