<!-- Start Date Field -->
<div class="col-sm-4">
    {!! Form::label('start_date', trans('bundling_product.start_date')) !!}
    <input type="text" class="form-control" value="{{ $bundlingProduct->start_date->format('Y-m-d') }}" disabled>
</div>

<!-- End Date Field -->
<div class="col-sm-4">
    {!! Form::label('end_date', trans('bundling_product.end_date')) !!}
    <input type="text" class="form-control" value="{{ $bundlingProduct->end_date == null ? '' : $bundlingProduct->end_date->format('Y-m-d') }}" disabled>
</div>
<div class="col-md-12">
    <hr>
    <h4>Buy</h4>
</div>
<!-- Product Code Field -->
<div class="col-sm-6">
    {!! Form::label('product_code', 'Product:') !!}
    <input type="text" class="form-control" value="{{ $bundlingProduct->product_code }} - {{ $bundlingProduct->product->Descr }}" disabled>
</div>

<!-- Qty Field -->
<div class="col-sm-1">
    {!! Form::label('qty', 'Qty:') !!}
    <input type="text" class="form-control" value="{{ $bundlingProduct->qty }} Pcs" disabled>
</div>

<div class="col-md-12">
    <hr>
    <h4>{{ trans('bundling_product.free_item') }}</h4>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm">
            <thead>
                <tr class="bg-info">
                    <th>Product</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bundlingProduct->detail as $free)
                    <tr>
                        <td>{{ $free->product_code }} - {{ $free->product->Descr }}</td>
                        <td>{{ $free->qty }} Pcs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

