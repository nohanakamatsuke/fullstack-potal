{{-- ログインフォーム --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ログイン</title>
  {{-- tailwind cssを利用する --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono antialiased w-full">
  <div class="flex flex-col items-center min-h-screen">
    {{-- ヘッダー --}}
    <x-layouts.header />
    <div class="w-10/12 px-5 py-12 bg-gray-200 mt-12">
      {{-- ログインタイトル --}}
      <h1 class="font-bold text-2xl text-center">Login</h1>

      {{-- フォーム内容 --}}
      <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="mt-12 grid gap-x-3 gap-y-4">
          {{-- idのエリア --}}
          <label for="user_id" class="block text-sm/6 font-medium text-gray-900">社員ID</label>
          <div
            class="flex bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
            <input type="text" name="user_id" id="user_id" autocomplete="user_id"
              class="block w-full border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6"
              placeholder="Enter ID">
          </div>
          {{-- パスワードのエリア --}}
          <div class="space-y-2">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">パスワード</label>
            <div
              class="flex bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
              <input type="password" name="password" id="password" autocomplete="current-password"
                class="block w-full border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6"
                placeholder="Enter password">
            </div>
          </div>
          <div class="text-gray-500 text-sm mb-6 hover:text-gray-400 transition">パスワードをお忘れの方はこちら</div>
          {{-- ログインボタン --}}
          <button type="submit"
            class="w-1/2 mx-auto py-2 shadow transition bg-white hover:bg-green-100 rounded-xl border-solid border-2 border-customMain ">ログイン</button>
          {{-- ログインエラー時の表示 --}}
          @if ($errors->has('error'))
            <p class="text-red-500 text-sm">{{ $errors->first('error') }}</p>
          @endif
        </div>
      </form>

    </div>
  </div>
  {{-- ログイン失敗した場合は、アラートでメッセージ表示 --}}
  @if (session('error'))
    <script>
      alert("{{ session('error') }}")
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // デフォルトの送信を防止

                    // 新しいCSRFトークンを取得
                    fetch('/refresh-csrf')
                        .then(response => response.json())
                        .then(data => {
                            const csrfToken = data.csrf_token;

                            // フォームに新しいCSRFトークンを埋め込む
                            const csrfInput = form.querySelector('input[name="_token"]');
                            csrfInput.value = csrfToken;

                            // 再度フォームを送信
                            form.submit();
                        });
                });
            });
        </script>
    @endif
</body>

</html>
