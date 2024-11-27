{{-- 領収書エリア --}}
<section class="flex flex-col space-y-2 mt-5">
  <label for="">領収書の画像</label>
  <span class="text-xs text-gray-500">※領収書は捨てずに保管しておいてください。</span>
  <div class="w-full flex items-center justify-between xl:justify-center xl:gap-20">
    {{-- 表面 --}}

    <label for="receipt-front"
      class="mt-3 px-2 py-3 xl:px-20 xl:py-10 flex flex-col border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-100 transition">
      <div class="flex flex-col items-center w-full">
        <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
        <span class="text-gray-500">表面を送付</span>
      </div>
      <div class="mt-1 w-26">
        <input type="file" id="receipt-back" name="receipt-back"
          class="w-full text-[6px] file:py-1 file:px-3 file:text-[7px] file:border-0 file:shadow-xl file:hover:shadow-none file:bg-gray-100"
          required>
      </div>
    </label>


    {{-- 裏面 --}}

    <label for="receipt-back"
      class="mt-3 px-2 py-3 xl:px-20 xl:py-10 flex flex-col border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-100 transition">
      <div class="flex flex-col items-center w-full">
        <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
        <span class="text-gray-500">裏面を送付</span>
      </div>
      <div class="mt-1 w-26">
        <input type="file" id="receipt-back" name="receipt-back" {{-- class=" w-20 text-[10px] w-24 file:py-1 file:px-2 file:text-[10px] file:border-0" required> --}}
          class="w-full text-[6px] file:text-[7px] file:py-1 file:px-3 file:border-0 file:shadow-xl file:hover:shadow-none file:bg-gray-100"
          required>
      </div>
    </label>




</section>
{{-- 使用年月日エリア --}}
<section>
  <label for="date">使用年月日</label>
  <input type="date" id="date" name="date" class="w-full py-2 mt-1 border pr-5 pl-2 rounded-lg shadow"
    required>
</section>
{{-- 用途項目エリア --}}
{{-- オプションにvalue追加、データベース構造要確認 --}}
<section>
  <label for="item">用途項目</label>
  <select id="item" name="item" class="w-full py-2 px-2 mt-1 border pr-5 rounded-lg shadow" required>
    <option value="">選択してください</option>
    <option value="train_commuter">交通費（定期）</option>
    <option value="train_basic">交通費（乗車券）</option>
    <option value="equipment">備品・消耗品</option>
    <option value="advance_payment">立替経費（部費、社内用品など）</option>
    <option value="others">その他</option>
  </select>
</section>
{{-- 用途の詳細エリア --}}
<section>
  <label for="purpose">用途の詳細</label>
  <input type="textarea" id="purpose" name="purpose" class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow"
    placeholder="Type here" required>
</section>
{{-- 合計金額 --}}
<section class="flex flex-col">
  <label for="totall-amount">合計金額</label>
  <span class="text-xs text-gray-500">「¥」や、区切り文字として「,」などを入れる必要はありません。</span>
  <input type="text" id="totall-amount" name="totall-amount"
    class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow" placeholder="Type here" required>
</section>
