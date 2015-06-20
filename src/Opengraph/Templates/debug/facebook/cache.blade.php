<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td colspan="2">{{{ $fb->id }}}</td>
    </tr>
    <tr>
        <th>建立時間</th>
        <td colspan="2">
            {{{ $fb->created_time }}}
        </td>
    </tr>
    <tr>
        <th>摘要</th>
        <td><code>og:description</code></td>
        <td>
            {{{ $fb->description }}}
        </td>
    </tr>
    <tr>
        <th>網站名稱</th>
        <td><code>og:site_name</code></td>
        <td>
            {{{ $fb->site_name }}}
        </td>
    </tr>
    <tr>
        <th>頁面標題</th>
        <td><code>og:title</code></td>
        <td>
            {{{ $fb->title }}}
        </td>
    </tr>
    <tr>
        <th>類型</th>
        <td><code>og:type</code></td>
        <td>
            {{{ $fb->type }}}
        </td>
    </tr>
    <tr>
        <th>最後更新時間</th>
        <td><code>og:updated_time</code></td>
        <td>
            {{{ $fb->updated_time }}}
        </td>
    </tr>
    <tr>
        <th>頁面網址</th>
        <td><code>og:url</code></td>
        <td>
            {{{ $fb->url }}}
        </td>
    </tr>
    <tr>
        <th>圖片</th>
        <td><code>og:image</code></td>
        <td>
            @foreach((array) $fb->image as $image)
            <a target="_blank" href="{{{ $image->url }}}">
                <img style="max-height: 48px; max-width: 48px;" src="{{{ $image->url }}}" alt="{{{ $image->alt ? : 'Image' }}}" rel="nofollow" />
            </a>
            @endforeach
        </td>
    </tr>
</table>