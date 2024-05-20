<!DOCTYPE html>

<html lang="en">

<head>

    @include('admin.layout.header')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('admin.layout.menu')

            <!-- Layout container -->
            <div class="layout-page">

                @include('admin.layout.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    @yield('content')

                </div>
                <!-- Content wrapper -->

            </div>
            <!-- Layout container -->

        </div>

    </div>
    <!-- / Layout wrapper -->

    @include('admin.layout.footer')

</body>

</html>