import './bootstrap';
import Swal from 'sweetalert2';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Swal = Swal;

document.addEventListener('submit', function (event) {
	const form = event.target;

	if (!(form instanceof HTMLFormElement)) {
		return;
	}

	const confirmMessage = form.dataset.swalConfirm;

	if (!confirmMessage) {
		return;
	}

	event.preventDefault();

	Swal.fire({
		icon: 'warning',
		title: 'Tem certeza?',
		text: confirmMessage,
		showCancelButton: true,
		confirmButtonText: 'Sim, excluir',
		cancelButtonText: 'Cancelar',
		reverseButtons: true,
		confirmButtonColor: '#dc2626',
		cancelButtonColor: '#6b7280',
	}).then((result) => {
		if (result.isConfirmed) {
			form.submit();
		}
	});
});

Alpine.start();
