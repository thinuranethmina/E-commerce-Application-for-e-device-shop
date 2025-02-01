<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ $site_favicon }}">

    <meta name="description" content="{{ $meta_description }}">

    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="{{ $site_name }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet"
        href="{{ asset('assets/backend/css/app.css') }}?v={{ filemtime(public_path('assets/backend/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendors/bootstrap/bootstrap.min.css') }}">

    <!-- Bootstrap Tags Input CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

    <!-- Slick Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />

    <!-- Icons -->
    <link rel='stylesheet'
        href='{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}'>
    <link rel='stylesheet' href='{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}'>
    <link rel='stylesheet' href='{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}'>
    <link rel='stylesheet' href='{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}'>
    <link rel='stylesheet' href='{{ asset('assets/global/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}'>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js"></script>


    <!-- Sweet Alert 2 -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Tiny MCE -->
    <script src="{{ asset('assets/global/tinymce/tinymce.min.js') }}"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress/nprogress.css" />
    <script src="https://cdn.jsdelivr.net/npm/nprogress/nprogress.js"></script>

    <!-- Include Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" crossorigin>
    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/44.1.0/ckeditor5-premium-features.css" crossorigin>
</head>

<body>
    <div id="app">
        @include('backend.layouts.header')
        @include('backend.layouts.sidebar')
        <div class="main-content app-content">
            <div class="container-xxl px-1">
                @yield('content')
            </div>
        </div>
        @include('backend.layouts.modal')
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js" crossorigin></script>
    <script src="https://cdn.ckeditor.com/ckeditor5-premium-features/44.1.0/ckeditor5-premium-features.umd.js" crossorigin>
    </script>
    <script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>
    <script src="{{ asset('assets/backend/js/ckInit.js') }}"></script>

    <!-- Tiny MCE -->
    {{-- <script src="{{ asset('assets/backend/plugins/tinymce.min.js') }}"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    {{-- <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script
        src="{{ asset('assets/backend/js/fileChooser.js') }}?v={{ filemtime(public_path('assets/backend/js/app.js')) }}">
    </script>
    <script src="{{ asset('assets/backend/js/app.js') }}?v={{ filemtime(public_path('assets/backend/js/app.js')) }}">
    </script>
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


</body>

</html>
