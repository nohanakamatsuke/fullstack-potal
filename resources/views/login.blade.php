<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ログイン</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ログイン</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono antialiased w-full">
  <div class="flex flex-col items-center min-h-screen">
    <div class="w-full h-16">
      <x-layouts.header />
    </div>
    <div class="w-10/12 px-5 py-12 bg-gray-200 mt-12 ">
      <h1 class="font-bold text-2xl text-center">Login</h1>
      <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="mt-12 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="user_id" class="block text-sm/6 font-medium text-gray-900">社員ID</label>
            <div class="mt-1">
              <div
                class="flex bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="user_id" id="user_id" autocomplete="user_id"
                  class="block flex-1 border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6"
                  placeholder="Enter ID">
              </div>
            </div>
          </div>
          <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
            <div class="sm:col-span-4">
              <label for="password" class="block text-sm/6 font-medium text-gray-900">パスワード</label>
              <div class="mt-1">
                <div
                  class="flex bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                  <input type="password" name="password" id="password" autocomplete="current-password"
                    class="block flex-1 border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6"
                    placeholder="Enter password">
                </div>
              </div>
            </div>
          </div>
          <div class="text-gray-500 text-sm mb-6 hover:text-gray-400 transition">パスワードをお忘れの方はこちら</div>
          <button type="submit"
            class="w-1/2 mx-auto py-2 shadow transition	 bg-white hover:bg-green-100 rounded-xl border-solid border-2 border-customMain ">ログイン</button>
          @if ($errors->has('error'))
            <p class="text-red-500 text-sm">{{ $errors->first('error') }}</p>
          @endif
        </div>
      </form>
    </div>
  </div>
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
