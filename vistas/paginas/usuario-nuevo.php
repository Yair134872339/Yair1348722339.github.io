<div class="container">
    <h3 class="text-uppercase text-center px-3 py-4"><i class="fa-solid fa-user-tie fa-fw"></i> Modulo de listar un
        usuario</h3>
</div>
<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>usuario-listar/"><i class="text-info fa-solid fa-clipboard-list fa-fw"></i>
                    &nbsp;
                    Lista de usuario</a>
            </span>

        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>usuario-nuevo/"><i class="text-success fa-solid fa-plus fa-fw"></i>
                    &nbsp;
                    Agregar  usuario</a>
            </span>

        </li>
        <li>
            <span class="">
                <a href="<?php echo urlServidor; ?>usuario-buscar/"><i class="text-warning fa-solid fa-magnifying-glass fa-fw"></i>
                    &nbsp;
                    Buscar  usuario</a>
            </span>
        </li>
    </ul>
</div>
<div class="container">
    <div class="px-3" style="width: 67rem;">
        <div class="card">
            <div class="card-body">
            <form action="<?php echo urlServidor; ?>rutas/usuarioRuta.php" method="post" class="Formulario" data-form="guardar">
                    <div class="row"><i class="fa-solid fa-address-card mb-3"> Informacion Personal</i>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_nombre_guardar" type="text" class="form-control"
                                    placeholder="Nombre del usuario">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_apellido_guardar" type="text" class="form-control"
                                    placeholder="Apellidos del usuario">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_telefono_guardar" type="text" class="form-control" placeholder="Telefono del usuario">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_direccion_guardar" type="text" class="form-control" placeholder="Dirección del usuario">
                            </div>
                        </div>
                        <div class=" row"><i class="fa-solid fa-user-lock mb-3"> Informacion de la cuenta</i></div>
                        <div class="col-lg-7 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_correo_guardar"type="text" class="form-control" placeholder="Correo del usuario">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_usuario_guardar"type="text" class="form-control" placeholder="Cuenta del usuario">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_clave_uno_guardar" type="password" class="form-control" placeholder="Contraseña del usuario">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <input name="usuario_clave_dos_guardar" type="password" class="form-control" placeholder="Verificar contraseña">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-outline mb-3">
                                <select name="usuario_estado_guardar" class="form-select" aria-label="Default select example">
                                    <option selected>Estado de la cuenta</option>
                                    <option value="Habilitada">1.-Habilitada</option>
                                    <option value="Desabilitada">2.-Desabilitada</option>
                                    <option value="Bloqueada">3.-Bloqueada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-outline mb-3">
                                <select name="usuario_privilegio_guardar" class="form-select" aria-label="Default select example">
                                    <option selected>Privilegios del usuario</option>
                                    <option value="1">1.- Registrar, actualizar y borrar</option>
                                    <option value="2">2.- Registrar y actializar</option>
                                    <option value="3">3.- Registrar</option>
                                </select>
                            </div>
                        </div>
                        <!-- Botones  -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary">Guardar</button>
                            <button type="reset" class="btn btn-primary">Limpiar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>