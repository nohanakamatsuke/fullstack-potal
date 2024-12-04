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

        <form action="{{ route('expense.submit.confirm') }}" method="POST" enctype="multipart/form-data"
            class="w-4/5	max-w-4xl	mt-5 mx-auto">
            @csrf
            <h1 class="border-b-2 border-black text-2xl">経費申請フォーム</h1>
            <div id="inside-form" class="w-full max-w-4xl mt-3 mx-auto">

                {{-- フォーム内容 --}}
                <div id="expense-form-content" class="space-y-4">
                    <h1 id="number-of-form" class="border-l-4 border-gray-400 text-lg mt-5 p-1">1件目</h1>
                    <x-layouts.inform />
                </div>

                <div id="button-group" class="flex space-x-2 mt-3">
                    {{-- プラスボタン --}}
                    <section id="plus-btn" class="w-fit">
                        <x-layouts.plus-button />
                    </section>

                    {{-- マイナスボタン　※デフォルトで非表示 --}}
                    <section id="minus-btn" class="hidden w-fit">
                        <x-layouts.minus-button />
                    </section>
                </div>

            </div>
            {{-- エラーメッセージ --}}
            @if ($errors->any())
                <div class="flex items-center space-x-1">
                    <x-heroicon-c-exclamation-triangle class="w-5 h-5 text-red-500" />
                    <span class="text-red-500 text-sm text-center">{{ $errors->first() }}</span>
                </div>
            @endif

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
        let formIndex = {{ session('form_count', 1) }};
        // 最大フォーム数を10件に設定
        const MAX_FORMS = 10;

        // HTML要素をidにて取得
        const buttonGroup = document.getElementById('button-group')
        const plusBtn = document.getElementById('plus-btn');
        const minusBtn = document.getElementById('minus-btn');
        const formContainer = document.getElementById('inside-form');

        // セッションに保存された、フォームの件数分だけフォーム生成
        for (let i = 1; i < formIndex; i++) {
            const originalForm = document.querySelector('#expense-form-content');
            let newForm = originalForm.cloneNode(true);
            newForm.id = `expense-form-content-${i + 1}`;
            const formNumber = newForm.querySelector('#number-of-form');
            formNumber.innerHTML = `${i + 1}件目`;
            buttonGroup.before(newForm);
            minusBtn.classList.remove('hidden');
        }

        // プラスボタンををクリックした際
        plusBtn.addEventListener('click', function() {

            // インデックス番号をカウントアップ
            formIndex++;

            // 本家のフォーム要素
            const originalForm = document.querySelector('#expense-form-content');

            // フォームのコピーを生成
            let newForm = originalForm.cloneNode(true);

            // フォーム内容クリア
            newForm.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            // CSRFトークンの削除（オリジナルのトークンのみを使用）
            newForm.querySelectorAll('input[name="_token"]').forEach(input => {
                input.remove();
            });

            // フォームのidをインデックスによって指定
            newForm.id = `expense-form-content-${formIndex}`;

            // 件数のh１要素を取得
            const formNumber = newForm.querySelector('#number-of-form');

            //件数のh１要素を更新
            formNumber.innerHTML = `${formIndex}件目`;

            // ボタンの直前に生成したフォーム要素を配置
            buttonGroup.before(newForm)

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
