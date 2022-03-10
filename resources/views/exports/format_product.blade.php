<table class="table table-stripped table-sm">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-nowrap">kode_produk</th>
            <th class="text-nowrap">nama_produk</th>
            <th class="text-nowrap">quantity</th>
        </tr>
    </thead>
    @foreach ($products as $product)
        <tbody>
            <tr style="background-color: lightgrey">
                <td class="text-nowrap">{{ $product->inventory_code }}</td>
                <td class="text-nowrap">{{ $product->product->Descr }}</td>
                <td class="text-nowrap">0</td>
            </tr>
        </tbody>
    @endforeach
</table>