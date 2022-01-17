<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead>
        <tr>
            <th></th>
            <th>Order Type</th>
            <th>Order Nbr</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Order Qty</th>
            <th @can('hide price sales order') class="hide-component" @endcan>Order Amount</th>
            <th @can('hide price sales order') class="hide-component" @endcan>Tax</th>
            <th @can('hide price sales order') class="hide-component" @endcan>Order Total</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
