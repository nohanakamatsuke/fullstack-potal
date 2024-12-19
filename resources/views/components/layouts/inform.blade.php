{{-- 領収書エリア --}}
<section class="flex flex-col space-y-2 mt-5">
  <label for="">領収書の画像</label>
  <span class="text-xs text-gray-500">※領収書は捨てずに保管しておいてください。</span>
  <div class="w-full flex items-center justify-center sm:gap-20 gap-5">
    {{-- 表面 --}}

    <label for="receipt_front"
      class="mt-3 px-2 py-3 md:px-20 md:py-10 sm:px-16 sm:py-6 flex flex-col border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-100 transition">
      <div class="flex flex-col items-center w-full">
        <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
        <span class="text-gray-500">表面を送付</span>
      </div>
      <div class="mt-1 w-26">
        <input type="file" id="receipt_front" name="receipt_front[]" value="{{ old('receipt_front.0') }}"
          class="w-full text-[6px] file:py-1 file:px-3 file:text-[7px] file:border-0 file:shadow-xl file:hover:shadow-none file:bg-gray-100">
      </div>
    </label>

    {{-- 裏面 --}}

    <label for="receipt_back"
      class="mt-3 px-2 py-3 md:px-20 md:py-10 sm:px-16 sm:py-6 flex flex-col border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-100 transition">
      <div class="flex flex-col items-center w-full">
        <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
        <span class="text-gray-500">裏面を送付</span>
      </div>
      <div class="mt-1 w-26">
        <input type="file" id="receipt_back" name="receipt_back[]" value="{{ old('receipt_back.0') }}"
          class="w-full text-[6px] file:text-[7px] file:py-1 file:px-3 file:border-0 file:shadow-xl file:hover:shadow-none file:bg-gray-100">
      </div>
    </label>
</section>

{{--申請タイトルのエリア --}}
<section>
  <label for="title">申請タイトル</label>
  <input type="textarea" id="title" name="title[]" value="{{ old('title.0') }}"
    class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow" placeholder="Type here">
</section>

{{-- 使用年月日エリア --}}
<section>
  <label for="date">使用年月日</label>
  <input type="date" id="date" name="date[]" value="{{ old('date.0') }}"
    class="w-full py-2 mt-1 border pr-5 pl-2 rounded-lg shadow">
</section>

{{-- 用途項目エリア --}}
{{-- オプションにvalue追加、データベース構造要確認 --}}
<section>
  <label for="item">用途項目</label>
  <select id="item" name="item[]" class="w-full py-2 px-2 mt-1 border pr-5 rounded-lg shadow">
    <option value="">選択してください</option>
    <option value="train_commuter">交通費（定期）</option>
    <option value="train_basic">交通費（乗車券）</option>
    <option value="equipment">備品・消耗品</option>
    <option value="advance_payment">立替経費（部費、社内用品など）</option>
    <option value="meeting">会議費</option>
    <option value="others">その他</option>
  </select>
</section>

{{-- 用途の詳細エリア --}}
<section>
  <label for="purpose">用途の詳細</label>
  <input type="textarea" id="purpose" name="purpose[]" value="{{ old('purpose.0') }}"
    class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow" placeholder="Type here">
</section>

{{-- 合計金額 --}}
<section class="flex flex-col">
  <label for="total_amount">合計金額</label>
  <span class="text-xs text-gray-500">円や区切り文字として「,」などを入れる必要はありません。</span>
  <input type="text" id="total_amount" name="total_amount[]" value="{{ old('total_amount.0') }}"
    class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow" placeholder="Type here">

</section>