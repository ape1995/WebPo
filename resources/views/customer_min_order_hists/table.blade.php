<div class="table-responsive">
    <table class="table table-hover table-sm" id="customerMinOrderHists-table">
        <thead>
        <tr>
            <th>Customer Code</th>
            <th>Old Price</th>
            <th>New Price</th>
            <th>Date Add</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerMinOrderHists as $customerMinOrderHist)
            <tr>
                <td>{{ $customerMinOrderHist->customer_code }}</td>
                <td class="text-bold">Rp. {{ number_format($customerMinOrderHist->old_price,0,',','.') }}</td>
                <td class="text-bold">Rp. {{ number_format($customerMinOrderHist->new_price,0,',','.') }}</td>
                <td>{{ $customerMinOrderHist->created_at->format('Y-m-d') }}</td>
                {{-- <td width="120">
                    {!! Form::open(['route' => ['customerMinOrderHists.destroy', $customerMinOrderHist->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerMinOrderHists.show', [$customerMinOrderHist->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerMinOrderHists.edit', [$customerMinOrderHist->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
