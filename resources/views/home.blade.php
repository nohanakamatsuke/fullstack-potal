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
    <x-layouts.header :user_id="$user_id" :name="$name" />
    {{-- アラートメッセージ --}}
    @if (session()->has('success'))
      <div class="border boerder-black px-20 py-5 mt-3 shadow-md ">
        <p>{{ session('success') }}</p>
      </div>
    @endif
    <div class="mt-28 flex flex-col h-auto">
      <div class="grid grid-cols-2 xl:grid-cols-4 gap-8 sm:gap-10 lg:gap-20 text-lg md:text-2xl lg:text-3xl">
        @foreach ($fillterdHomeButton as $button)
          <x-layouts.button :label="$button['label']" :status="$button['status']" :route="$button['route']" :role="$button['role']" />
        @endforeach
        @if ($role === 2)
          <form action="{{ route('testcsv') }}" method="post">
            @csrf
            <button type="submit"
              class='w-32 h-32 sm:w-48 sm:h-48 xl:w-56 xl:h-56 bg-white hover:bg-white border-2 border-customMain shadow-md shadow-customMain rounded-3xl active:scale-95 transition transition-transform hover:shadow-none'>CSV出力</button>
          </form>
        @endif
      </div>
    </div>
  </div>

</body>

</html>
