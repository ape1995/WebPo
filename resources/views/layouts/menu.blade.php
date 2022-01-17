<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li>

@if(Gate::check('browse users') || Gate::check('browse group permissions'))
<li class="nav-item {{ Request::is('users*') ? 'menu-open' : '' }} {{ Request::is('roles*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('users*') ? 'active' : '' }} {{ Request::is('roles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
        Data Master
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('browse users')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                </a>
            </li>
        @endcan
        @can('browse group permissions')
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Group Permissions</p>
                </a>
            </li>
        @endcan
    </ul>
</li>
@endif

{{-- <li class="nav-item">
    <a href="{{ route('testImports.index') }}"
       class="nav-link {{ Request::is('testImports*') ? 'active' : '' }}">
        <p>Test Imports</p>
    </a>
</li> --}}
@if(Gate::check('list sales order') || Gate::check('create sales order'))
<li class="nav-item {{ Request::is('salesOrders*') ? 'menu-open' : '' }} {{ Request::is('createOrder*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('salesOrders*') ? 'active' : '' }} {{ Request::is('createOrder*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-dollar-sign"></i>
        <p>
        Sales Order
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('create sales order')
            <li class="nav-item">
                <a href="{{ route('createOrder') }}" class="nav-link {{ Request::is('createOrder*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Order</p>
                </a>
            </li>
        @endcan
        @can('list sales order')
            <li class="nav-item">
                <a href="{{ route('salesOrders.index') }}" class="nav-link {{ Request::is('salesOrders*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>List Order</p>
                </a>
            </li>
        @endcan
    </ul>
</li>
@endif

@if(Gate::check('view report sales order') || Gate::check('view report sales order detail') || Gate::check('view report request 1'))
<li class="nav-item {{ Request::is('reportSalesOrder*') ? 'menu-open' : '' }} {{ Request::is('reportRequest1*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('reportSalesOrder*') ? 'active' : '' }}  {{ Request::is('reportRequest1*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>
            Report
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('view report sales order')
            <li class="nav-item">
                <a href="{{ route('reportSalesOrder.index') }}" class="nav-link {{ Request::is('reportSalesOrder') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sales Order Rekap</p>
                </a>
            </li>
        @endcan
        @can('view report sales order detail')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.detailIndex') }}" class="nav-link {{ Request::is('reportSalesOrderDetail') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sales Order Detail</p>
            </a>
        </li>
        @endcan
        @can('view report request 1')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.report1Index') }}" class="nav-link {{ Request::is('reportRequest1') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Report Request 1</p>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endif

