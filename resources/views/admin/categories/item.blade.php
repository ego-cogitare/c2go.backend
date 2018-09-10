<tr>
    <td>{{ $item->id }}</td>
    <td>@if ($item->parent_id) <small style="padding-left:20px"> - {{ $item->name }}</small> @else {{ $item->name }} @endif</td>
    <td>{{ $item->is_active }}</td>
    <td>
        <a href="{{ url('/admin/categories/' . $item->id) }}" title="View category"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
        <a href="{{ url('/admin/categories/' . $item->id . '/edit') }}" title="Edit category"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

        <form method="POST" action="{{ url('/admin/categories' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-xs" title="Delete category" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
        </form>
    </td>
</tr>