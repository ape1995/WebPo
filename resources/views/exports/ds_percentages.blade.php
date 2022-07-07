<table class="table table-stripped table-sm">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-nowrap">customer_code</th>
            <th class="text-nowrap">customer_name</th>
            <th class="text-nowrap">start_date</th>
            <th class="text-nowrap">end_date</th>
            <th class="text-nowrap">percentage</th>
        </tr>
    </thead>
    @foreach ($dsPercentages as $percentage)
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $percentage->customer_code }}</td>
                <td class="text-nowrap">{{ $percentage->customer->AcctName }}</td>
                <td class="text-nowrap">{{ $percentage->start_date->format('Y-m-d') }}</td>
                <td class="text-nowrap">{{ $percentage->end_date == null ? '' : $percentage->end_date->format('Y-m-d    ') }}</td>
                <td class="text-nowrap">{{ $percentage->percentage }} %</td>
            </tr>
        </tbody>
    @endforeach
</table>