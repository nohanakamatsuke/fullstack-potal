{{-- メニューボタン --}}

{{-- 有効なメニュー（status=1）の抽出 --}}
@if ($status === 1)

  {{-- 　ルートが設定されている時のみに、aタグで遷移先指定 --}}
  @if ($route)
    <a href="{{ $route }}">
      <button
        class="w-32 h-32 sm:w-48 sm:h-48 xl:w-56 xl:h-56 bg-white hover:bg-white border-2 border-customMain shadow-md shadow-customMain rounded-3xl active:scale-95 transition transition-transform hover:shadow-none">{{ $label }}</button>
    </a>
  @else
    <button
      class="w-32 h-32  sm:w-48 sm:h-48 xl:w-56 xl:h-56 bg-white hover:bg-white border-2 border-customMain shadow-md shadow-customMain rounded-3xl active:scale-95 transition transition-transform hover:shadow-none">{{ $label }}</button>
  @endif

  {{-- 有効なメニューでない場合（status=0）は グレーアウトでアニメーションなし --}}
@else
  <button
    class="z-0 grayscale text-gray-500 bg-gray-200 w-32 h-32 sm:w-48 sm:h-48 xl:w-56 xl:h-56 border-2 border-customMain shadow shadow-customMain rounded-3xl">{!! nl2br(e($label)) !!}</button>
@endif
