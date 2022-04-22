<table class="table table-stripped table-sm">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-nowrap">nama</th>
            <th class="text-nowrap">email</th>
            <th class="text-nowrap">customer_code</th>
            <th class="text-nowrap">customer_name</th>
            <th class="text-nowrap">status</th>
            <th class="text-nowrap">group access</th>
        </tr>
    </thead>
    @foreach ($users as $user)
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $user->name }}</td>
                <td class="text-nowrap">{{ $user->email }}</td>
                <td class="text-nowrap">{{ $user->customer->AcctCD }}</td>
                <td class="text-nowrap">{{ $user->customer->AcctName }}</td>
                <td class="text-nowrap">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                <td class="text-nowrap">{{ $user->role }}</td>
            </tr>
        </tbody>
    @endforeach
</table>