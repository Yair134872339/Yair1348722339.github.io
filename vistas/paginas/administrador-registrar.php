<div class="container">
    <h3 class="text-uppercase px-3 py-4"><i class="fa-solid fas fa-user-lock fa-fw"></i> Registro de Administrador</h3>
</div>

<div class="container">
    <ul class="full-box list-unstyled page-tabs">
        <li>
            <a href="<?php echo urlServidor; ?>home/"class="active"><i class="fa-solid fa-clipboard-list fa-fw"></i> &nbsp; Inicio </a>
        </li>
        <li>
            <a href="<?php echo urlServidor; ?>administrador-registrar/"><i class="fa-solid fa-plus fa-fw"></i> &nbsp; Registro de administrador</a>
        </li>
    </ul>
</div>
<div class="container" style="width: 50rem;">
    <div class="card">
        <div class="col-sm-8 offset-3 mt-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo </label>
                <input class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre de usuario</label>
                <input class="form-control">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electronico </label>
                        <input type="email" class="form-control" id="exampleFormControlInput1"
                            placeholder="nombre@ejemplo.com">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" placeholder="De 8-15 caracteres">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-warning" type="">Limpiar</button>
                <button class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>