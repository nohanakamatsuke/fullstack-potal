<section id="form-confirm" class="bg-gray-300 mt-10 rounded-md ">
  <div class="pl-8 pr-8 py-8">
    <!-- 用途の詳細 -->
    <div class="flex border-b-2 border-gray-400 space-x-2">
      <label>申請タイトル :</label>
      <p>{{ old("title.$i", $validated['title'][$i]) }}</p>
    </div>
    <!-- 用途項目 -->
    <div class="flex border-b-2 border-gray-400 space-x-2">
      <label>用途項目 :</label>
      <p>{{ old("item.$i", $validated['item'][$i]) }}</p>
    </div>
    <!-- 使用年月日 -->
    <div class="flex border-b-2 border-gray-400 space-x-2">
      <label>使用年月日 :</label>
      {{-- <p>{{ old("date.$i", $validated['date'][$i]) }}</p> --}}
      <p>{{ old("date.$i", $validated['date'][$i]) }}</p>
    </div>
    <!-- 領収書の画像（表） -->
    <div class="flex flex-col space-y-2 border-b-2 border-gray-400 pb-2.5">
      <label>領収書の画像（表）</label>
      {{-- <p>{{ $validated['receipt_front'][$i] ?? '画像なし' }}</p> --}}
      @if (!empty($validated['receipt_front'][$i]))
      <img src="{{ asset('storage/' . $validated['receipt_front'][$i]) }}" alt="領収書画像"
        class="rounded w-30 h-30 max-w-xs  my-2">
      @else
      <span>画像なし</span>
      @endif
    </div>
    <!-- 領収書の画像（裏） -->
    <div class="flex flex-col space-y-2 border-b-2 border-gray-400 pb-2.5">
      <label>領収書の画像（裏）</label>
      {{-- <p>{{ $validated['receipt_back'][$i] ?? '画像なし' }}</p> --}}
      @if (!empty($validated['receipt_back'][$i]))
      <img src="{{ asset('storage/' . $validated['receipt_back'][$i]) }}" alt="領収書画像"
        class="rounded w-30 h-30 max-w-xs  my-2">
      @else
      <span>画像なし</span>
      @endif
    </div>
    <!-- 合計金額 -->
    <div class="flex border-b-2 border-gray-400 space-x-2">
      <label>合計金額 :</label>
      <p>{{ old("total_amount.$i", $validated['total_amount'][$i]) }}円</p>
    </div>
    <!-- 用途の詳細 -->
    <div class="flex border-b-2 border-gray-400 space-x-2">
      <label>用途の詳細 :</label>
      <p>{{ old("purpose.$i", $validated['purpose'][$i]) }}</p>
    </div>
  </div>
</section>