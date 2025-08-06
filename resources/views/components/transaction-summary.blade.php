<div class="flex justify-start gap-8 text-sm w-full py-4 px-6">
  <div>
    <div class="font-semibold text-green-600 whitespace-nowrap">Total Income</div>
    <div>{{ $income }}
    </div>
  </div>
  <div>
    <div class="font-semibold text-red-600 whitespace-nowrap">Total Expense</div>
    <div>{{ $expense }}</div>
  </div>
  <div>
    <div class="font-semibold text-blue-600">Net Balance</div>
    <div>
      {{ $netBalance }}
    </div>
  </div>
</div>
