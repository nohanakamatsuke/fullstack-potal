@if ($paginator->hasPages())
<nav>
  <ul class="flex justify-center items-center space-x-2">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <li class="px-4 py-2 text-gray-400 bg-gray-200 border border-gray-300 rounded-l cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.previous')">
      <span aria-hidden="true">&lsaquo;</span>
    </li>
    @else
    <li>
      <a class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-l hover:bg-gray-100" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
    </li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="px-4 py-2 text-gray-400 bg-gray-200 border border-gray-300" aria-disabled="true">{{ $element }}</li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="px-4 py-2 text-white bg-blue-500 border border-gray-300">{{ $page }}</li>
    @else
    <li>
      <a class="px-4 py-2 text-gray-700 bg-white border border-gray-300 hover:bg-gray-100" href="{{ $url }}">{{ $page }}</a>
    </li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <li>
      <a class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-r hover:bg-gray-100" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
    </li>
    @else
    <li class="px-4 py-2 text-gray-400 bg-gray-200 border border-gray-300 rounded-r cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.next')">
      <span aria-hidden="true">&rsaquo;</span>
    </li>
    @endif
  </ul>
</nav>
@endif