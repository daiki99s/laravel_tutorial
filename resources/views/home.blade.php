<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap.js'])
    <title>ホーム</title>
    <style>
        .modal {
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .modal.show {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100">

    <h1 class="text-center text-2xl font-bold my-4">ホーム</h1>

    {{-- フラッシュメッセージ表示 --}}
    @if(session('message'))
        <div class="bg-green-200 text-green-800 p-2 mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- メインコンテナ -->
    <div class="flex justify-between space-x-8 p-8">

        <!-- 収入セクション -->
        <div class="w-1/2 p-4 bg-white rounded shadow">
            <div class="flex flex-col items-center mb-4">
                <div class="flex items-center">
                    <h2 class="text-lg font-semibold">収入一覧</h2>
                    <!-- 新規追加(収入)ボタン -->
                    <button
                        id="incBtn"
                        class="bg-green-500 text-white py-2 px-4 rounded-full h-12 w-12 flex items-center justify-center hover:scale-110 transition-transform duration-200 ml-4"
                    >
                        ＋
                    </button>
                </div>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">日付</th>
                        <th class="border px-4 py-2">金額</th>
                        <th class="border px-4 py-2">コメント</th>
                        <th class="border px-4 py-2">Incomeカテゴリ</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomes as $income)
                        <!-- data-income に JSON文字列として埋め込む -->
                        <tr data-income='@json($income)'>
                            <td class="border px-4 py-2">{{ $income->date }}</td>
                            <td class="border px-4 py-2">{{ $income->amount }}</td>
                            <td class="border px-4 py-2">{{ $income->comment }}</td>
                            <td class="border px-4 py-2">{{ $income->category->name ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <!-- 編集ボタン -->
                                <button
                                    class="bg-blue-500 text-white px-2 py-1 rounded"
                                    onclick="openEditModalIncome({{ $income->id }}, this.parentNode.parentNode.dataset.income)"
                                >
                                    編集
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 支出セクション -->
        <div class="w-1/2 p-4 bg-white rounded shadow">
            <div class="flex flex-col items-center mb-4">
                <div class="flex items-center">
                    <h2 class="text-lg font-semibold">支出一覧</h2>
                    <!-- 新規追加(支出)ボタン -->
                    <button
                        id="spnBtn"
                        class="bg-red-500 text-white py-2 px-4 rounded-full h-12 w-12 flex items-center justify-center hover:scale-110 transition-transform duration-200 ml-4"
                    >
                        ＋
                    </button>
                </div>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">日付</th>
                        <th class="border px-4 py-2">金額</th>
                        <th class="border px-4 py-2">コメント</th>
                        <th class="border px-4 py-2">Spendingカテゴリ</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spendings as $spending)
                        <tr data-spending='@json($spending)'>
                            <td class="border px-4 py-2">{{ $spending->date }}</td>
                            <td class="border px-4 py-2">{{ $spending->amount }}</td>
                            <td class="border px-4 py-2">{{ $spending->comment }}</td>
                            <td class="border px-4 py-2">{{ $spending->category->name ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <!-- 編集ボタン (支出) -->
                                <button
                                    class="bg-blue-500 text-white px-2 py-1 rounded"
                                    onclick="openEditModalSpending({{ $spending->id }}, this.parentNode.parentNode.dataset.spending)"
                                >
                                    編集
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


    <!-- モーダル -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center modal hidden" onclick="closeModal(event)">
        <div id="formCover" class="opacity-95 p-8 rounded-lg shadow-lg w-3/5" onclick="event.stopPropagation()">
            <h3 id="modal-title" class="text-xl mb-4 flex place-content-center">フォームタイトル</h3>

            <!-- フォーム -->
            <form id="modal-form" action="" method="POST" onsubmit="submitForm(event)">
                @csrf
                <!-- _method (新規=POST, 編集=PUT) を切り替える -->
                <input type="hidden" name="_method" value="POST" id="methodInput">

                <!-- type_id: income=2 / spending=1 -->
                <input type="hidden" name="type_id" id="type_id" value="">

                <!-- user_id (例: 全ユーザーのうち最初のものを割り当て？) -->
                @foreach ($users as $user)
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                @endforeach

                <!-- 収入カテゴリ select -->
                <select id="incomeCategory" name="category_id" class="mb-4">
                    <option value="">収入カテゴリを選択</option>
                    @foreach($incomeCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <!-- 支出カテゴリ select -->
                <select id="spendingCategory" name="category_id" class="mb-4">
                    <option value="">支出カテゴリを選択</option>
                    @foreach($spendingCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <!-- 日付 -->
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">日付</label>
                    <input type="date" required name="date" id="date" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <!-- 金額 -->
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700">金額</label>
                    <input type="number" required name="amount" id="amount" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>

                <!-- コメント -->
                <div class="mb-4">
                    <label for="comment" class="block text-gray-700">コメント</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full p-2 border border-gray-300 rounded-lg resize-none"></textarea>
                </div>

                <div class="flex place-content-center">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:scale-110 transition-transform duration-200">
                        確定
                    </button>
                </div>
                <button type="button" onclick="closeModal()" class="mt-4 w-full text-center text-black-500">
                    閉じる
                </button>
            </form>
        </div>
    </div>


    <!-- スクリプト群 -->
    <script>
    // DOMロード後の初期設定
    document.addEventListener('DOMContentLoaded', () => {
        // 新規追加ボタン (収入)
        const incomeBtn = document.getElementById('incBtn');
        // 新規追加ボタン (支出)
        const spendingBtn = document.getElementById('spnBtn');

        // カテゴリselect
        const incomeCategory = document.getElementById('incomeCategory');
        const spendingCategory = document.getElementById('spendingCategory');

        // type_id, methodInput
        const typeInput = document.getElementById('type_id');
        const methodInput = document.getElementById('methodInput');

        // 初期はカテゴリ非表示
        incomeCategory.style.display = 'none';
        spendingCategory.style.display = 'none';
        incomeCategory.disabled = true;
        spendingCategory.disabled = true;

        // 収入ボタンを押したときの処理
        if (incomeBtn) {
            incomeBtn.addEventListener('click', () => {
                // 新規なので POST
                methodInput.value = 'POST';
                // 収入: type_id = 2
                typeInput.value = 2;

                // フォームの action を '/incomes' に設定
                document.getElementById('modal-form').action = '/incomes';

                // 収入カテゴリのみ表示
                incomeCategory.style.display = 'block';
                incomeCategory.disabled = false;
                spendingCategory.style.display = 'none';
                spendingCategory.disabled = true;

                // モーダルを開く
                openModal('income');
            });
        }

        // 支出ボタン
        if (spendingBtn) {
            spendingBtn.addEventListener('click', () => {
                methodInput.value = 'POST';
                typeInput.value = 1;
                document.getElementById('modal-form').action = '/spendings';

                spendingCategory.style.display = 'block';
                spendingCategory.disabled = false;
                incomeCategory.style.display = 'none';
                incomeCategory.disabled = true;

                openModal('spending');
            });
        }
    });

    // 新規/編集兼用モーダルを開く
    function openModal(type) {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('show'), 10);

        // タイトル
        document.getElementById('modal-title').textContent =
            type === 'income' ? '収入を追加' : '支出を追加';

        // 背景色
        const formCover = document.getElementById('formCover');
        formCover.classList.toggle('bg-green-200', type === 'income');
        formCover.classList.toggle('bg-red-200', type === 'spending');
    }

    // モーダルを閉じる
    function closeModal(event) {
        const modal = document.getElementById('modal');
        modal.classList.remove('show');
        setTimeout(() => modal.classList.add('hidden'), 500);
    }

    // ---- 収入編集モーダル ----
    function openEditModalIncome(incomeId, incomeDataJson) {
        const modalForm   = document.getElementById('modal-form');
        const methodInput = document.getElementById('methodInput');
        const typeInput   = document.getElementById('type_id');
        const incomeData  = JSON.parse(incomeDataJson);

        // フォームactionを `/incomes/{id}` に
        modalForm.action = `/incomes/${incomeId}`;
        // _method=PUT (編集モード)
        methodInput.value = 'PUT';
        // 収入
        typeInput.value = 2;

        // 収入カテゴリのみ表示
        const incomeCategory = document.getElementById('incomeCategory');
        const spendingCategory = document.getElementById('spendingCategory');
        incomeCategory.style.display = 'block';
        incomeCategory.disabled = false;
        spendingCategory.style.display = 'none';
        spendingCategory.disabled = true;

        // 既存データをフォームにセット
        document.getElementById('date').value    = incomeData.date;
        document.getElementById('amount').value  = incomeData.amount;
        document.getElementById('comment').value = incomeData.comment ?? '';
        if (incomeData.category_id) {
            incomeCategory.value = incomeData.category_id;
        }

        openModal('income');
    }

    // ---- 支出編集モーダル ----
    function openEditModalSpending(spendingId, spendingDataJson) {
        const modalForm   = document.getElementById('modal-form');
        const methodInput = document.getElementById('methodInput');
        const typeInput   = document.getElementById('type_id');
        const spendingData = JSON.parse(spendingDataJson);

        // フォームactionを `/spendings/{id}` に
        modalForm.action = `/spendings/${spendingId}`;
        // _method=PUT (編集モード)
        methodInput.value = 'PUT';
        // 支出
        typeInput.value = 1;

        // 支出カテゴリのみ表示
        const incomeCategory = document.getElementById('incomeCategory');
        const spendingCategory = document.getElementById('spendingCategory');
        incomeCategory.style.display = 'none';
        incomeCategory.disabled = true;
        spendingCategory.style.display = 'block';
        spendingCategory.disabled = false;

        // 既存データをフォームにセット
        document.getElementById('date').value    = spendingData.date;
        document.getElementById('amount').value  = spendingData.amount;
        document.getElementById('comment').value = spendingData.comment ?? '';
        if (spendingData.category_id) {
            spendingCategory.value = spendingData.category_id;
        }

        openModal('spending');
    }


    // 送信をaxiosで行う
    function submitForm(event) {
        event.preventDefault();

        const form     = document.getElementById('modal-form');
        const formData = new FormData(form);

        axios.post(form.action, formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.data.success) {
                alert(response.data.message);
                location.reload();
            } else {
                alert('エラー: ' + (response.data.message || '入力を確認してください'));
            }
        })
        .catch(error => {
            console.error('送信エラー:', error);
            alert('送信に失敗しました');
        });
    }
    </script>

</body>
</html>
