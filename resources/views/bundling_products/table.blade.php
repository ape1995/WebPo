<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered" id="bundlingProducts-table">
        <thead>
            <tr class="bg-info">
            <th>{{ trans('bundling_product.start_date') }}</th>
            <th>{{ trans('bundling_product.end_date') }}</th>
            <th>{{ trans('bundling_product.buy') }}</th>
            <th>{{ trans('bundling_product.free_item') }}</th>
            <th>Status</th>
            <th>{{ trans('bundling_product.created_at') }}</th>
            <th>{{ trans('bundling_product.released_at') }}</th>
            <th>{{ trans('bundling_product.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bundlingProducts as $bundlingProduct)
            <tr>
                <td>{{ $bundlingProduct->start_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingProduct->end_date == null ? '' : $bundlingProduct->end_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingProduct->product_code }} - {{ $bundlingProduct->product->Descr }} ( {{ $bundlingProduct->qty }} pcs ) </td>
                <td>
                    <ul>
                        @foreach ($bundlingProduct->detail as $detail)
                        <li>
                            {{ $detail->product_code }} - 
                            {{ $detail->product->Descr }} (
                            {{ $detail->qty }} pcs )
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $bundlingProduct->status }}</td>
                <td>{{ $bundlingProduct->created_at->format('Y-m-d') }}</td>
                <td>{{ $bundlingProduct->released_at == null ? '' : date('Y-m-d', strtotime($bundlingProduct->released_at)) }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['bundlingProducts.destroy', $bundlingProduct->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @if ($bundlingProduct->status == 'Draft')
                            @can('release bundling products')
                            <a href="{{ route('bundlingProducts.release', [$bundlingProduct->id]) }}"
                                class='btn btn-success btn-xs' title="release"  onclick="return confirm('Are You Sure?')">
                                <i class="fa fa-check"></i>
                            </a>
                            @endcan
                            @can('edit bundling products')
                            <a href="{{ route('bundlingProducts.edit', [$bundlingProduct->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete bundling products')
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endcan
                        @endif
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
        $('#bundlingProducts-table').DataTable({
            order: [[0, 'desc']],
        });
    });
    </script>
@endpush