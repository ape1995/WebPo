<table class="table table-stripped table-sm">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-nowrap">customer_code</th>
            <th class="text-nowrap">customer_name</th>
            <th class="text-nowrap">start_date</th>
            <th class="text-nowrap">end_date</th>
        </tr>
    </thead>
    @foreach ($dsPercentages as $percentage)
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $percentage->customer_code }}</td>
                <td class="text-nowrap">{{ $percentage->customer->AcctName }}</td>
                <td class="text-nowrap">{{ $percentage->start_date }}</td>
                <td class="text-nowrap">{{ $percentage->end_date }}</td>
            </tr>
        </tbody>
    @endforeach
</table>