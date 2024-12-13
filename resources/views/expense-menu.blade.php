<!-- {{-- 経費メニュー --}} -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fullstack-Portal</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <!-- {{-- tailwind cssを利用する --}} -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono antialiased">

  <div class="flex flex-col">
    <!-- {{-- ヘッダー --}} -->
    <x-layouts.header :user_id="$user_id" :name="$name" />
    <!-- {{-- 戻るボタン --}} -->
    <x-layouts.return-button :prevurl="$prevurl" />
    <!-- {{-- メニューボタン --}} -->
    <div class="mx-auto mt-8 flex flex-col h-auto items-center">
      <div class="grid grid-cols-2 gap-8 sm:gap-10 lg:gap-20 text-lg md:text-2xl lg:text-3xl">
        @foreach ($inExpenseMenuButton as $button)
          <x-layouts.button :label="$button['label']" :status="$button['status']" :route="$button['route']" />
        @endforeach
      </div>
    </div>
    {{-- 履歴一覧表示 --}}
    <div class="w-3/4 m-auto flex justify-center">
      <div class="mx-auto mt-20 space-y-4 text-gray-700 xl:mt-24 mb-10">
        <p class="text-sm xl:text-xl">直近の履歴 <span class="text-gray-500 text-xs xl:text-base">6件</span></p>
        @foreach ($expenseHistory as $history => $status)
          <div class="flex justify-between items-center space-x-8 xl:space-x-12 rounded bg-gray-100 px-4 py-1 shadow">
            <p class="tracking-tighter sm:tracking-normal xl:text-xl xl:tracking-wider">{!! nl2br(e($history)) !!}</p>
            {{-- ステータスバッチ 条件分岐 --}}
            @if ($status === '承認')
              <span
                class="block flex border border-black w-12 h-5 xl:w-20 xl:h-6 bg-green-400 justify-center items-center font-thin">
                承認
              </span>
            @else
              <span
                class="block flex border border-black w-20 h-5 xl:w-28 xl:h-6 bg-yellow-400 justify-center items-center font-thin">
                未承認
              </span>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>

</body>

</html>
