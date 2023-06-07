<div class="container">
    <h3 class="text-uppercase text-center px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar la cliente</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>cliente-listar/"><i class="text-info fa-solid fa-clipboard-list fa-fw"></i>
                    &nbsp;
                    Lista de cliente</a>
            </span>

        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>cliente-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i>
                    &nbsp;
                    Agregar  cliente</a>
            </span>
        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>cliente-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i>
                    &nbsp;
                    Buscar cliente</a>
            </span>
        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3" style="width: 67rem;">
        <div class="card">
            <div class="card-body">
            <form action="<?php echo urlServidor; ?>rutas/clienteRuta.php" method="post" class="Formulario" data-form="guardar">                  
            <div class="row"><i class="fa-solid fa-address-card mb-3"> Informacion del cliente</i>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="cliente_nombre_guardar" type="text" class="form-control form-control-sm text-center"
                                    placeholder="Nombre del cliente">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="cliente_apellido_guardar" type="text" class="form-control form-control-sm text-center"
                                    placeholder="Apellidos del cliente">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="cliente_telefono_guardar" type="text" class="form-control form-control-sm text-center" placeholder="Telefono del cliente">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="cliente_direccion_guardar" type="text" class="form-control form-control-sm text-center" placeholder="Dirección del cliente">
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