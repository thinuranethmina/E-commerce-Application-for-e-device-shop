<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

    <!-- Boostrap -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendors/bootstrap/bootstrap.min.css') }}?v=5.3">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js"></script>

    <link rel="stylesheet"
        href="{{ asset('assets/frontend/css/frontend.css') }}?v={{ filemtime(public_path('assets/frontend/css/frontend.css')) }}">

</head>

<body>

    @include('frontend.layouts.header')
    @yield('content')
    @include('frontend.layouts.footer')

    @include('frontend.layouts.modal')
    <div id="overlay" class="overlay"></div>
    @include('frontend.layouts.cart')

    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}?v=3.7.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}?v=5.3"></script>
    <script
        src="{{ asset('assets/frontend/js/frontend.js') }}?v={{ filemtime(public_path('assets/frontend/js/frontend.js')) }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @if (session('error'))
        <script type="text/javascript">
            showToast("{{ session('error') }}");
        </script>
    @endif

    @if (session('success'))
        <script type="text/javascript">
            showToast("{{ session('success') }}");
        </script>
    @endif

    @yield('scripts')
</body>

</html>
