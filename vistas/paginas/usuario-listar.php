<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar un usuario
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>usuario-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de usuario</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>usuario-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar  usuario</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>usuario-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar  usuario</a>			
		</li>
	</ul>
</div>
<div class="container">
	<div class="px-3">
		<div class="card">
			<div class="card-body">
				<?php
				require_once "./controladores/usuarioControlador.php";
				$controlador_usuario = new usuarioControlador();
				echo $controlador_usuario->listar_usuario_controlador($pagina[1], 10, $_SESSION['privilegio_b'], $_SESSION['id_b'], $pagina[0], "");
				?>
			</div>
		</div>
	</div>		
</div>