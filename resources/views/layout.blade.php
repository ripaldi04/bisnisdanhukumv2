@php
    $data = App\Models\Course::pluck('favicon')->first();

    $favicon = $data ? Storage::url($data) : asset('assets/logo/favicon.png');
@endphp
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="{{ $favicon }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Bisnis dan Hukum</title>
    @yield('style')
    @vite('resources/css/app.css')
</head>

<body class="text-black font-poppins">
    @yield('content')

    @if (!in_array(Route::currentRouteName(), ['checkout', 'learn', 'learning']))
        @include('components.footer')
    @endif

    @yield('script')
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
