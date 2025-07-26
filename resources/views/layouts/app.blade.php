<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'DaaraGeo')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Fonts + CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    {{-- renforce effet css --}}
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



    <!-- ✅ Ton CSS personnalisé -->
    {{-- <link href="{{ asset('acss/app.css') }}" rel="stylesheet">
 --}}
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @stack('styles')

</head>


<body id="page-top">

    <!-- SB Admin Wrapper -->
    <div id="wrapper">

        @include('components.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('components.navbar')

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('components.footer')
        </div>
    </div>

    {{-- JS --}}
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    {{-- Pour Bootstrap 5 --}}
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js') }}"></script>

    @stack('scripts')

</body>

</html>
