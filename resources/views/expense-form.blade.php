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
          @csrf
          <x-layouts.inform />
        </div>


        {{-- プラスボタン --}}
        <section id="plus-btn" class="mt-3">
          <x-layouts.plus-button />
        </section>

        {{-- マイナスボタン　※デフォルトで非表示 --}}
        <section id="minus-btn" class="mt-3 hidden">
          <x-layouts.minus-button />
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
    // 最大フォーム数を10件に設定
    const MAX_FORMS = 10;

    // HTML要素をidにて取得
    const plusBtn = document.getElementById('plus-btn');
    const minusBtn = document.getElementById('minus-btn');
    const formContainer = document.getElementById('inside-form');

    // プラスボタンををクリックした際
    plusBtn.addEventListener('click', function() {

      // インデックス番号をカウントアップ
      formIndex++;

      // 本家のフォーム要素
      const originalForm = document.querySelector('#expense-form-content');

      // フォームのコピーを生成
      let newForm = originalForm.cloneNode(true);

      // フォームのidをインデックスによって指定
      newForm.id = `expense-form-content-${formIndex}`;

      // 件数のh１要素を取得
      const formNumber = newForm.querySelector('#number-of-form');

      //件数のh１要素を更新
      formNumber.innerHTML = `${formIndex}件目`;

      // プラスボタンの直前に生成したフォーム要素を配置
      plusBtn.before(newForm)

      // 10件以上の場合は、プラスボタン隠す
      if (formIndex >= MAX_FORMS) {
        plusBtn.classList.add('hidden');
      }

      // マイナスボタンを表示させる
      minusBtn.classList.remove('hidden');
    });

    // マイナスボタンのクリックイベント
    minusBtn.addEventListener('click', function() {

      // 最後のフォームを削除
      const lastForm = document.querySelector(`#expense-form-content-${formIndex}`);

      if (lastForm) {
        lastForm.remove();
      }

      // カウンターを減らす
      formIndex--;

      // カウントが１に戻ったら、マイナスボタンを隠す
      if (formIndex === 1) {
        minusBtn.classList.add('hidden');
      }
      // カウントが10から少なくなったら、プラスボタンを再表示させる
      if (formIndex < MAX_FORMS) {
        plusBtn.classList.remove('hidden');
      }
    });
  });
</script>

</html>
