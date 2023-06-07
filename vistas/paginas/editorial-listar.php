<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar editorial
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>editorial-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de editorial</a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>editorial-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar un editorial</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>editorial-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar editorial</a>			
		</li>
	</ul>
</div>
<div class="container">
	<div class="px-3">
		<div class="card">
			<div class="card-body">
				<?php
				require_once "./controladores/editorialControlador.php";
				$controlador_editorial = new editorialControlador();
				echo $controlador_editorial->listar_editorial_controlador($pagina[1], 10, $_SESSION['privilegio_b'], $_SESSION['id_b'], $pagina[0], "");
				?>
			</div>
		</div>
	</div>		
</div>