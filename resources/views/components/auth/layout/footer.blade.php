<script src="/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/vendor/libs/popper/popper.js"></script>
<script src="/assets/vendor/js/bootstrap.js"></script>
<script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/assets/vendor/js/menu.js"></script>
<script src="/assets/js/main.js"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    const toastSuccess = "{{ Session::get('success') }}";
    if (toastSuccess.trim() !== "") {
        Toast.fire({
            icon: "success",
            title: toastSuccess,
        });
    }

    const toastError = "{{ Session::get('error') }}";
    if (toastError.trim() !== "") {
        Toast.fire({
            icon: "error",
            title: toastError,
        });
    }
</script>