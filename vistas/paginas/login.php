<div class="full-box container-login cover">
    <form action="" method="post" class="form-login" autocomplete="off">
        <p class="text-center"><i class="fa-solid fa-circle-user fa-4x"></i></p>
        <p class="text-center text-uppercase titulos mb-0">Inicia sesión con tu cuenta</p>
        <div class="p-3">
            <input type="text" name="login_usuario" class="form-control form-control-sm input-login text-center">
        </div>
        <div class="p-3">
            <input type="password" name="login_clave" class="form-control form-control-sm input-login text-center">
        </div>
        <div class="text-center pt-2">
            <button type="submit" class="btn btn-login">Entrar al sistema</button>
        </div>
    </form>
</div>
<?php
if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
    require_once "./controladores/loginControlador.php";
    $controlador_login = new loginControlador();
    echo $controlador_login->iniciar_sesion_controlador();
}