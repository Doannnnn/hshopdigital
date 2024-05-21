<!DOCTYPE html>

<html lang="en">

<head>

    @include('components.auth.layout.header')

</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">

                {{ $slot }}

            </div>
        </div>
    </div>
    <!-- / Content -->

    @include('components.auth.layout.footer')

</body>

</html>