<x-filament::page>
  <x-filament::card>
    <div class="flex justify-between items-start sm:items-center gap-3 w-full flex-col sm:flex-row">
      <div>
        <h2 class="text-lg font-semibold">Manual Database Backup</h2>
        <p class="text-sm text-gray-400">Backup your database manually by downloading the <code>.sql</code> file.</p>
      </div>
      <x-filament::button icon="heroicon-m-arrow-down-tray" wire:click="backupNow" wire:loading.attr="disabled" style="width: auto; max-width: 120px;">
        Download
      </x-filament::button>
    </div>
  </x-filament::card>

  <x-filament::card>
    <div>
      <h2 class="text-lg font-semibold">How To Manual Backup</h2>
      <p class="text-sm text-gray-400 mb-4">Step by step guide to backup and restore your database.</p>

      <ol class="list-inside text-gray-300 text-sm space-y-2">
        <li>1. Click the Download button to save the <code>.sql</code> backup file to your computer.</li>
        <li>2. Go to your hosting control panel and open phpMyAdmin.</li>
        <li>3. Choose the database you want to restore (usually your app database).</li>
        <li>4. Import the backup:
          <ul class="list-disc list-inside text-gray-400 space-y-1" style="margin-left: 15px;">
            <li>Click the Import tab.</li>
            <li>Click Choose File and select the downloaded <code>.sql</code> file.</li>
            <li>Click Go to start the import.</li>
          </ul>
        </li>
      </ol>

      <p class="text-sm text-white mt-3 p-3 rounded" style="background-color: #dc2626;">
        <strong>Warning:</strong> Importing this backup will replace all existing data in your database tables with the backup data. Make sure to <em>back up</em> current data if needed before proceeding.
      </p>

      <div class="mt-6">
        <img src="{{ asset('images/pma.png') }}" alt="phpMyAdmin Import Screen" class="rounded shadow-md w-full" />
      </div>
    </div>
  </x-filament::card>
</x-filament::page>
