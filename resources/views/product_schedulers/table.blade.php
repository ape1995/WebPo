<div class="table-responsive">
    <table class="table table-bordered table-sm table-hover" id="productSchedulers-table">
        <thead>
        <tr class="bg-info">
            <th>Date</th>
            <th>Inventory Code</th>
            <th>Inventory Name</th>
            <th>Customer Class</th>
            <th>Action Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productSchedulers as $productScheduler)
            <tr>
                <td>{{ $productScheduler->date->format('Y-m-d') }}</td>
                <td>{{ $productScheduler->inventory_code }}</td>
                <td>{{ $productScheduler->product->Descr }}</td>
                <td>{{ $productScheduler->customer_class }}</td>
                <td>{{ $productScheduler->action_type }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['productSchedulers.destroy', $productScheduler->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view product schedulers')
                        <a href="{{ route('productSchedulers.show', [$productScheduler->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit product schedulers')
                        <a href="{{ route('productSchedulers.edit', [$productScheduler->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete product schedulers')
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endcan
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@push('page_scripts')
    <script>
    $(document).ready(function() {
        $('#productSchedulers-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });
    });
    </script>
@endpush