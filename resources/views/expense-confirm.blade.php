{{-- フルスタックポータル　ホーム --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fullstack-Portal</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  {{-- tailwind cssを利用する --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono antialiased">

  <div class="flex flex-col items-center">
    {{-- ヘッダー --}}
    {{-- <x-layouts.header :user_id="$user_id" :name="$name" /> --}}

    <div>確認画面のテストです</div>

  </div>

</body>

</html>
