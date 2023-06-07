<script>
/**ventana para cerrar sesión */
let btn_cerrar_sesion = document.querySelector('.btn-cerrar-sesion');

btn_cerrar_sesion.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta a punto de cerrar la sesión y salir del sistema',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#14A44D',
        cancelButtonColor: '#DC4C64',
        confirmButtonText: 'Salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            let url = '<?php echo urlServidor ?>rutas/loginRuta.php';
            let nombre = '<?php echo $_SESSION['nombre_b'] ?> ';
            let usuario = '<?php echo $_SESSION['usuario_b'] ?>';
            let datos = new FormData();
            datos.append("nombre", nombre);
            datos.append("usuario", usuario);

            fetch(url, {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                return alertas_ajax(respuesta);
            });
        }
    });
});
</script>