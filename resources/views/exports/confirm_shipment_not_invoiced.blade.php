<table class="table table-stripped table-sm">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-nowrap">Shipment Number</th>
            <th class="text-nowrap">Shipment Date</th>
            <th class="text-nowrap">InvtRefNumber</th>
            <th class="text-nowrap">Confirm Date</th>
            <th class="text-nowrap">Invoice Number</th>
            <th class="text-nowrap">Customer Code</th>
            <th class="text-nowrap">Customer Name</th>
            <th class="text-nowrap">Diff Day</th>
        </tr>
    </thead>
    @foreach ($data as $item)
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $item->ShipmentNbr }}</td>
                <td class="text-nowrap">{{ $item->ShipDate }}</td>
                <td class="text-nowrap">{{ $item->InvtRefNbr }}</td>
                <td class="text-nowrap">{{ $item->ConfirmDate }}</td>
                <td class="text-nowrap">{{ $item->InvoiceNbr }}</td>
                <td class="text-nowrap">{{ $item->AcctCD }}</td>
                <td class="text-nowrap">{{ $item->AcctName }}</td>
                <td class="text-nowrap">{{ $item->DiffDay }}</td>
            </tr>
        </tbody>
    @endforeach
</table>