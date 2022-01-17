<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead>
        <tr>
            <th>No</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Uom</th>
            <th @can('hide price sales order') class="hide-component" @endcan>Unit Price</th>
            <th @can('hide price sales order') class="hide-component" @endcan>Amount</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>