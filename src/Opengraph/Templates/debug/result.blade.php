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
                    <td>檢測分數</td>
                    <td><span class="label label-success">90 / 100</span></td>
                </tr>
                <tr>
                    <td>頁面標題</td>
                    <td><code>og:title</code></td>
                    <td></td>
                </tr>
                <tr>
                    <td>網站名稱</td>
                    <td><code>og:site_name</code></td>
                    <td></td>
                </tr>
                <tr>
                    <td>頁面網址</td>
                    <td><code>og:url</code></td>
                    <td></td>
                </tr>
                <tr>
                    <td>預覽圖片</td>
                    <td><code>og:image</code></td>
                    <td></td>
                </tr>
                </tbody>
            </table>

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