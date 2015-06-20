{{-- Part of og project. --}}

<table class="meta-table table table-bordered">
    <thead>
    <tr>
        <th>類型</th>
        <th>名稱</th>
        <th>內容</th>
        <th>完整 Tag</th>
    </tr>
    </thead>
    <tbody>
    @foreach($analysis->getMetas('general') as $meta)
        <tr>
            <td>
                <span class="label label-success">
                    一般
                </span>
            </td>
            <td>
                <code>{{{ $meta->name }}}</code>
            </td>
            <td>
                {{{ $meta->content }}}
            </td>
            <td>
                <code>
                    {{{ $meta->outerhtml }}}
                </code>
            </td>
        </tr>
    @endforeach

    @foreach($analysis->getMetas('facebook') as $meta)
        <tr>
            <td>
                <span class="label label-primary">
                    Facebook
                </span>
            </td>
            <td>
                <code>{{{ $meta->property }}}</code>
            </td>
            <td>
                {{{ $meta->content }}}
            </td>
            <td>
                <code>
                    {{{ $meta->outerhtml }}}
                </code>
            </td>
        </tr>
    @endforeach

    @foreach($analysis->getMetas('twitter') as $meta)
        <tr>
            <td>
                <span class="label label-info">
                    Twitter
                </span>
            </td>
            <td>
                <code>{{{ $meta->property }}}</code>
            </td>
            <td>
                {{{ $meta->content }}}
            </td>
            <td>
                <code>
                    {{{ $meta->outerhtml }}}
                </code>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>