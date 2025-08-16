<x-filament::page>
  <x-filament::card>
    <form wire:submit="submit">
      <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <div>
          <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Currency
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('currency')">
            <x-filament::input type="text" wire:model.defer="currency" id="currency" class="w-full" required />
          </x-filament::input.wrapper>
        </div>

        <div>
          <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Timezone
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('timezone')">
            <x-filament::input.select wire:model.defer="timezone" id="timezone" class="w-full" required>
              @foreach ($timezones as $tz)
                <option value="{{ $tz }}">{{ $tz }}</option>
              @endforeach
            </x-filament::input.select>
          </x-filament::input.wrapper>
        </div>
        <div>
          <label for="exclude_internal_transfer" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
            Exclude internal transfer
          </label>
          <x-filament::input.wrapper class="w-full" :valid="!$errors->has('exclude_internal_transfer')">
            <x-filament::input.select wire:model.defer="exclude_internal_transfer" id="exclude_internal_transfer" class="w-full" required>
              <option value="0">No</option>
              <option value="1">Yes</option>
            </x-filament::input.select>
          </x-filament::input.wrapper>
          <small class="text-gray-400 pt-2">
            Exclude transactions using the "Internal Transfer" category from statistics such as total income, expenses, and charts.
          </small>
        </div>
      </div>

      <div>
        <x-filament::button wire:click="submit" class="w-auto">
          Save Settings
        </x-filament::button>
      </div>
    </form>
  </x-filament::card>
</x-filament::page>
