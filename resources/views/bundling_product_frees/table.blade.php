<div class="table-responsive">
    <table class="table" id="bundlingProductFrees-table">
        <thead>
        <tr>
            <th>Bundling Product Id</th>
        <th>Product Code</th>
        <th>Qty</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bundlingProductFrees as $bundlingProductFree)
            <tr>
                <td>{{ $bundlingProductFree->bundling_product_id }}</td>
            <td>{{ $bundlingProductFree->product_code }}</td>
            <td>{{ $bundlingProductFree->qty }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['bundlingProductFrees.destroy', $bundlingProductFree->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bundlingProductFrees.show', [$bundlingProductFree->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('bundlingProductFrees.edit', [$bundlingProductFree->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
