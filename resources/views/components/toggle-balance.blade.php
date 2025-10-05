<div class="flex justify-start gap-3 mt-2">
  <span>{{ $balance }}</span>
  <button wire:click="{{ $action }}" class="text-gray-500 hover:text-gray-700 transition">
    <x-heroicon-o-eye class="w-5 h-5 {{ $eyeIcon === 'heroicon-o-eye' ? '' : 'hidden' }}" />
    <x-heroicon-o-eye-slash class="w-5 h-5 {{ $eyeIcon === 'heroicon-o-eye-slash' ? '' : 'hidden' }}" />
  </button>
</div>
