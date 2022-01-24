<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', trans('mail.type')) !!}
    {!! Form::select('type', ['' => '- Choose -','Receiver' => 'Receiver','Sender' => 'Sender'], null, ['class' => 'form-control']) !!}
</div>

<!-- Sub Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sub_type', trans('mail.sub_type')) !!}
    {!! Form::select('sub_type', [], null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', trans('mail.email')) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', trans('user.password')) !!}
    {!! Form::text('password', null, ['class' => 'form-control']) !!}
    <small class="text-info"><i>*Wajib di isi apabila akun sender</i></small>
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', trans('mail.status')) !!}
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" checked>
        <label class="custom-control-label" for="customSwitches">Active</label>
    </div>
</div>

@push('page_scripts')
    <script>
        $(function() {
            var type =  $("#type");

            type.on('change click', function() {
                typevalue = type.val();
                if(typevalue== 'Receiver'){
                    console.log(typevalue);
                    $(function () {
                        $('#sub_type').empty();
                        $('#sub_type').append("<option value='To'>To</option>");
                        $('#sub_type').append("<option value='CC'>CC</option>");
                        $('#sub_type').append("<option value='BCC'>BCC</option>");
                    });
                } else {
                    console.log(typevalue);
                    $(function () {
                        $('#sub_type').empty();
                        $('#sub_type').append("<option value=''>-</option>");
                    });
                }
            });
            

        });
    </script>
@endpush