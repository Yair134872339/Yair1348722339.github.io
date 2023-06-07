<div class="container">
	<h3 class="text-uppercase p-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de la cliente
</h3>
</div>
<div class="container">
	<ul class="full-box list-unstyled page-tabs">
		<li>
				<a href="<?php echo urlServidor; ?>cliente-listar/"><i class="fa-solid fa-clipboard-list fa-fw"></i>&nbsp; Lista de las clientes </a>
		</li>
		<li>		
				<a href="<?php echo urlServidor; ?>cliente-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp; Agregar una cliente</a>
		</li>
		<li>
				<a href="<?php echo urlServidor; ?>cliente-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar cliente</a>			
		</li>
	</ul>
</div>
<div class="container">
	<div class="px-3">
		<div class="card">
			<div class="card-body">
				<?php
				require_once "./controladores/clienteControlador.php";
				$controlador_cliente = new clienteControlador();
				echo $controlador_cliente->listar_cliente_controlador($pagina[1], 10, $_SESSION['privilegio_b'], $_SESSION['id_b'], $pagina[0], "");
				?>
			</div>
		</div>
	</div>		
</div>