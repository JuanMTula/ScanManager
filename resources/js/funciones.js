

window.mensaje_rapido = function($texto,$tipo) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}

window.mensaje_grande = function($texto,$titulo,$tipo) {
    const Toast = Swal.mixin({
        position: 'center',
        showConfirmButton: true,
        title: $titulo,
        confirmButtonText: 'Volver',
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}

window.mensaje_bloqueador = function($texto,$tipo) {
    const Toast = Swal.mixin({
        toast: false,
        position: 'center',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showConfirmButton: false,
    })

    Toast.fire({
        icon: $tipo,
        title: $texto
    })
}
