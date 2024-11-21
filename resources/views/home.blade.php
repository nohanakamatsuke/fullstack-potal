<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fullstack-Portal</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body>
    <body class="font-mono antialiased">
        <div class="flex flex-col items-center justify-center">
            <div class="w-full">
              {{-- ID:{{$id}}name:{{$name}} --}}
              <x-layouts.header :id="$id" :name="$name"/>
            </div>
        </div>
    </body>

</body>
</html>
