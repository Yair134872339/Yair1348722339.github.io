<!-- siderbar-->
<section class="full-box dashboard-sideBar">
    <div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
    <div class="full-box dashboard-sideBar-control scroll">
        <!--titulo del sidebard-->
        <div class="full-box dashboard-sideBar-title text-uppercase text-center titulos p-2">
            <?php echo empresa;?>
            <i class="fas fa-times btn-menu-dashboard invisible"></i>
        </div>
        <!--informacion del usuario del sidebar -->
        <div class="full-box dashboard-sideBar-userInfo">
            <figure class="full-box">
                <img src="<?php echo urlServidor; ?>public/imagenes/sami.jpg" alt="icono de Usuario">
                <figcaption class="text-center pt-3"><?php echo $_SESSION['nombre_b']." ". $_SESSION['apellido_b']; ?></figcaption>
            </figure>
            <ul class ="full-box list-unstyled text-center">
                <li>
                    <a href="<?php echo urlServidor."usuario-editar/".$_SESSION['id_b']; ?>/"
                    title="Mis datos">
                        <i class="fa-solid fa-user-gear"></i>
                    </a>
                </li>
                <li>
                    <a title="Salir del sistema" class="btn-cerrar-sesion">
                        <i class="fa-solid fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
        
        <!--Menu del sidebar -->
                <ul class="full-box list-unstyle dashboard-sideBar-Menu pt-2">
                    <li>
                        <a href="<?php echo urlServidor; ?>home/">
                            <i class="fab fa-dashcube fa-fw"></i>
                            HOME
                        </a>
                    </li>
                    <li>
                        <a href="" class="btn-sideBar-SubMenu">
                            <i class="fas fa-store fa-fw"></i>
                            BIBLIOTECA
                            <i class="fas fa-caret-down float-end"></i>
                        </a>
                        <ul class="full-box list-unstyle">
                            <li>
                                <a href="<?php echo urlServidor; ?>prestamo-listar/">
                                    <i class="fa-solid fa-copy"></i>
                                    PRESTAMOS
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo urlServidor; ?>ejemplares-listar/">
                                    <i class="fa-solid fa-book-atlas"></i>
                                    EJEMPLARES
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo urlServidor; ?>libro-listar/">
                                    <i class="fas fa-user"></i>
                                    LIBROS
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo urlServidor; ?>cliente-listar/">
                                    <i class="fa-solid fa-book"></i>
                                    CLIENTES
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="" class="btn-sideBar-SubMenu">
                            <i class="fas fa-window-restore fa-fw"></i>
                            MODULOS
                            <i class="fas fa-caret-down float-end"></i>
                        </a>
                        <ul class="full-box list-unstyle">
                            <li>
                                <a href="<?php echo urlServidor; ?>autor-listar/">
                                    <i class="fa-solid fa-copy"></i>
                                    AUTOR
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo urlServidor; ?>editorial-listar/">
                                    <i class="fa-solid fa-book-atlas"></i>
                                    EDITORIAL
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo urlServidor; ?>categoria-listar/">
                                    <i class="fas fa-user"></i>
                                    CATEGORIAS
                                </a>
                            </li>                        
                        </ul>
                    </li>

                    <li>
                        <a href="" class="btn-sideBar-SubMenu">
                            <i class="fas fa-cog fa-fw"></i>
                            CONFIGURACION
                            <i class="fas fa-caret-down float-end"></i>
                        </a>
                        <ul class="full-box list-unstyle">
                            <li>
                                <a href="">
                                    <i class="fas fa-database fa-fw"></i>
                                    BACKUP
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fas fa-file-pdf fa-fw"></i>
                                    REPORTES
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
        </div>
</section>