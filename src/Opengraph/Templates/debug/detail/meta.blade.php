{{-- Part of og project. --}}

<table class="meta-table table table-bordered">
    <tbody>
    @foreach($analysis->getMetas('general') as $meta)
        <tr>
            <td>一般</td>
            <td>
                {{{ $meta->name }}}
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
            <td>Facebook</td>
            <td>
                {{{ $meta->property }}}
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
            <td>Twitter</td>
            <td>
                {{{ $meta->property }}}
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