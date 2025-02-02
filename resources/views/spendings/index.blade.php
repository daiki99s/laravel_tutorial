<!-- resources/views/spendings/index.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支出一覧</title>
</head>
<body>
    <h1>支出一覧</h1>
    <table border="1">
        <tr>
            <th>日付</th>
            <th>金額</th>
            <th>コメント</th>
        </tr>
        @foreach ($spendings as $spending)
        <tr>
            <td>{{ $spending->date }}</td>
            <td>{{ $spending->amount }}</td>
            <td>{{ $spending->comment }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
