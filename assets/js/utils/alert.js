import Swal from 'sweetalert2';

export const confirmSwalMixin = Swal.mixin({
    text: 'Êtes-vous sûr de vouloir effectué cette action ?',
    showDenyButton: false,
    showCancelButton: true,
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-dim btn-secondary'
    },
    buttonsStyling: false
});

export const toastSwalMixin = Swal.mixin({
    toast: true,
    position: 'top-end',
    timer: 5000,
    showCloseButton: true,
    timerProgressBar: true,
    showConfirmButton: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

export const installServiceWorker = async (onConfirm) => {
    await Swal.fire({
            position: 'bottom',
            text: 'Une nouvelle version du site est disponible',
            confirmButtonText: 'Installer',
            cancelButtonText: 'Annuler',
            showCloseButton: true,
            showCancelButton: true,
            showDenyButton: false,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-dim btn-secondary'
            },
        })
        .then((result) => {
            if (result.isConfirmed) {
                onConfirm();
            }
        })
}

export const confirmation = async (action, onConfirm, onCancel) => {
    await confirmSwalMixin
        .fire({
            confirmButtonText: action,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-dim btn-light',
            }
        })
        .then((result) => {
            if (result.isConfirmed) {
                onConfirm();
            }
        });
}

export const toast = async (type, message) => {
    await toastSwalMixin.fire({
        icon: type,
        html: message,
    });
}
