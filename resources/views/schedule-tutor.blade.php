<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panduan Jadwal Transaksi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans p-6">
  <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Panduan Jadwal Transaksi Otomatis</h1>
      <select id="lang" class="border border-gray-300 rounded px-3 py-1 text-sm">
        <option value="id" selected>🇮🇩 Indonesia</option>
        <option value="en">🇬🇧 English</option>
      </select>
    </div>

    <!-- Konten Indonesia -->
    <div id="content-id" class="lang-content">
      <h2 class="text-xl font-semibold mb-3">1. Input Data Jadwal</h2>
      <table class="table-auto w-full text-sm mb-6 border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border px-4 py-2">Field</th>
            <th class="border px-4 py-2">Penjelasan</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="border px-4 py-2">schedule_name</td><td class="border px-4 py-2">Nama jadwal (misal: Gaji Bulanan)</td></tr>
          <tr><td class="border px-4 py-2">wallet_id</td><td class="border px-4 py-2">ID dompet yang digunakan</td></tr>
          <tr><td class="border px-4 py-2">category_id</td><td class="border px-4 py-2">ID kategori transaksi</td></tr>
          <tr><td class="border px-4 py-2">transaction_type</td><td class="border px-4 py-2">`income` (pemasukan) / `expense` (pengeluaran)</td></tr>
          <tr><td class="border px-4 py-2">amount</td><td class="border px-4 py-2">Jumlah transaksi</td></tr>
          <tr><td class="border px-4 py-2">description</td><td class="border px-4 py-2">Deskripsi (opsional)</td></tr>
          <tr><td class="border px-4 py-2">schedule_type</td><td class="border px-4 py-2">Tipe jadwal: daily, monthly, hourly, yearly</td></tr>
          <tr><td class="border px-4 py-2">day</td><td class="border px-4 py-2">Tanggal untuk monthly/yearly</td></tr>
          <tr><td class="border px-4 py-2">month</td><td class="border px-4 py-2">Bulan untuk yearly</td></tr>
          <tr><td class="border px-4 py-2">hour</td><td class="border px-4 py-2">Jam eksekusi</td></tr>
          <tr><td class="border px-4 py-2">minute</td><td class="border px-4 py-2">Menit eksekusi</td></tr>
        </tbody>
      </table>

      <h2 class="text-xl font-semibold mb-3">2. Proses Eksekusi</h2>
      <ul class="list-disc ml-6 mb-6 text-sm space-y-1">
        <li>Eksekusi berjalan saat user membuka web/app</li>
        <li>Middleware akan cek waktu dan tipe jadwal</li>
        <li>Jika cocok, transaksi otomatis dibuat</li>
        <li>Waktu terakhir eksekusi disimpan di <code>last_run_at</code></li>
      </ul>

      <h2 class="text-xl font-semibold mb-3">3. Hasil</h2>
      <ul class="list-disc ml-6 text-sm space-y-1">
        <li>Transaksi tercatat otomatis di dompet/kategori</li>
        <li>Tidak dijalankan dua kali di periode yang sama</li>
        <li>Bisa dicek lewat field <code>last_run_at</code></li>
      </ul>
    </div>

    <!-- Konten English -->
    <div id="content-en" class="lang-content hidden">
      <h2 class="text-xl font-semibold mb-3">1. Schedule Input</h2>
      <table class="table-auto w-full text-sm mb-6 border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border px-4 py-2">Field</th>
            <th class="border px-4 py-2">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="border px-4 py-2">schedule_name</td><td class="border px-4 py-2">Schedule name (e.g., Monthly Salary)</td></tr>
          <tr><td class="border px-4 py-2">wallet_id</td><td class="border px-4 py-2">Wallet ID</td></tr>
          <tr><td class="border px-4 py-2">category_id</td><td class="border px-4 py-2">Transaction category ID</td></tr>
          <tr><td class="border px-4 py-2">transaction_type</td><td class="border px-4 py-2">`income` / `expense`</td></tr>
          <tr><td class="border px-4 py-2">amount</td><td class="border px-4 py-2">Transaction amount</td></tr>
          <tr><td class="border px-4 py-2">description</td><td class="border px-4 py-2">Description (optional)</td></tr>
          <tr><td class="border px-4 py-2">schedule_type</td><td class="border px-4 py-2">Schedule type: daily, monthly, hourly, yearly</td></tr>
          <tr><td class="border px-4 py-2">day</td><td class="border px-4 py-2">Day for monthly/yearly</td></tr>
          <tr><td class="border px-4 py-2">month</td><td class="border px-4 py-2">Month for yearly</td></tr>
          <tr><td class="border px-4 py-2">hour</td><td class="border px-4 py-2">Execution hour</td></tr>
          <tr><td class="border px-4 py-2">minute</td><td class="border px-4 py-2">Execution minute</td></tr>
        </tbody>
      </table>

      <h2 class="text-xl font-semibold mb-3">2. Execution Process</h2>
      <ul class="list-disc ml-6 mb-6 text-sm space-y-1">
        <li>Runs when user opens the website/app</li>
        <li>Middleware checks the current time & schedule type</li>
        <li>If matched, transaction is created automatically</li>
        <li>Last run time is saved in <code>last_run_at</code></li>
      </ul>

      <h2 class="text-xl font-semibold mb-3">3. Result</h2>
      <ul class="list-disc ml-6 text-sm space-y-1">
        <li>Transaction recorded under selected wallet/category</li>
        <li>Won’t run more than once per time slot</li>
        <li>You can check via <code>last_run_at</code> field</li>
      </ul>
    </div>
  </div>

  <script>
    const langSelect = document.getElementById('lang');
    const contents = document.querySelectorAll('.lang-content');

    langSelect.addEventListener('change', () => {
      contents.forEach(c => c.classList.add('hidden'));
      document.getElementById(`content-${langSelect.value}`).classList.remove('hidden');
    });
  </script>
</body>
</html>
