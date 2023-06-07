<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de la categoria
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>categoria-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de las categorias </a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>categoria-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar una categoria</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>categoria-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar categoria</a>			
		</li>
	</ul>
</div>
<div class="container">
	<div class="px-3">
		<div class="card">
			<div class="card-body">
				<?php
				require_once "./controladores/categoriaControlador.php";
				$controlador_categoria = new categoriaControlador();
				echo $controlador_categoria->listar_categoria_controlador($pagina[1], 10, $_SESSION['privilegio_b'], $_SESSION['id_b'], $pagina[0], "");
				?>
			</div>
		</div>
	</div>		
</div>