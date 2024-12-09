<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSVダウンロード</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <h1>CSV出力</h1>
    <form action="{{ route('testcsv') }}" method="post">
        @csrf
        <table class='table-auto'>
            <tr>
                <th>社員番号</th>
                <th>使用年月日</th>
                <th>経費科目</th>
                <th>申請内容詳細</th>
                <th>経費金額</th>
                <th>レシート画像（表）</th>
                <th>レシート画像（裏）</th>
            </tr>
            @foreach ($expenses as $expenses)
                <tr>
                    <td>{{ $expenses['user_id'] }}</td>
                    <td>{{ $expenses['use_date'] }}</td>
                    <td>{{ $expenses['expense_app_line_templates'] }}</td>
                    <td>{{ $expenses['purpose'] }}</td>
                    <td>{{ $expenses['total_amount'] }}円</td>
                    <td>{{ $expenses['receipt_front'] }}</td>
                    <td>{{ $expenses['receipt_back'] }}</td>
                </tr>
            @endforeach
        </table>
        <div class='flex justify-center pt-10'>
            <button type="submit" class='center bg-red-400 rounded p-1 m-1'>CSVを出力する</button>
        </div>
    </form>
</body>

</html>

{{-- <button a href="{{ route('testcsv') }}" class="btn btn-primary">CSVをダウンロード</a>> --}}
