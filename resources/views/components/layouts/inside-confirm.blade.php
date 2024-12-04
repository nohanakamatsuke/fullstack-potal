<section id="form-confirm" class="bg-gray-300 mt-10 rounded-md ">
    <div class="pl-8 pr-24 py-8">
        <form action="{{ route('expence-store') }}" method="POST">
            @csrf

            @php
                // セッションからデータを取得
                $formInput = session('form_input', []);
            @endphp

            {{-- 入力データをループで表示 --}}
            @foreach ($formInput['date'] as $index => $date)
                <div class="flex border-b-2 border-gray-400">
                    <label>用途項目:</label>
                    <input type="text" name="item[]" value="{{ $formInput['item'][$index] }}" readonly>
                </div>
                <div class="flex border-b-2 border-gray-400">
                    <label>使用年月日:</label>
                    <input type="date" name="use_date[]" value="{{ $date }}" readonly>
                </div>
                <div class="flex border-b-2 border-gray-400">
                    <label>合計金額:</label>
                    <input type="text" name="total_amount[]" value="{{ $formInput['total_amount'][$index] ?? '' }}"
                        readonly>
                </div>
                <div class="flex border-b-2 border-gray-400">
                    <label>用途詳細:</label>
                    <input type="text" name="purpose[]" value="{{ $formInput['purpose'][$index] }}" readonly>
                </div>
                <div class="flex border-b-2 border-gray-400">
                    <label>領収書画像(表面):</label>
                    @if (!empty($formInput['receipt_front'][$index]))
                        <img src="{{ asset('storage/' . $formInput['receipt_front'][$index]) }}" alt="表面画像"
                            class="w-32 h-32 object-cover border border-gray-400">
                    @else
                        <span>画像なし</span>
                    @endif
                </div>
                <div class="flex border-b-2 border-gray-400">
                    <label>領収書画像(裏面):</label>
                    @if (!empty($formInput['receipt_back'][$index]))
                        <img src="{{ asset('storage/' . $formInput['receipt_back'][$index]) }}" alt="裏面画像"
                            class="w-32 h-32 object-cover border border-gray-400">
                    @else
                        <span>画像なし</span>
                    @endif
                </div>
            @endforeach


        </form>
    </div>
</section>
