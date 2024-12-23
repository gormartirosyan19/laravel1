<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <script src="https://kit.fontawesome.com/af248bd0fb.js" crossorigin="anonymous"></script>

    @stack('styles')
    @vite(['resources/css/app.css'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/footer.css'])
</head>
<body>

@include('layouts.header')

<div class="container">
    @yield('content')
</div>


@include('layouts.footer')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@stack('scripts')
</body>
</html>
