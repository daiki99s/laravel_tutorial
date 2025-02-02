<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>収入一覧</title>
</head>
<body>
    <h1>収入一覧</h1>
    <table border="1">
        <tr>
            <th>日付</th>
            <th>金額</th>
            <th>コメント</th>
        </tr>
        @foreach ($incomes as $income)
        <tr>
            <td>{{ $income->date }}</td>
            <td>{{ $income->amount }}</td>
            <td>{{ $income->comment }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
