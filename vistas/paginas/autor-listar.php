<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar los autores
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
<div class="container">
	<div class="px-3">
		<div class="card">
			<div class="card-body">
				<?php
				require_once "./controladores/autorControlador.php";
				$controlador_autor = new autorControlador();
				echo $controlador_autor->listar_autor_controlador($pagina[1], 10, $_SESSION['privilegio_b'], $_SESSION['id_b'], $pagina[0], "");
				?>
			</div>
		</div>
	</div>		
</div>