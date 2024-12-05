
{{-- 確認画面　--}}
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
        <form action="{{ route('expence.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col items-center ">
            @csrf
            @for ($i = 0; $i < session('form_count', 0); $i++)
                <x-layouts.inside-confirm :validated="session('form_input', [])" :i="$i" />
            @endfor
            <section id="button-grp" class="flex space-x-7 mt-10">
                <button
                    class="bg-red-400 w-20 shadow-md hover:shadow-none rounded-lg px-1 py-3 hover:bg-red-300 transition"><a
                        href="{{ route('expense.form') }}">キャンセル</a></button>
                <button type="submit"
                    class="bg-customMain w-20 rounded-lg shadow-md hover:shadow-none px-1 py-3 hover:bg-customHoverMain transition">申請</button>
            </section>
        </form>
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </main>
</body>

</html>
