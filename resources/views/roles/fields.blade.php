<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', trans('group.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="col-md-12">
    {!! Form::label('name', trans('group.permission')) !!} 
</div>

<div class="col-md-12">
    <h3>{{ trans('menu.dashboard') }}</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-center p-1"><h4>{{ trans('menu.dashboard') }}</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'dashboards') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>{{ trans('menu.user') }}</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'user') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>{{ trans('menu.group_permission') }}</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'permissions') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Parameter</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'parameter') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Parameter Tax</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'tax') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Mail Setting</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'mail setting') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Adds</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'adds') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Customer Products</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'customer products') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Product Schedulers</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'product schedulers') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Minimum Order</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'min orders') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Category Minimum Order</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'category minimum orders') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Direct Selling Rules</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'direct selling') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Bundling Gimmicks</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'bundling gimmicks') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Bundling Products</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'bundling products') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Bundling Discount</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'bundling discounts') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>{{ trans('menu.sales_order') }}</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'sales order') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>Estimasi</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'estimasi') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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
                <div class="card-header bg-danger text-center p-1"><h4>{{ trans('menu.report') }}</h4></div>
                <div class="card-body py-1 px-3">
                    <table width="100%">
                        @foreach ($permissions as $permission)
                            @php
                                if(stripos($permission->name, 'report') !== FALSE){
                            @endphp
                            <tr>
                                <td width="10%"><input type="checkbox" name="permission[]" id="permission" value="{{ $permission->id }}"></td>
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