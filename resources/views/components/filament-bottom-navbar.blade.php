@props(['items' => []])

<div class="fixed bottom-0 left-0 right-0 z-50 sm:hidden" style="width: 100%">
  <div class="flex between py-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-t-xl" style="justify-content: space-around;">
    @foreach ($items as $item)
      @php
        $isCenter = $item['label'] === 'Transaksi';
      @endphp
      @if ($isCenter)
        <a href="{{ $item['url'] }}" class="flex flex-col items-center text-xs text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">
          <x-dynamic-component :component="$item['icon']" class="w-7 h-7 mb-1 {{ request()->routeIs($item['active']) ? 'text-primary-500' : '' }}" />
          <small class="{{ request()->routeIs($item['active']) ? 'text-primary-500' : '' }}">
            {{ $item['label'] }}
          </small>
        </a>
      @else
        <a href="{{ $item['url'] }}" class="flex flex-col items-center text-xs text-gray-500 dark:text-gray-400 hover:text-primary-500 transition">
          <x-dynamic-component :component="$item['icon']" class="w-6 h-6 mb-1 {{ request()->routeIs($item['active']) ? 'text-primary-500' : '' }}" />
          <small class="{{ request()->routeIs($item['active']) ? 'text-primary-500' : '' }}">
            {{ $item['label'] }}
          </small>
        </a>
      @endif
    @endforeach
  </div>
</div>
