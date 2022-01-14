<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Role Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="col-md-12">
    {!! Form::label('name', 'Permission:') !!} 
</div>

<div class="col-md-12">
    <h3>Dashboards</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Dashboards</h5></div>
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
    <h3>Data Master</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Users</h5></div>
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
                <div class="card-header bg-danger text-center p-1"><h5>Group Permissions</h5></div>
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
    </div>
    <h3>Transactions</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Sales Order</h5></div>
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
    </div>
    <h3>Reports</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h5>Reports</h5></div>
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