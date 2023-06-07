$(document).ready(function () {
    $('.btn-sideBar-SubMenu').on('click', function (e) {
        e.preventDefault();
        var SubMenu = $(this).next('ul');
        var iconBtn = $(this).children('.fa-caret-down');
        if (SubMenu.hasClass('show-sideBar-SubMenu')) {
            iconBtn.removeClass('fa-rotate-180');
            SubMenu.removeClass('show-sideBar-SubMenu')
        } else {
            iconBtn.addClass('fa-rotate-180');
            SubMenu.addClass('show-sideBar-SubMenu');
        }
    });

    $('.btn-menu-dashboard').on('click', function (e) {
        e.preventDefault();
        var body = $('.dashboard-contentPage');
        var sidebar = $('.dashboard-sideBar');
        if (sidebar.css('pointer-events') == 'none') {
            body.removeClass('no-padding-left');
            sidebar.removeClass('hide-sideBar').addClass('show-sideBar');
        } else {
            body.addClass('no-padding-left');
            sidebar.addClass('hide-sideBar').removeClass('show-sideBar');
        }
    });
});

const Formulario = document.querySelectorAll(".Formulario");

function enviar_formulario(e) {
	e.preventDefault();

	let data = new FormData(this);
	let metodo = this.getAttribute("method");
	let action = this.getAttribute("action");
	let tipo = this.getAttribute("data-form");

	let encabezados = new Headers();

	let config = {
		method: metodo,
		headers: encabezados,
		mode: 'cors',
		cache: 'no-cache',
		body: data
	}

	let texto_alerta;

	if (tipo === "registrar") {
		texto_alerta = "Los datos quedaran guardados en el sistema.";
	} else if (tipo === "eliminar") {
		texto_alerta = "Los datos serán eliminados completamente del sistema.";
	} else if (tipo === "actualizar") {
		texto_alerta = "Los datos del sistema serán actualizados.";
	} else if (tipo === "buscar") {
		texto_alerta = "Se eliminará el término de búsqueda y tendrás que escribir uno nuevo.";
	} else {
		texto_alerta = "Quieres realizar la operación solicitada.";
	}

	Swal.fire({
		title: '¿Estás seguro?',
		text: texto_alerta,
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#00913b',
		cancelButtonColor: '#f80c35',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar',
	}).then((result) => {
		if(result.value){
			fetch(action, config)
			.then(respuesta => respuesta.json())
			.then(respuesta => {
				return alertas_ajax(respuesta);
			});
		}
	});
}

Formulario.forEach(formularios => {
	formularios.addEventListener("submit", enviar_formulario);
});

function alertas_ajax(alerta) {
	if (alerta.Alerta === "simple") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Icon,
			confirmButtonColor: '#16b5ea',
			confirmButtonText: 'Aceptar'
		});
	} else if (alerta.Alerta === "recargar") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Icon,
			confirmButtonColor: '#16b5ea',
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if (result.value) {
				location.reload();
			}
		});
	} else if (alerta.Alerta === "limpiar") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Icon,
			confirmButtonColor: '#16b5ea',
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if (result.value) {
                document.querySelector(".Formulario").reset();
			}
		});
	} else if (alerta.Alerta === "redireccionar") {
		window.location.href = alerta.URL;
	}
}