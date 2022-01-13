<div class="table-responsive mt-3">
    <table class="table table-sm" id="salesOrderDetails-table">
        <thead>
        <tr>
            <th>Inventory Id</th>
            <th>Inventory Name</th>
            <th>Qty</th>
            <th>Uom</th>
            <th>Unit Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($salesOrderDetails as $salesOrderDetail)
            <tr>
                <td>{{ $salesOrderDetail->inventory_id }}</td>
                <td>{{ $salesOrderDetail->inventory_name }}</td>
                <td>{{ $salesOrderDetail->qty }}</td>
                <td>{{ $salesOrderDetail->uom }}</td>
                <td>{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                <td>{{ number_format($salesOrderDetail->amount,2,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
