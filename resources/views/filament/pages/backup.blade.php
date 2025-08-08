<x-filament::page>
  {{-- <x-filament::card>
    <div class="flex justify-between items-start sm:items-center gap-3 w-full flex-col sm:flex-row">
      <div>
        <h2 class="text-lg font-semibold">Auto Database Backup</h2>
        <p class="text-sm text-gray-400 mb-2">Backup your database automatically to your Google Drive.</p>
        <small class="text-gray-400 flex gap-1 items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          Last backup: {{ now() }}</small>
      </div>

      <div class="space-y-2 mb-0 mt-2 sm:mt-0">
        <x-filament::input.wrapper>
          <x-filament::input.select wire:model="backupInterval" wire:model="status">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
          </x-filament::input.select>
        </x-filament::input.wrapper>

        <x-filament::button icon="heroicon-m-clock" wire:click="backupNow" wire:loading.attr="disabled">
          Backup now
        </x-filament::button>
      </div>
    </div>
  </x-filament::card> --}}

  <x-filament::card>
    <div class="flex justify-between items-start sm:items-center gap-3 w-full flex-col sm:flex-row">
      <div>
        <h2 class="text-lg font-semibold">Manual Database Backup</h2>
        <p class="text-sm text-gray-400">
          Manually back up your database by downloading the latest <code>.sql</code> file.
        </p>
      </div>
      <x-filament::button icon="heroicon-m-arrow-down-tray" wire:click="backupNow" wire:loading.attr="disabled" style="width: auto; max-width: 120px;">
        Download
      </x-filament::button>
    </div>
  </x-filament::card>

  <x-filament::card>
    <div class="mb-4">
      <h2 class="text-lg font-semibold">Restore Instructions</h2>
      <p class="text-sm text-gray-400">Follow these steps to restore your database using a backup file.</p>
    </div>

    <div>
      <ol class="list-inside text-gray-300 text-sm space-y-1">
        <li>1. Open phpMyAdmin from your hosting control panel.</li>
        <li>2. Select the database you want to restore (usually your app's database).</li>
        <li>3. Import the backup:
          <ul class="list-disc list-inside mt-2 space-y-1" style="margin-left: 15px;">
            <li>Click the Import tab.</li>
            <li>Click Choose File and select the backup <code>.sql</code> file.</li>
            <li>Click Go to begin the import process.</li>
          </ul>
        </li>
      </ol>

      <p class="text-sm text-white mt-3 p-3 rounded" style="background-color: #dc2626;">
        <strong>Warning:</strong> Importing a backup will <u>overwrite all existing data</u> in the database. Make sure to back up your current data before proceeding.
      </p>
    </div>
  </x-filament::card>

</x-filament::page>
