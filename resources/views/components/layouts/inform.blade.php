<div class="w-4/5	max-w-4xl	 mt-6 mx-auto space-y-4">
  <h1 class="border-b-2 border-black text-2xl">経費申請フォーム</h1>
  {{-- 領収書エリア --}}
  <section class="flex flex-col space-y-2">
    <label for="">領収書の画像</label>
    <span class="text-xs text-gray-500">※領収書は捨てずに保管しておいてください。</span>
    <div class="w-full flex items-center justify-between xl:justify-center xl:gap-20">
      {{-- 表面 --}}

      <label for="receipt_front"
        class="px-8 py-3 xl:px-20 xl:py-10 flex flex-col  border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer">
        <div class="flex flex-col items-center w-full">
          <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
          <span class="text-gray-500">表面を送付</span>
        </div>
        <div class="mt-1 w-20">
          <input type="file" id="receipt_back" name="receipt_back"
            class="text-[6px] file:py-1 file:text-[7px] file:border-0" required>
        </div>
      </label>


      {{-- 裏面 --}}

      <label for="receipt_back"
        class="px-8 py-3 xl:px-20 xl:py-10 flex flex-col border-dashed border-2 border-gray-500 bg-gray-200 rounded-md cursor-pointer">
        <div class="flex flex-col items-center w-full">
          <x-heroicon-o-arrow-up-tray class="w-6 h-6 text-gray-500" />
          <span class="text-gray-500">裏面を送付</span>
        </div>
        <div class="mt-1 w-20">
          <input type="file" id="receipt_back" name="receipt_back" {{-- class=" w-20 text-[10px] w-24 file:py-1 file:px-2 file:text-[10px] file:border-0" required> --}}
            class="text-[6px] file:text-[7px] file:py-1 file:border-0" required>

        </div>
      </label>




  </section>
  {{-- 使用年月日エリア --}}
  <section class="">
    <label for="date">使用年月日</label>
    <input type="date" id="date" class="w-full py-2 mt-1 border pr-5 pl-2 rounded-lg shadow" required>
  </section>
  {{-- 用途項目エリア --}}
  {{-- オプションにvalue追加、データベース構造要確認 --}}
  <section>
    <label for="item">用途項目</label>
    <select name="" id="item" class="w-full py-2 px-2 mt-1 border pr-5 rounded-lg shadow" required>
      <option value="">選択してください</option>
      <option value="">交通費（定期）</option>
      <option value="">交通費（乗車券）</option>
      <option value="">備品・消耗品</option>
      <option value="">立替経費（部費、社内用品など）</option>
      <option value="">その他</option>
    </select>
  </section>
  {{-- 用途の詳細エリア --}}
  <section>
    <label for="purpose">用途の詳細</label>
    <input type="textarea" id="purpose" class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow"
      placeholder="Type here" required>
  </section>
  {{-- 合計金額 --}}
  <section class="flex flex-col">
    <label for="amount">合計金額</label>
    <span class="text-xs text-gray-500">「¥」や、区切り文字として「,」などを入れる必要はありません。</span>
    <input type="text" id="amount" class="w-full py-2 px-2 mt-1 border rounded-lg pr-10 shadow"
      placeholder="Type here" required>
  </section>
  {{-- プラスボタン --}}
  <section>
    <x-heroicon-o-plus-circle class="w-10 h-10" />
  </section>
  {{-- 確認ボタン --}}
  <section>
    <button class="w-full py-3 text-white border border-gray-800 bg-gray-700 rounded-lg">確認</button>
  </section>
</div>
