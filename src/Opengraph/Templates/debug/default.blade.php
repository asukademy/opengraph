{{-- Part of og project. --}}
@extends('_global.html')

@if ($item->notNull())
    @section('siteTitle')網址: {{{ $q }}} 分析結果 | Facebook Open Graph 與 SEO 檢測器 (Debugger)@stop

    @section('meta')
<meta name="description" content="{{{ $fb->description ? : $analysis->findMeta('general', 'description')->content }}}" />
    @stop
@endif

@section('body')
    <div class="container">
        {{ (new \Windwalker\Core\Widget\Widget('windwalker.message.default'))->render(['flashes' => $flashes]) }}
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form action="{{{ $router->buildHtml('debug') }}}" method="post">
                    <div class="row">
                        <div class="input-group col-md-9 pull-left">
                            <input type="text" class="form-control" name="q" value="{{{ $q }}}" placeholder="輸入檢測網址...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-wrench"></span> 檢測</button>
                    </span>
                        </div><!-- /input-group -->

                        <div class="col-md-2 pull-left">
                            <button class="btn btn-success" type="button" onclick="this.form.refresh_fb.value=1;this.form.submit();">
                                <span class="glyphicon glyphicon-refresh"></span> 刷新
                            </button>
                        </div>
                    </div>
                    <input name="refresh_fb" type="hidden" value="0" />
                </form>
            </div>
        </div>

        <br /><br />

        <div class="text-center">
            <div class="addthis_sharing_toolbox"></div>
        </div>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4d7f6648467b99e4" async="async"></script>

        <br /><br />

        @if (!isset($analysis))
            <p>
                輸入您想要檢測的網址，這個工具會幫您確認是否有足夠的 Opengraph 資訊能夠呈現優良的 Facebook 社群分享內容。
            </p>
            <p>
                若發現資訊不足，我們會嘗試從頁面上取得的資料給您適當的 Opengraph 建議。
            </p>
            <hr />
            <h3>什麼是 Open Graph？</h3>
            <p>
                Open Graph 是 Facebook 專用的一種網頁資訊結構，加入適當的 Open graph 資訊在網站上，可以讓網友分享您的網站時，
                顯示更正確的資料，吸引更多人來訪您的網站。
            </p>
            <p class="text-center">
                <img width="500" src="http://i.imgur.com/HFPz8gY.jpg" alt="example" />
            </p>
        @else
            @include('result')
        @endif
    </div>
@stop
