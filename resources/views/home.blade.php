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
    <body class="font-mono antialiased">
        <div class="flex flex-col items-center">
            <div class="w-full h-22">
              <x-layouts.header :id="$id" :name="$name"/>
            </div>
            <div class="mt-28 flex flex-col h-auto">
              <div class="grid grid-cols-2 xl:grid-cols-4 gap-8 sm:gap-10 lg:gap-20 text-lg md:text-2xl lg:text-3xl">
                @foreach($inHomeButton as $buttonName => $status)
                  <x-layouts.button :buttonName="$buttonName" :status="$status" />
                @endforeach
              </div>
            </div>
        </div>
    </body>
</body>
</html>
