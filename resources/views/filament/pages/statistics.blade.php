<x-filament::page>
  <style>
    .flex-responsive {
      display: flex;
      gap: 1.5rem;
      width: 100%;
      flex-wrap: wrap;
    }

    .card-statistics {
      flex: 3 1 0%;
      min-width: 0;
      max-width: 100%;
    }

    .fi-section-header {
      border-bottom: 1.9px solid #232329;
    }

    .card-title {
      font-weight: 600;
      font-size: 1rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid #232329
    }

    @media (max-width: 768px) {
      .flex-responsive {
        flex-direction: column;
      }

      .card-statistics,
      .card-category {
        width: 100% !important;
        flex: unset;
      }
    }
  </style>
  @php
    $startDate = request('startDate') ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
    $endDate = request('endDate') ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
  @endphp

  <form method="GET" class="mb-6 flex flex-col sm:flex-row sm:flex-wrap items-end gap-3">
    <div class="flex flex-col sm:flex-row sm:flex-wrap items-end gap-3 w-full">
      <div class="w-full sm:w-auto">
        <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
          Start Date
        </label>
        <x-filament::input.wrapper class="w-full">
          <x-filament::input type="date" id="startDate" name="startDate" value="{{ $startDate }}" class="w-full" />
        </x-filament::input.wrapper>
      </div>

      <div class="w-full sm:w-auto">
        <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
          End Date
        </label>
        <x-filament::input.wrapper class="w-full">
          <x-filament::input type="date" id="endDate" name="endDate" value="{{ $endDate }}" class="w-full" />
        </x-filament::input.wrapper>
      </div>
    </div>

    <div class="flex gap-2 w-full sm:w-auto">
      <x-filament::button type="submit" wire:click.attr="disabled">
        Apply
      </x-filament::button>
      @if (request('startDate') || request('endDate'))
        <x-filament::button href="statistics" tag="a" color="gray" wire:click.attr="disabled">
          Clear
        </x-filament::button>
      @endif
      <x-filament::button wire:click.attr="disabled" href="{{ route('statistics.export.csv', ['startDate' => $startDate, 'endDate' => $endDate]) }}" tag="a" color="gray">
        Export CSV
      </x-filament::button>
    </div>
  </form>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-filament::card>
      <h2 class="font-semibold text-sm text-gray-400 mb-1">Total Income</h2>
      <p class="text-3xl font-bold">Rp{{ number_format($totalIncome, 2, ',', '.') }}</p>
    </x-filament::card>
    <x-filament::card>
      <h2 class="font-semibold text-sm text-gray-400 mb-1">Total Expense</h2>
      <p class="text-3xl font-bold">Rp{{ number_format($totalExpense, 2, ',', '.') }}</p>
    </x-filament::card>
  </div>

  <div class="flex-responsive">
    <section class="py-4 card-statistics fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
      <header class="mb-4 fi-section-header flex flex-col gap-3 pb-4 px-6">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
              Income & Expense
            </h3>
          </div>
        </div>
      </header>
      <div class="px-6">
        <canvas id="statisticsChart"></canvas>
      </div>
    </section>
    <section class="py-4 card-category fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
      <header class="mb-4 fi-section-header flex flex-col gap-3 pb-4 px-6">
        <div class="flex items-center gap-3">
          <div class="grid flex-1 gap-y-1">
            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
              Top Category
            </h3>
          </div>
        </div>
      </header>
      <canvas id="categoryChart"></canvas>
    </section>
  </div>

  <script src="{{ asset('js/chart.js') }}"></script>
  <script>
    // Data from PHP
    const statisticsData = @json($statisticsData);
    const categoryData = @json($categoryData);

    // Render statistics chart
    const statisticsCtx = document.getElementById('statisticsChart').getContext('2d');
    new Chart(statisticsCtx, {
      type: 'bar',
      data: statisticsData,
      options: {
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              boxHeight: 12,
              borderRadius: 0,
              padding: 16,
              color: '#a1a1aa',
            },
          },
        },
      },
    });

    // Render category chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
      type: 'pie',
      data: categoryData,
      options: {
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              boxHeight: 12,
              borderRadius: 0,
              padding: 16,
              color: '#a1a1aa',
            },
          },
        },
      },
    });
  </script>
</x-filament::page>
