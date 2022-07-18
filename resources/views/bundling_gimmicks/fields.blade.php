<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    @if (isset($bundlingGimmick))
        {!! Form::date('start_date', $bundlingGimmick->start_date, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
    @else
        {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
    @endif
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    @if (isset($bundlingGimmick))
        {!! Form::date('end_date', $bundlingGimmick->end_date, ['class' => 'form-control','id'=>'end_date']) !!}
    @else
        {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
    @endif
</div>

<!-- Package Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('package_type', 'Package Type:') !!}
    {!! Form::text('package_type', "Bundling Gimmick", ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Nominal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nominal', 'Nominal:') !!}
    {!! Form::text('nominal', null, ['class' => 'form-control', 'required' => true, 'onkeydown' => "if(event.key==='.'){event.preventDefault()}", 'oninput'=>"event.target.value = event.target.value.replace(/[^0-9]*/g,'')" ]) !!}
</div>

<!-- Free Qty Field -->
<div class="form-group col-sm-6">
    {!! Form::label('free_qty', 'Free Qty:') !!}
    {!! Form::number('free_qty', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Free Descr Field -->
<div class="form-group col-sm-6">
    {!! Form::label('free_descr', 'Free Descr:') !!}
    {!! Form::text('free_descr', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

@push('page_scripts')
    <script>
        $(function() {
            $('#nominal').on('change, click', function() {
                let amount = $("#nominal").val().replace('.','').replace(',','');
                $("#nominal").val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(amount));
            });
        });
    </script>
@endpush