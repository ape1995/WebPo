<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead>
        <tr class="bg-info">
            <th>Customer</th>
            <th>Inventory Code</th>
            <th>Customer Class</th>
            <th>Date Add</th>
            <th width="1%">Action</th>
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