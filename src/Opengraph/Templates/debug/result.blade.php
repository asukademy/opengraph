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
    .preview-box-wrapper {
        display: block;
        cursor: pointer;
    }
    .preview-box {
        border: 1px solid #e9eaed;
        width: 471px;
        margin: 0 auto;
        position: relative;
    }
    .preview-img {
        width: 470px;
        height: 246px;
        background-size: cover;
        background-image: url(https://zero-space.s3.amazonaws.com/photos/f0fc3938-c8c1-43a0-b6c6-89ec58407090.jpg);
    }
    .preview-text-box-inner {
        margin-bottom: 10px;
        margin-left: 12px;
        margin-right: 12px;
        margin-top: 10px;
    }
    .preview-title {
        color: #141823;
        text-decoration: none;
        -webkit-transition: color .1s ease-in-out;
        cursor: pointer;
        font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;
        font-size: 19px;
        font-weight: 500;
        line-height: 22px;
        word-wrap: break-word;
        margin-bottom: 5px;
        max-height: 110px;
    }
    .preview-title a {
        color: #141823;
        text-decoration: none;
        -webkit-transition: color .1s ease-in-out;
        cursor: pointer;
    }
    .preview-box-link {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        height: 320px;
        width: 100%;
        z-index: 500;
    }
    .preview-desc {
        color: rgb(78, 86, 101);
        font-size: 13px;
        line-height: 16px;
        max-height: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .preview-host {
        -webkit-font-smoothing: antialiased;
        color: rgb(78, 86, 101);
        text-transform: uppercase;
        display: block;
        font-size: 13px;
        line-height: 18px;
        padding-top: 9px;
        position: relative;
        text-align: left;
        word-wrap: break-word;
    }

</style>
<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>預覽</legend>
            <div class="preview-box">
                <div class="preview-img">

                </div>
                <div class="preview-text-box">
                    <div class="preview-text-box-inner">
                        <a class="preview-box-link" href="{{{ $q }}}" rel="nofollow" target="_blank"></a>
                        <div class="preview-title">
                            <a href="{{{ $q }}}" rel="nofollow" target="_blank">
                                {{{ $fb->title }}}
                            </a>
                        </div>
                        <div class="preview-desc">
                            {{{ $fb->description }}}
                        </div>
                        <div class="preview-host">
                            <div class="text-muted">{{{ $preview_uri->getHost() }}}</div>
                        </div>
                    </div>
                </div>
            </div>
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
                            @foreach($og->images->content as $image)
                                <a target="_blank" href="{{{ $image }}}">
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