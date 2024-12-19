{{-- 経費メニュー --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fullstack-Portal</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  {{-- tailwind cssを利用する --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono antialiased">

  <div class="flex flex-col">
    {{-- ヘッダー --}}
    <x-layouts.header :user_id="$user_id" :name="$name" />

    {{-- 戻るボタン --}}
    <x-layouts.return-button :prevurl="$prevurl" />
    {{-- 履歴一覧表示 --}}
    <div class="w-3/4 m-auto">
      {{-- 検索フォーム --}}
      <div class="mb-6 mt-4 p-4 bg-white rounded shadow">
        <form action="{{ route('history_index') }}" method="GET" class="space-y-4">
          <div class="flex flex-wrap gap-4">
            <div class="flex-1">
              <input type="text" name="search" value="{{ $search_params['search'] }}"
                placeholder="申請タイトル検索"
                class="w-full px-3 py-2 border rounded">
            </div>
            <div class="flex gap-2">
              <input type="date" name="start_date" value="{{ $search_params['start_date'] }}"
                class="px-3 py-2 border rounded">
              <span class="self-center">～</span>
              <input type="date" name="end_date" value="{{ $search_params['end_date'] }}"
                class="px-3 py-2 border rounded">
            </div>
            <div>
              <select name="status" class="px-3 py-2 border rounded">
                <option value="">承認状態</option>
                <option value="approved" {{ $search_params['status'] === 'approved' ? 'selected' : '' }}>承認済み</option>
                <option value="in_progress" {{ $search_params['status'] === 'in_progress' ? 'selected' : '' }}>未承認</option>
              </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              検索
            </button>
          </div>
        </form>
      </div>

      <div class="mx-auto space-y-3 text-gray-700">
        <p class="text-sm">直近の履歴</p>
        <div class="flex">
          <div class="table-responsive w-full">
            <table class="table table-striped table-bordered w-full">
              <thead>
                <tr>
                  <th>申請日</th>
                  <th>社員ID</th>
                  <th>氏名</th>
                  <th>申請タイトル</th>
                  {{--
                  <th>用途</th>
                  <th>項目</th>
                  --}}
                  <th>金額</th>
                  <th>承認状態</th>
                </tr>
              </thead>
              <tbody class="bg-white">
                @foreach($paginatedData as $expense)
                <tr class="text-center border-b border-gray-200 hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ \Carbon\Carbon::parse($expense['use_date'])->format('Y/m/d') }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ $expense['user_id'] }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ $expense['name'] }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ $expense['title'] }}</td>
                  {{--
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ $expense['item'] }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">{{ $expense['purpose'] }}</td>
                  --}}
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r">¥{{ number_format($expense['total_amount']) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{-- ステータスバッチ 条件分岐 --}}
                    @if($expense['status'] === '承認')
                    <span class="block flex border border-black w-16 h-6 mx-auto bg-green-400 justify-center items-center text-xs rounded-md">
                      承認
                    </span>
                    @else
                    <span class="block flex border border-black w-20 h-6 mx-auto bg-yellow-400 justify-center items-center text-xs rounded-md">
                      未承認
                    </span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        {{-- ページネーション --}}
        <div class="">
          {{-- vender.pagination.bootstrap-4参照 --}}
          {{ $paginatedData->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</body>

</html>