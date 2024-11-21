<header class="w-full items-center bg-customMain">
    <div class="flex p-6 justify-between">
        <h1 class="flex items-center text-xl">Fullstack-Portal</h1>
        <div class="flex items-center gap-3">
            <div class="text-xs font-sans">
              @if(isset($id) && isset($name))
                <p>id:&nbsp;{{ $id }}</p>
                <p>name:&nbsp;{{ $name }}</p>
            </div>
            <x-css-profile class="w-8 h-8"/>
            @else
            @endif
        </div>
</header>
