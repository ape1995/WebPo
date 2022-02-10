<table class="table table-stripped table-sm" id="sales-order-table">
    <tr>
        <th>Customer Code : </th>
        <th colspan="2">{{ $customerCode }}</th>
    </tr>
    <tr>
        <th>Customer Name : </th>
        <th colspan="2">{{ $customerName }}</th>
    </tr>
    <tr>
        <th>Balance : </th>
        <th colspan="2">{{ number_format($balance,2,'.','') }}</th>
    </tr>
    <tr></tr>
    @foreach ($prePayments as $header)
        <thead>
            <tr style="background-color: cadetblue">
                <th class="text-nowrap">PrePaymentRefNbr</th>
                {{-- <th class="text-nowrap">CustomerCD</th> --}}
                {{-- <th class="text-nowrap">CustomerName</th> --}}
                <th class="text-nowrap">TransferAmount</th>
                <th class="text-nowrap">TransferDate</th>
                {{-- <th class="text-nowrap">FinPeriodID</th> --}}
                <th class="text-nowrap">Descr</th>
                {{-- <th class="text-nowrap">Currency</th> --}}
                <th class="text-nowrap">Total Used</th>
                <th class="text-nowrap">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $header->PrePaymentRefNbr }}</td>
                {{-- <td class="text-nowrap">{{ $header->CustomerCD }}</td> --}}
                {{-- <td class="text-nowrap">{{ $header->CustomerName }}</td> --}}
                <td class="text-nowrap money">{{ number_format($header->TransferAmount,2,'.','') }}</td>
                <td class="text-nowrap">{{ date('Y-m-d', strtotime($header->TransferDate)) }}</td>
                {{-- <td class="text-nowrap">{{ $header->FinPeriodID }}</td> --}}
                <td class="text-nowrap">{{ $header->Descr }}</td>
                {{-- <td class="text-nowrap">{{ $header->Currency }}</td> --}}
                <td class="text-nowrap money">{{ number_format($header->detail->sum('TotalPayment'),2,'.','') }}</td>
                <td class="text-nowrap money">{{ number_format($header->TransferAmount - $header->detail->sum('TotalPayment'),2,'.','') }}</td>
            </tr>
            <tr style="background-color: yellow">
                <th class="text-nowrap">OrderNbr</th>
                <th class="text-nowrap">OrderDate</th>
                <th class="text-nowrap">OrderTotal</th>
                <th class="text-nowrap">AlocationPayment</th>
                <th class="text-nowrap">InvoicePayment</th>
                <th class="text-nowrap">TotalPayment</th>
            </tr>
            @foreach ($header->detail as $detail)  
                <tr  style="background-color: white">
                    <td class="text-nowrap">{{ $detail->OrderNbr }}</td>
                    <td class="text-nowrap">{{ date('Y-m-d', strtotime($detail->OrderDate)) }}</td>
                    <td class="text-nowrap money">{{ number_format($detail->OrderTotal,2,'.','') }}</td>
                    <td class="text-nowrap money">{{ number_format($detail->AlocationPayment,2,'.','') }}</td>
                    <td class="text-nowrap money">{{ number_format($detail->InvoicePayment,2,'.','') }}</td>
                    <td class="text-nowrap money">{{ number_format($detail->TotalPayment,2,'.','') }}</td>
                </tr>
            @endforeach
            <tr></tr>
        </tbody>
    @endforeach
</table>