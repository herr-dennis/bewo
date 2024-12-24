
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titel')</title>
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">

</head>
<body>
<header>
    @section("header")
    @show
</header>
<main>
@section("main-content")
    @show
</main>

<footer>
    <a href="/Impressum">Impressum</a>
    <a href="/Datenschutz">Datenschutz</a>
    @section("footer")
    @show
</footer>
</body>
</html>
