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

    <form action="" method="POST" class="w-4/5	max-w-4xl	mt-5 mx-auto">
      <h1 class="border-b-2 border-black text-2xl">経費申請フォーム</h1>
      <div id="inside-form" class="w-full max-w-4xl mt-3 mx-auto">

        {{-- フォーム内容 --}}
        <div id="expense-form-content" class="space-y-4">
          <h1 id="number-of-form" class="border-l-4 border-gray-400 text-lg mt-5 p-1">1件目</h1>
          <x-layouts.inform />
        </div>

        {{-- プラスボタン --}}
        <section id="plus-btn" class="">
          <x-layouts.plus-button />
        </section>
      </div>

      {{-- 確認ボタン --}}
      <section>
        <x-layouts.confirm-button />
      </section>

    </form>

  </div>

</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    // インデックス番号を振り当てる
    let formIndex = 1;
    const MAX_FORMS = 10;

    document.getElementById('plus-btn').addEventListener('click', function() {

      const originalForm = document.querySelector('#expense-form-content');

      if (!originalForm) {
        console.error('フォーム要素が見つかりませんでした');
        return;
      }
      // インデックス番号をカウントアップ
      formIndex++;

      // フォームのコピーを生成
      let newForm = originalForm.outerHTML;

      // フォームのコピーのh1要素の中身をカウントアップしたもので配置
      newForm = newForm.replace('1件目', `${formIndex}件目`)

      // プラスボタンの直前に追加
      const plusButton = document.getElementById('plus-btn');
      plusButton.insertAdjacentHTML('beforebegin', newForm)

      // 10件以上の場合は、プラスボタンを隠す
      if (formIndex >= MAX_FORMS) {
        plusButton.style.display = 'none';
      }
    })

  })
</script>

</html>
