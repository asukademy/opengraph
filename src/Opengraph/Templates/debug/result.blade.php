<style>
    table tbody tr th {
        white-space: nowrap;
    }
    ul.og-imgs {
        padding: 0;
    }
    ul.og-imgs li {
        list-style: none;
        margin-bottom: 0.5em;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>預覽</legend>
            <img src="http://i.imgur.com/hC0nqOs.jpg" alt="img" />
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <legend>檢測結果</legend>

            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th width="80">檢測分數</th>
                    <td><span class="label {{{ $score_label }}}" style="font-size: 18px;">{{{ $score }}} / 100</span></td>
                    <td></td>
                </tr>
                <tr>
                    <th>頁面標題</th>
                    <td><code>og:title</code></td>
                    <td>
                        @if ($og->title->content)
                            @if ($og->title->warning)
                            <div class="text-warning">
                                <small>
                                    <span class="glyphicon glyphicon-warning-sign"></span>
                                    沒有 Opengraph 宣告，但從 Metadata 中取得
                                </small>
                            </div>
                            @else
                            <small><span class="text-success glyphicon glyphicon-ok"></span></small>
                            @endif
                            {{{ $og->title->content }}}
                        @else
                            <span class="text-danger">
                                <span class="glyphicon glyphicon-warning-sign"></span> 您的頁面沒有提供這項資訊
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>網站名稱</th>
                    <td><code>og:site_name</code></td>
                    <td>
                        @if ($og->site_name->content)
                            <small><span class="text-success glyphicon glyphicon-ok"></span></small>
                            {{{ $og->site_name->content }}}
                        @else
                            <span class="text-danger">
                                <span class="glyphicon glyphicon-warning-sign"></span> 您的頁面沒有提供這項資訊
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>頁面網址</th>
                    <td><code>og:url</code></td>
                    <td>
                        @if ($og->url->content)
                            @if ($og->url->warning)
                                <div class="text-warning">
                                    <small>
                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                        沒有 Opengraph 宣告
                                    </small>
                                </div>
                            @else
                                <small><span class="text-success glyphicon glyphicon-ok"></span></small>
                            @endif
                            <a target="_blank" href="{{{ $og->url->content }}}">{{{ $og->url->content }}}</a>
                        @else
                            <span class="text-danger">
                                <span class="glyphicon glyphicon-warning-sign"></span> 您的頁面沒有提供這項資訊
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>預覽圖片</th>
                    <td><code>og:image</code></td>
                    <td style="word-break: break-all;">
                        @if ($og->images->content)
                            @if ($og->images->warning)
                                <div class="text-warning">
                                    <small>
                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                        沒有 Opengraph 宣告，從頁面中取得前10張圖片
                                    </small>
                                </div>
                            @else
                                <small><span class="text-success glyphicon glyphicon-ok"></span></small>
                            @endif
                            <ul class="og-imgs">
                            @foreach($og->images->content as $image)
                                <li>
                                    <a target="_blank" href="{{{ $image }}}">{{{ $image }}}</a>
                                </li>
                            @endforeach
                            </ul>
                        @else
                            <span class="text-danger">
                                <span class="glyphicon glyphicon-warning-sign"></span> 您的頁面沒有提供這項資訊
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>摘要</th>
                    <td><code>og:description</code></td>
                    <td>
                        @if ($og->description->content)
                            @if ($og->description->warning)
                                <div class="text-warning">
                                    <span class="glyphicon glyphicon-warning-sign"></span>
                                    沒有 Opengraph 宣告，但從 Metadata 中取得此資訊
                                </div>
                            @else
                                <small><span class="text-success glyphicon glyphicon-ok"></span></small>
                            @endif
                            {{{ $og->description->content }}}
                        @else
                            <span class="text-danger">
                                <span class="glyphicon glyphicon-warning-sign"></span> 您的頁面沒有提供這項資訊
                            </span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>

        </fieldset>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>Facebook 上的快取</legend>

            @include('facebook.cache')
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <legend>建議您還可以加上的 Opengraph 標籤</legend>
            <textarea class="form-control" disabled style="cursor: text ;font-family: 'Source Code Pro', Monaco, Consolas, 'Lucida Console', monospace" cols="30" rows="10">{{{ $recommend }}}</textarea>
        </fieldset>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-12">

        @include('detail.og')

        <h4>META</h4>
        @include('detail.meta')

    </div>
</div>