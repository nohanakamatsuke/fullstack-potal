{{-- ヘッダー --}}

<header class="z-10 w-full h-22 items-center bg-customMain">
  <div class="flex p-6 justify-between">
    <a href="/">
      <h1 class="flex items-center text-xl">Fullstack-Portal</h1>
    </a>
    <div class="flex items-center gap-3">
      <div class="text-xs font-sans">
        @if (session('user_id') && session('name'))
          <p>ID:&nbsp;{{ session('user_id') }}</p>
          <p>{{ session('name') }}</p>
      </div>
      {{-- アイコンとドロップダウンメニュー --}}
      <div class="relative">
        <button id="dropdownButton">
        <button id="dropdownButton">
          <x-css-profile class="w-8 h-8" />
        </button>
        <div id="dropdownMenu" class="absolute right-0 w-48 mt-2 bg-white rouded-md shadow hidden">
          {{-- プロフィール機能は今回実装しないので、グレーアウト --}}
          <a href=""
            class="flex items-center justify-center grayscale block text-gray-600 line-through px-3 py-2 w-full">プロフィール</a>
          {{-- ログアウトボタンを押した場合、ログアウトのルーティング実行 --}}
          {{-- ログアウトボタンを押した場合、ログアウトのルーティング実行 --}}
          <form id="logoutForm" action="{{ route('logout.attempt') }}" method="POST">
            @csrf
            <button type="button" id="logout" class="block hover:bg-gray-100 px-3 py-2 w-full">
              ログアウト
            </button>
          </form>
        @else
          @endif
        </div>
      </div>
</header>


{{-- 確認モーダル --}}
<div id="logoutConfirmModal" class="z-50 fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
  <div class="px-10 py-14 bg-white">
    <p>本当にログアウトしますか？</p>
    <div class="flex mt-5 justify-center space-x-4 z-50">
      <p id="confirmLogout" class="py-1 px-3 bg-red-500 hover:bg-red-400 transition text-white">はい</p>
      <p id="cancelLogout" class="py-1 px-2 bg-gray-300 hover:bg-gray-200 ">いいえ</p>
    </div>
  </div>
</div>

{{-- JavaScriptのクリックイベント --}}

{{-- JavaScriptのクリックイベント --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {

    const ICON_CLICK = document.getElementById('dropdownButton');
    const DROPDOWN_MENU = document.getElementById('dropdownMenu');
    const LOGOUT_CLICK = document.getElementById('logout');
    const LOGOUT_CONFIRM_MODAL = document.getElementById('logoutConfirmModal');
    const CONFIRM_LOGOUT = document.getElementById('confirmLogout');
    const CANCEL_LOGOUT = document.getElementById('cancelLogout');
    const LOGOUT_FORM = document.getElementById('logoutForm');

    ICON_CLICK.addEventListener('click', () => {
      DROPDOWN_MENU.classList.toggle("hidden");
    });

    LOGOUT_CLICK.addEventListener('click', (e) => {
      e.preventDefault();
      LOGOUT_CONFIRM_MODAL.classList.remove("hidden");
    });

    CONFIRM_LOGOUT.addEventListener('click', () => {
      LOGOUT_FORM.submit();
    });

    CANCEL_LOGOUT.addEventListener('click', () => {
      LOGOUT_CONFIRM_MODAL.classList.add("hidden");
      DROPDOWN_MENU.classList.add("hidden");
    });
  });
</script>
