<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Test Pac Ships') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />
    <style>
        .drag-handle {
            cursor: move;
            border-radius: 5px;
            background-color: #ccc;
        }
        .cabin {
            width: 250px;
            cursor: move;
            background-color: #fff;
        }
        .ghost {
            opacity: .5;
            background: #C8EBFB;
        }
        .photo {
            height: 150px !important;
            background-size: cover;
            background-color: #e7e7e7;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5 mb-3">
    <a class="navbar-brand" href="/">Test Pac Ships</a>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="/ships">Ships</a>
        </li>
    </ul>
</nav>
@yield('content')
</body>
</html>
