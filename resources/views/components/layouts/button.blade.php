@if ($status === 1)
  <button class="w-32 h-32 sm:w-48 sm:h-48 xl:w-56 xl:h-56 bg-white hover:bg-white border-2 border-customMain shadow shadow-customMain rounded-3xl active:scale-95 transition transition-transform hover:shadow-none ">{{$buttonName}}</button>
@else
<button class=" grayscale text-gray-500 bg-gray-200 w-32 h-32 sm:w-48 sm:h-48 xl:w-56 xl:h-56 border-2 border-customMain shadow shadow-customMain rounded-3xl">{!! nl2br(e($buttonName)) !!}</button>
@endif
