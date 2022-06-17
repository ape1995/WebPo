<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr class="bg-info">
                            <th>Inventory Code</th>
                            <th>Inventory Name</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total Amount</th>
                            <th>Discount Percentage</th>
                            <th>Discount Amount</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packetDiscount->detail as $detail)
                            <tr>
                                <td>{{ $detail->inventory_code }}</td>
                                <td>{{ $detail->inventory_name }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td class="text-right">{{ number_format($detail->unit_price,2) }}</td>
                                <td class="text-right">{{ number_format($detail->total_amount,2) }}</td>
                                <td class="text-right">{{ number_format($detail->discount_percentage, 2) }}</td>
                                <td class="text-right">{{ number_format($detail->discount_amount,2) }}</td>
                                <td class="text-right">{{ number_format($detail->amount,2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="bg-light" colspan="4"><b>Total</b></td>
                            <td class="text-right"><b>{{ number_format($packetDiscount->total,2) }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light" colspan="4"><b>Discount</b></td>
                            <td class="text-right"><b>{{ number_format($packetDiscount->discount,2) }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light" colspan="4"><b>Grand Total</b></td>
                            <td class="text-right"><b>{{ number_format($packetDiscount->grand_total,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>