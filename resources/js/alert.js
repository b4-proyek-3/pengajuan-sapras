document.addEventListener('DOMContentLoaded', function () {
    // Cek pesan sukses
    const successMessage = document.body.getAttribute('data-success-message');
    if (successMessage) {
        Swal.fire({
            position: "center",
            title: successMessage,
            showConfirmButton: false,
            timer: 1500,
            icon: "success"
        });
    }

    // Cek pesan error
    const errorMessage = document.body.getAttribute('data-error-message');
    if (errorMessage) {
        Swal.fire({
            position: "center",
            title: errorMessage,
            showConfirmButton: true,
            icon: "error"
        });
    }
});
