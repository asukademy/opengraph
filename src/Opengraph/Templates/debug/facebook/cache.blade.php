<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{{ $fb->id }}}</td>
    </tr>
    <tr>
        <th>建立時間</th>
        <td>
            {{{ $fb->created_time }}}
        </td>
    </tr>
    <tr>
        <th>摘要 <br /><code>og:description</code></th>
        <td>
            {{{ $fb->description }}}
        </td>
    </tr>
    <tr>
        <th>網站名稱</th>
        <td>
            {{{ $fb->site_name }}}
        </td>
    </tr>
    <tr>
        <th>頁面標題</th>
        <td>
            {{{ $fb->title }}}
        </td>
    </tr>
    <tr>
        <th>類型</th>
        <td>
            {{{ $fb->website }}}
        </td>
    </tr>
    <tr>
        <th>最後更新時間</th>
        <td>
            {{{ $fb->updated_time }}}
        </td>
    </tr>
    <tr>
        <th>頁面網址</th>
        <td>
            {{{ $fb->url }}}
        </td>
    </tr>
    <tr>
        <th>圖片</th>
        <td>
            @foreach((array) $fb->image as $image)
            <a target="_blank" href="{{{ $image->url }}}">
                <img style="max-height: 48px; max-width: 48px;" src="{{{ $image->url }}}" alt="{{{ $image->alt ? : 'Image' }}}" rel="nofollow" />
            </a>
            @endforeach
        </td>
    </tr>
    <tr>
        <th></th>
        <td>

        </td>
    </tr>
</table>