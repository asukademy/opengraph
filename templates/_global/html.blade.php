{{-- Part of starter project. --}}
<!doctype html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('siteTitle', 'Facebook Open Graph 與 SEO 檢測器 (Debugger)')</title>

    <link rel="shortcut icon" type="image/x-icon" href="http://simular.co/templates/tz_jollyany_joomla/favicon.ico" />
    <meta name="generator" content="The Time Machine" />
    <meta property="og:image" content="http://i.imgur.com/iWu7003.jpg" />
    <meta property="og:site_name" content="Facebook Open Graph 與 SEO 檢測器 (Debugger)" />
    <meta property="og:url" content="{{{ $currentUri }}}" />
    @section('meta')
    <meta property="og:description" content="這個工具會幫您確認是否有足夠的 Opengraph 資訊能夠呈現優良的 Facebook 社群分享內容。若發現資訊不足，我們會嘗試從頁面上取得的資料給您適當的 Opengraph 建議。" />
    <meta name="description" content="這個工具會幫您確認是否有足夠的 Opengraph 資訊能夠呈現優良的 Facebook 社群分享內容。若發現資訊不足，我們會嘗試從頁面上取得的資料給您適當的 Opengraph 建議。" />
    @show

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ $uri['base.path'] }}media/css/main.css" />
    @yield('style')

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @yield('script')

</head>
<body style="margin-top: 75px">
    @section('navbar')
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ $uri['base.path'] }}">Facebook Open Graph 與 SEO 檢測器 (Debugger)</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                     @section('nav')
                        <li class="active"><a href="{{ $uri['base.path'] }}">首頁</a></li>
                        <li><a target="_blank" href="http://simular.co/tools/keyword">關鍵字排名查詢</a></li>
                        <li><a target="_blank" href="http://simular.co/tools/rwd">RWD 測試工具</a></li>
                        <li><a target="_blank" href="http://simular.co/resources">網頁設計資源彙整</a></li>
                     @show
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    {{-- <li class="pull-right"><a href="{{ $uri['base.path'] }}admin">Admin</a></li> --}}
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
    @show

    @yield('body', 'Content')

    @section('copyright')
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <hr />

                    <footer>
                        &copy; Powered by <a href="http://simular.co" target="_blank">Simular - 夏木樂網頁設計</a> {{ $datetime->format('Y') }}
                    </footer>
                </div>
            </div>
        </div>
    </div>
    @show

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-59448570-9', 'auto');
        ga('send', 'pageview');

    </script>
</body>
</html>
