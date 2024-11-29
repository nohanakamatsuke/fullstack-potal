<section id="form-confirm" class="bg-gray-300 mt-10 rounded-md ">
  <div class="pl-8 pr-24 py-8">
    <div class="flex border-b-2 border-gray-400">
      <label>用途項目:</label>
      <p>{{ $validated['item'][$i] }}</p>
    </div>
    <div class="flex border-b-2 border-gray-400">
      <label>使用年月日:</label>
      <p>{{ $validated['date'][$i] }}</p>
    </div>
    <div class="flex border-b-2 border-gray-400">
      <label>領収書の画像:</label>
      <p>{{ $validated['receipt-front'][0] }}</p>
      <img src={{ $validated['receipt-front'][0] }} alt="" class="w-5 h-5">
    </div>
    <div class="flex border-b-2 border-gray-400">
      <label>合計金額:</label>
      <p>{{ $validated['total-amount'][$i] }}円</p>
    </div>
    <div class="flex border-b-2 border-gray-400 space-x-5">
      <label>用途の詳細:</label>
      <p>{{ $validated['purpose'][$i] }}</p>
    </div>
  </div>
</section>
