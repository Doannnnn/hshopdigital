<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/vendor/libs/popper/popper.js"></script>
<script src="/assets/vendor/js/bootstrap.js"></script>
<script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="/assets/js/main.js"></script>

<!-- Page JS -->
<script src="/assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
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

    function handleDelete(id) {
        Swal.fire({
            title: 'Confirm remove user',
            text: 'Are you sure to remove this user?',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "" + id;
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(item => {
            const link = item.querySelector('.menu-link');
            const subMenu = item.querySelector('.menu-sub');

            if (link && subMenu) {
                const subMenuLinks = subMenu.querySelectorAll('.menu-link');
                subMenuLinks.forEach(subLink => {
                    if (subLink.href === currentLocation) {
                        item.classList.add('active');
                        link.classList.add('open');
                        // Add active class to the parent menu item if a submenu item is active
                        const parentMenu = item.closest('.menu-item');
                        if (parentMenu) {
                            parentMenu.classList.add('active');
                            parentMenu.classList.add('open');
                        }
                    }
                });
            } else if (link && link.href === currentLocation) {
                item.classList.add('active');
            }
        });
    });
</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openModal', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });

        Livewire.on('closeModal', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            var backdrop = document.querySelector('.modal-backdrop');
            var modalElement = document.getElementById('editModal');
            editModal.hide();
            backdrop.parentNode.removeChild(backdrop);
            modalElement.classList.remove('show');
            modalElement.removeAttribute('style');
        });

    })
</script>