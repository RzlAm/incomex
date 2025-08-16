<x-filament::page>
  <x-filament::card>
    <form wire:submit="submit">
      <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Name
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('name')">
            <x-filament::input type="text" wire:model.defer="name" id="name" class="w-full" required />
          </x-filament::input.wrapper>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Email
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('email')">
            <x-filament::input type="email" wire:model.defer="email" id="email" class="w-full" required />
          </x-filament::input.wrapper>
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Password
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('password')">
            <x-filament::input type="password" wire:model.defer="password" id="password" class="w-full" />
          </x-filament::input.wrapper>
          <small class="text-gray-400 pt-2">Leave this field empty if you don’t want to change the password.</small>
        </div>
      </div>

      <div>
        <x-filament::button wire:click="submit" class="w-auto">
          Save Changes
        </x-filament::button>
      </div>
    </form>
  </x-filament::card>
</x-filament::page>
