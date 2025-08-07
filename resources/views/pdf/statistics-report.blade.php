<!DOCTYPE html>
<html>

<head>
  <title>Statistics Report</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #eee;
    }
  </style>
</head>

<body>
  <h2>Statistics Report</h2>
  <p>From {{ $startDate }} to {{ $endDate }}</p>

  <h3>Income & Expense</h3>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Income</th>
        <th>Expense</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($incomeExpenseData as $row)
        <tr>
          <td>{{ $row->date }}</td>
          <td>{{ number_format($row->income, 2) }}</td>
          <td>{{ number_format($row->expense, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h3 style="margin-top: 30px;">Top 10 Categories</h3>
  <table>
    <thead>
      <tr>
        <th>Category</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categoryPieData as $cat)
        <tr>
          <td>{{ $cat->category }}</td>
          <td>{{ number_format($cat->total, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
