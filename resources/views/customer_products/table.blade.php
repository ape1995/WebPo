<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('customer_product.customer') }}</th>
            <th>{{ trans('customer_product.inventory_code') }}</th>
            <th>{{ trans('customer_product.customer_class') }}</th>
            <th>{{ trans('customer_product.date_add') }}</th>
            <th width="1%">{{ trans('customer_product.action') }}</th>
        </tr>
        </thead>
        <tbody>
        
        </tbody>
    </table>
</div>
{{-- @push('page_scripts')
    <script>
    $(document).ready(function() {
        var table = $('#customerProducts-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });

        $("#customer_id").change(function() { 
            var val = [];
            val.push($('#customer_id').val());
            table.search(val.join(' ')).draw();   
        });
    });

    
    </script>
@endpush --}}