<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', trans('customer_product.customer_code')) !!}
    <select name="customer_code" id="customer_code" class="form-control select2js" required>
        <option value="">- Choose Customer -</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
        @endforeach
    </select>
    {{-- {!! Form::text('customer_code', null, ['class' => 'form-control']) !!} --}}
</div>

<!-- Inventory Code Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('inventory_code', 'Inventory Code:') !!}
    <select name="inventory_code" id="inventory_code" class="form-control select2js" required>
        <option value="">- Choose Product -</option>
        @foreach ($products as $product)
            <option value="{{ $product->InventoryCD }}">{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
        @endforeach
    </select>
</div> --}}

<div class="table-responsive p-3">
    <table class="table table-hover table-sm table-bordered" id="table-products">
        <thead class="bg-info">
            <tr>
                <td width="3%">
                    <input type="checkbox" id='checkall' />
                </td>
                <td>Product Code</td>
                <td>Product Name</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><input class="checkbox" type="checkbox" name="check[]" id="check[]" value="{{ $product->InventoryCD }}"></td>
                    <td>{{ $product->InventoryCD }}</td>
                    <td>{{ $product->Descr }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('page_scripts')
    <script>
    $(document).ready(function() {
        var table = $('#table-products').DataTable({
            columnDefs: [
                { orderable: false, targets: 0 }
            ],
        });
    });
    </script>
@endpush