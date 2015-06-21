<style>
    table tbody tr th {
        white-space: nowrap;
    }

    a {
        color: #888;
    }
    a:hover {
        color: #666;
    }

    code a {
        color: #222;
    }
</style>

@if ($item->og_error)
    @include('error')

    <hr />
@endif

<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>預覽</legend>
            @include('preview')
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
                    <td style="word-break: break-all;">
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
                            <a rel="nofollow" target="_blank" href="{{{ $og->url->content }}}">{{{ $og->url->content }}}</a>
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
                            @foreach($og->images->content as $image)
                                <a rel="nofollow" target="_blank" href="{{{ $image }}}">
                                    <img style="max-width: 48px; max-height: 48px;" src="{{{ $image }}}" alt="img" />
                                </a>
                            @endforeach
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
            <br />
            <p>將這些 Meta 標籤複製到您網站上的 <code>{{{ htmlspecialchars('<head>') }}}</code> 區塊內 </p>
        </fieldset>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-12">
        <h3>頁面 Metadata 詳細資訊</h3>

        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#og" aria-controls="og" role="tab" data-toggle="tab">Facebook</a></li>
                <li role="presentation"><a href="#twitter" aria-controls="twitter" role="tab" data-toggle="tab">Twitter</a></li>
                <li role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">一般 Metadata</a></li>
                <li role="presentation"><a href="#metadata" aria-controls="metadata" role="tab" data-toggle="tab">所有 Metadata</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="padding-top: 30px;">
                <div role="tabpanel" class="tab-pane active" id="og">
                    @include('detail.og')
                </div>
                <div role="tabpanel" class="tab-pane" id="twitter">
                    @include('detail.twitter')
                </div>
                <div role="tabpanel" class="tab-pane" id="general">
                    @include('detail.general')
                </div>
                <div role="tabpanel" class="tab-pane" id="metadata">
                    @include('detail.meta')
                </div>
            </div>

        </div>

    </div>
</div>