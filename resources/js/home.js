// resources/js/home.js
import axios from "axios";

// DOM読み込み完了時にまとめてイベント登録
document.addEventListener("DOMContentLoaded", () => {
    // ◆ 新規追加ボタン (収入)
    const incBtn = document.getElementById("incBtn");
    if (incBtn) {
        incBtn.addEventListener("click", () => {
            // 新規追加なので _method=POST
            document.getElementById("methodInput").value = "POST";
            // 収入: type_id=2
            document.getElementById("type_id").value = 2;
            // フォームの action="/incomes"
            document.getElementById("modal-form").action = "/incomes";

            // 収入カテゴリのみ表示
            showIncomeCategory();
            openModal("income");
        });
    }

    // ◆ 新規追加ボタン (支出)
    const spnBtn = document.getElementById("spnBtn");
    if (spnBtn) {
        spnBtn.addEventListener("click", () => {
            document.getElementById("methodInput").value = "POST";
            document.getElementById("type_id").value = 1;
            document.getElementById("modal-form").action = "/spendings";

            // 支出カテゴリのみ表示
            showSpendingCategory();
            openModal("spending");
        });
    }

    // ◆ 編集ボタン (収入)
    const editIncomeBtns = document.querySelectorAll(".edit-income-btn");
    editIncomeBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tr = btn.closest("tr.income-row");
            if (!tr) return;

            // data属性からIDとJSON文字列を取得
            const incomeId = tr.dataset.id;
            const incomeDataJson = tr.dataset.json;

            // PUTメソッド
            document.getElementById("methodInput").value = "PUT";
            document.getElementById("type_id").value = 2;
            document.getElementById(
                "modal-form"
            ).action = `/incomes/${incomeId}`;

            // JSONをパースしてフォームに値セット
            const incomeData = JSON.parse(incomeDataJson);
            document.getElementById("date").value = incomeData.date;
            document.getElementById("amount").value = incomeData.amount;
            document.getElementById("comment").value = incomeData.comment || "";

            showIncomeCategory();
            if (incomeData.category_id) {
                document.getElementById("incomeCategory").value =
                    incomeData.category_id;
            }

            openModal("income");
        });
    });

    // ◆ 編集ボタン (支出)
    const editSpendingBtns = document.querySelectorAll(".edit-spending-btn");
    editSpendingBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const tr = btn.closest("tr.spending-row");
            if (!tr) return;

            const spendingId = tr.dataset.id;
            const spendingDataJson = tr.dataset.json;

            document.getElementById("methodInput").value = "PUT";
            document.getElementById("type_id").value = 1;
            document.getElementById(
                "modal-form"
            ).action = `/spendings/${spendingId}`;

            const spendingData = JSON.parse(spendingDataJson);
            document.getElementById("date").value = spendingData.date;
            document.getElementById("amount").value = spendingData.amount;
            document.getElementById("comment").value =
                spendingData.comment || "";

            showSpendingCategory();
            if (spendingData.category_id) {
                document.getElementById("spendingCategory").value =
                    spendingData.category_id;
            }

            openModal("spending");
        });
    });

    // ◆ モーダル「閉じる」ボタン
    const closeModalBtn = document.getElementById("closeModalBtn");
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", closeModal);
    }

    // ◆ フォーム送信
    const modalForm = document.getElementById("modal-form");
    if (modalForm) {
        modalForm.addEventListener("submit", submitForm);
    }

    // ---------- 関数群 ----------

    // 収入カテゴリだけ表示
    function showIncomeCategory() {
        const incomeCat = document.getElementById("incomeCategory");
        const spendingCat = document.getElementById("spendingCategory");
        if (incomeCat && spendingCat) {
            incomeCat.style.display = "block";
            incomeCat.disabled = false;
            spendingCat.style.display = "none";
            spendingCat.disabled = true;
        }
    }

    // 支出カテゴリだけ表示
    function showSpendingCategory() {
        const incomeCat = document.getElementById("incomeCategory");
        const spendingCat = document.getElementById("spendingCategory");
        if (incomeCat && spendingCat) {
            incomeCat.style.display = "none";
            incomeCat.disabled = true;
            spendingCat.style.display = "block";
            spendingCat.disabled = false;
        }
    }

    // グローバルスコープ変数
    const modal = document.getElementById("modal");
    const modalTitle = document.getElementById("modal-title");
    const formCover = document.getElementById("formCover");

    // モーダルを開く
    function openModal(type) {
        if (!modal) return;

        modal.classList.remove("hidden");
        setTimeout(() => modal.classList.add("show"), 10);

        if (modalTitle) {
            modalTitle.textContent =
                type === "income" ? "収入を追加" : "支出を追加";
        }

        if (formCover) {
            formCover.classList.toggle("bg-green-200", type === "income");
            formCover.classList.toggle("bg-red-200", type === "spending");
        }
    }

    function closeModal(e) {
        // modal 要素が見つからない（null）の場合、何もせず終了。
        // document.getElementById("modal") が存在しないときにエラーを防ぐ。
        if (!modal) return;
        // もし引数 e があり、かつクリック先が formCover 内なら -> 閉じない (何もしない)
        if (e && formCover && formCover.contains(e.target)) {
            return;
        }
        // それ以外はモーダルを閉じる
        modal.classList.remove("show");
        setTimeout(() => modal.classList.add("hidden"), 500);
    }
    // (A) 背景クリック時に closeModal(e) を呼ぶ
    if (modal) {
        modal.addEventListener("click", (event) => {
            // closeModal に event を渡す
            closeModal(event);
        });
    }
    // (B) 「閉じる」ボタンクリック時に closeModal() を呼ぶ
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            // ボタンを押したら  e.target == closeModalBtn なので formCover ではない
            // 特に判定せず閉じる
            closeModal();
        });
    }

    // フォーム送信 (非同期 or 通常)
    // axios で送る
    function submitForm(event) {
        event.preventDefault();

        const form = event.target; // modal-form
        const formData = new FormData(form);

        axios
            .post(form.action, formData)
            .then((response) => {
                if (response.data.success) {
                    alert(response.data.message);
                    location.reload();
                } else {
                    alert(
                        "エラー: " +
                            (response.data.message || "入力を確認してください")
                    );
                }
            })
            .catch((error) => {
                console.error("送信エラー:", error);
                alert("送信に失敗しました");
            });
    }
});
