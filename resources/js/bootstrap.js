// 例: resources/js/bootstrap.js

import axios from "axios";

// グローバルに axios を使いたいなら:
window.axios = axios;

// CSRFトークンを meta タグから取得してデフォルトヘッダーに設定
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-introduction"
    );
}
/* <meta name="csrf-token"> を置いている」なら、if (token) { ... } else { ... } を省略しても機能的には困らない。 */

// X-Requested-With を常に付与（Ajaxリクエスト扱いさせたい場合）
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
