<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', trans('group.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<div class="col-md-12">
    {!! Form::label('name', trans('group.permission')) !!} 
</div>

<div class="col-md-12">
    <h3>{{ trans('menu.dashboard') }}</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>{{ trans('menu.dashboard') }}</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'dashboards') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <h3>{{ trans('menu.master') }}</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>{{ trans('menu.user') }}</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'user') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>{{ trans('menu.group_permission') }}</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'group permissions') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Parameter</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'parameter') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Parameter Tax</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'tax') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Mail Setting</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'mail setting') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Adds</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'adds') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Customer Products</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'customer products') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Minimum Order</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'min orders') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <h3>Transactions</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>{{ trans('menu.sales_order') }}</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'sales order') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Estimasi</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'estimasi') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <h3>{{ trans('menu.report') }}</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>{{ trans('menu.report') }}</h5></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if($role->hasPermissionTo($permission->name)){
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            @php
                                if(stripos($permission->name, 'report') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}" {{ $checked }}></td>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            @php
                                }
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <hr>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('roles.index') }}" class="btn btn-default">Cancel</a>
</div>