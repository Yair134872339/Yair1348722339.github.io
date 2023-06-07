<div class="container">
    <h3 class="text-uppercase text-center px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar un autor</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>autor-listar/"><i class="text-info fa-solid fa-clipboard-list fa-fw"></i>&nbsp;Lista de autores</a>
            </span>
        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>autor-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i> &nbsp;Agregar  autor</a>
            </span>
        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>autor-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i> &nbsp; Buscar  autor</a>
            </span>
        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3" style="width: 67rem;">
        <div class="card">
            <div class="card-body">
            <form action="<?php echo urlServidor; ?>rutas/autorRuta.php" method="post" class="Formulario" data-form="guardar">  
            <legend class="text-center text-uppercase fs-6 mb-3">Información general</legend>
                        <div class="row">                                                               
                        <div class="col-lg-6 col-md-3 col-12">
                            <div class="mb-4">
                                <input name="autor_nombre_guardar" type="text-center" class="form-control form-control-sm text-center"
                                    placeholder="Nombre  del autor">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-3 col-12">
                            <div class="mb-4">
                                <input name="autor_apellido_guardar" type="text-center" class="form-control form-control-sm text-center" placeholder="apellido del autor">
                            </div>
                        </div>                        
                        
                        <!-- Botones  -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-secondary">Guardar</button>
                            <button type="reset" class="btn btn-sm btn-primary">Limpiar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>