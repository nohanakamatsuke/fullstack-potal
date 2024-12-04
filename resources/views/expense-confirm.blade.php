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

    {{-- ヘッダー --}}
    <x-layouts.header :user_id="$user_id" :name="$name" />

    <main class="flex flex-col items-center ">
        <section>
            <h1 class="mt-10">以下の内容で送信してよろしいですか？</h1>
        </section>
        <x-layouts.inside-confirm />
        <section id="form-fields" class="flex space-x-7 mt-10">

            <div class="flex space-x-7 mt-10">
                <button class="bg-red-400 w-20 rounded-lg px-1 py-3">キャンセル</button>
                <button type="submit" class="bg-customHoverMain w-20 rounded-lg px-1 py-3">申請</button>
            </div>
        </section>
    </main>

</body>

</html>
