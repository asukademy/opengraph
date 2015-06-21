<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-danger">Open Graph 錯誤訊息</h3>

        <p>
            會出現這個訊息，表示此網頁的 Open graph 設定錯誤，導致 Facebook 無法分析網頁內容。
            我們將顯示先前的舊資料，並提供 Facebook 回傳的錯誤訊息，您可以參考以下訊息進行除錯。
        </p>

        <p>
            由於 Facebook 所回傳的錯誤訊息並沒有提供公開列表，我們難以將這些訊息預先中文化，若您發現不確定的錯誤訊息，
            我們很貼心的替您準備了快速 Google 連結喔 >.^
        </p>

        <div class="panel panel-danger">
            <div class="panel-heading">
                錯誤訊息： {{{ $item->og_error['error.message'] }}} |
                錯誤代碼： {{{ $item->og_error['error.code'] }}} - {{{ $item->og_error['error.error_subcode'] }}}
            </div>
            <div class="panel-body">
                <h4 class="text-danger">{{{ $item->og_error['error.error_user_title'] }}}</h4>
                <p>
                    {{{ $item->og_error['error.error_user_msg'] }}}
                </p>
            </div>
        </div>
        <p class="text-right">
            <a target="_blank" rel="nofollow" class="btn btn-info" href="https://www.google.com.tw/search?{{{ http_build_query(['q' => 'Facebook open graph ' . $item->og_error['error.error_user_title']]) }}}">
                <span class="glyphicon glyphicon-search"></span> 按此查詢關於 {{{ $item->og_error['error.error_user_title'] }}} 的錯誤訊息
            </a>
        </p>
    </div>
</div>
