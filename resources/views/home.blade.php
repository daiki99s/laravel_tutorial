<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap.js'])
    <title>ホーム</title>
    <!-- Heroicons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@1.0.6/umd/heroicons.min.js"></script>
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

    <!-- コンテナ -->
    <div class="flex justify-between space-x-8 p-8">

        <!-- 収入セクション -->
        <div class="w-1/2 p-4 bg-white rounded shadow">
            <div class="flex place-content-center mb-4">
                <!-- 収入アイコン -->
                <h2 class="text-lg font-semibold">収入一覧</h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
            </div>
            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">日付</th>
                        <th class="border px-4 py-2">カテゴリ</th>
                        <th class="border px-4 py-2">金額</th>
                        <th class="border px-4 py-2">コメント</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomes as $income)
                        <tr>
                            <td class="border px-4 py-2">{{ $income->date }}</td>
                            <td class="border px-4 py-2">{{ $income->type->name }}</td>
                            <td class="border px-4 py-2">{{ $income->amount }}</td>
                            <td class="border px-4 py-2">{{ $income->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-center mt-4">
                <button id="incBtn" class="bg-green-500 text-white py-2 px-4 rounded-full h-12 w-12 flex items-center justify-center hover:scale-110 transition-transform duration-200" onclick="openModal('income')">＋</button>
            </div>
        </div>

        <!-- 支出セクション -->
        <div class="w-1/2 p-4 bg-white rounded shadow">
            <div class="flex place-content-center mb-4">
                <!-- 支出アイコン -->
                <h2 class="text-lg font-semibold">支出一覧</h2>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                </svg>
            </div>
            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">日付</th>
                        <th class="border px-4 py-2">カテゴリ</th>
                        <th class="border px-4 py-2">金額</th>
                        <th class="border px-4 py-2">コメント</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spendings as $spending)
                        <tr>
                            <td class="border px-4 py-2">{{ $spending->date }}</td>
                            <td class="border px-4 py-2">{{ $spending->type->name }}</td>
                            <td class="border px-4 py-2">{{ $spending->amount }}</td>
                            <td class="border px-4 py-2">{{ $spending->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-center mt-4">
                <button id="spnBtn" class="bg-red-500 text-white py-2 px-4 rounded-full h-12 w-12 flex items-center justify-center hover:scale-110 transition-transform duration-200" onclick="openModal('spending')">＋</button>
            </div>
        </div>

    </div>

    <!-- モーダル -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center modal hidden" onclick="closeModal(event)">
        <div id="formCover" class="opacity-95 p-8 rounded-lg shadow-lg w-3/5 h-3/5" onclick="event.stopPropagation()">
            <h3 id="modal-title" class="text-xl mb-4 flex place-content-center">フォームタイトル</h3>

            <!-- フォーム -->
            <form id="modal-form" action="" method="POST">
                @csrf
<input type="hidden" name="type_id" id="type_id" value="">
@foreach ($users as $user)
<input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
@endforeach

<!-- <select name="type_id" id="type_id" required class="w-full p-2 border border-gray-300 rounded-lg">
    <option value="" disabled selected>カテゴリを選択</option>
    @foreach ($types as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
</select> -->
<script>
    const incomeBtn = document.getElementById('incBtn');
    const spendingBtn = document.getElementById('spnBtn');
    spendingBtn.addEventListener('click', () => {
        document.getElementById('type_id').value = 1;
    });
    incomeBtn.addEventListener('click', () => {
        document.getElementById('type_id').value = 2;
    });
</script>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700">日付</label>
                    <input type="date" required name="date" id="date" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="amount" min="0" class="block text-gray-700">金額</label>
                    <input type="number" required name="amount" id="amount" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="comment" class="block text-gray-700">コメント</label>
                    <textarea name="comment" id="comment" rows="4" class="w-full p-2 border border-gray-300 rounded-lg resize-none h-full max-h-full"></textarea>
                </div>
                <div class="flex place-content-center">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:scale-110 transition-transform duration-200">確定</button>
                </div>
                <button type="button" onclick="closeModal()" class="mt-4 w-full text-center text-black-500">閉じる</button>
            </form>
        </div>
    </div>

    <script>

function submitForm(event) {
    event.preventDefault(); // 通常のフォーム送信を防ぐ

    const form = document.getElementById('modal-form');
    const formData = new FormData(form);

    // axiosでPOSTリクエストを送信
    axios.post(form.action, formData, {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
        .then(response => {
            if (response.data.success) {
                alert(response.data.message);  // 成功メッセージを表示
                location.reload();  // 成功後にページをリロードしてデータを反映
            } else {
                alert('エラー: ' + (response.data.message || '入力を確認してください'));  // エラーメッセージを表示
            }
        })
        .catch(error => {
            console.error('送信エラー:', error);
            alert('送信に失敗しました');  // 送信エラーが発生した場合のメッセージ
        });
}


        function openModal(type) {
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('show'), 10);
            document.getElementById('modal-title').textContent = type === 'income' ? '収入を追加' : '支出を追加';
            const formCover = document.getElementById('formCover');
            formCover.classList.toggle('bg-green-200', type === 'income');
            formCover.classList.toggle('bg-red-200', type !== 'income');
            document.getElementById('modal-form').action = type === 'income' ? '/incomes' : '/spendings'; // 適切なURLに設定
        }


        function closeModal(event) {
            const modal = document.getElementById('modal');
            modal.classList.remove('show');
            setTimeout(() => modal.classList.add('hidden'), 500);
        }
    </script>

</body>

</html>
