<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <div class="container">
        <form action="/response/create" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$insurance->id}}">
            <div class="input-group mb-3">
                <span class="input-group-text" id="name">name</span>
                <input type="text" class="form-control" placeholder="name" name="name" aria-label="name"
                       aria-describedby="name">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="phone">phone</span>
                <input type="text" class="form-control" placeholder="phone" name="phone" aria-label="phone"
                       aria-describedby="phone">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="mail">mail</span>
                <input type="text" class="form-control" placeholder="mail" name="mail" aria-label="mail"
                       aria-describedby="mail">
            </div>

            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <button type="submit" class="btn btn-success">Отправить</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
