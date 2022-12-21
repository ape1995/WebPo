<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', trans('parameter.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
</div>
{{-- 
<!-- Parameter String Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parameter_string', 'Parameter String:') !!}
    {!! Form::text('parameter_string', null, ['class' => 'form-control']) !!}
</div>

<!-- Parameter Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parameter_date', 'Parameter Date:') !!}
    {!! Form::text('parameter_date', null, ['class' => 'form-control','id'=>'parameter_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#parameter_date').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush --}}

<!-- Parameter Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parameter_hour', trans('parameter.parameter_hour')) !!}
    {!! Form::time('parameter_hour', null, ['class' => 'form-control','id'=>'parameter_hour']) !!}
</div>
{{-- 
@push('page_scripts')
    <script type="text/javascript">
        $(function(){
            $('#parameter_hour').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                startTime: '00:00 AM',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                showInputs: false,
            })
        });
    </script>
@endpush --}}

{{-- <!-- Parameter Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parameter_number', 'Parameter Number:') !!}
    {!! Form::number('parameter_number', null, ['class' => 'form-control']) !!}
</div> --}}