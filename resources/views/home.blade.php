<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LaravelのCSRFトークン (JSで読み取るために必要) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Viteでビルドする対象ファイル (app.css, app.js など) -->
    <!-- home.js は app.js 内で import する、または下記のように個別指定してもOK -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <!-- 新規追加(収入)ボタン (onclick廃止) -->
                    <button id="incBtn"
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
                        <!-- data属性にJSON文字列を埋め込む -->
                        <tr
                            class="income-row"
                            data-id="{{ $income->id }}"
                            data-json='@json($income)'
                        >
                            <td class="border px-4 py-2">{{ $income->date }}</td>
                            <td class="border px-4 py-2">{{ $income->amount }}</td>
                            <td class="border px-4 py-2">{{ $income->comment }}</td>
                            <td class="border px-4 py-2">{{ $income->category->name ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <!-- 編集ボタン (onclick廃止) -->
                                <button class="edit-income-btn bg-blue-500 text-white px-2 py-1 rounded">
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
                    <!-- 新規追加(支出)ボタン (onclick廃止) -->
                    <button id="spnBtn"
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
                        <tr
                            class="spending-row"
                            data-id="{{ $spending->id }}"
                            data-json='@json($spending)'
                        >
                            <td class="border px-4 py-2">{{ $spending->date }}</td>
                            <td class="border px-4 py-2">{{ $spending->amount }}</td>
                            <td class="border px-4 py-2">{{ $spending->comment }}</td>
                            <td class="border px-4 py-2">{{ $spending->category->name ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <!-- 編集ボタン (onclick廃止) -->
                                <button class="edit-spending-btn bg-blue-500 text-white px-2 py-1 rounded">
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
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center modal hidden">
        <div id="formCover" class="opacity-95 p-8 rounded-lg shadow-lg w-3/5">
            <h3 id="modal-title" class="text-xl mb-4 flex place-content-center">フォームタイトル</h3>

            <!-- フォーム -->
            <form id="modal-form" action="" method="POST">
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

                <!-- モーダル閉じるボタン -->
                <button type="button" id="closeModalBtn" class="mt-4 w-full text-center text-black-500">
                    閉じる
                </button>
            </form>
        </div>
    </div>

</body>
</html>
