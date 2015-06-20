{{-- Part of og project. --}}
@extends('_global.html')

@section('siteTitle')Facebook Open Graph 與 SEO 檢測器 (Debugger)@stop

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="{{{ $router->buildHtml('debug') }}}" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{{ $q }}}" placeholder="輸入檢測網址...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-wrench"></span> 檢測</button>
                    </span>
                    </div><!-- /input-group -->
                </form>
            </div>
        </div>

        <br /><br /><br />

        @if (!isset($analysis))
            <p>
                Enter the URL you want to scrape to see how the page's markup appears to Facebook. Enter an access token to see details about the token such as when it expires.
            </p>
            <p>
                See our Webmasters doc for more info on the Facebook crawler and debugging your Open Graph markup.
            </p>
        @else
            @include('result')
        @endif
    </div>
@stop
