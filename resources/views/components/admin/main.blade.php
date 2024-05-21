<!DOCTYPE html>

<html lang="en">

<head>

    @include('components.admin.layout.header')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('components.admin.layout.menu')

            <!-- Layout container -->
            <div class="layout-page">

                @include('components.admin.layout.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    {{ $slot }}

                </div>
                <!-- Content wrapper -->

            </div>
            <!-- Layout container -->

        </div>

    </div>
    <!-- / Layout wrapper -->

    @include('components.admin.layout.footer')

</body>

</html>