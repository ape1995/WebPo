<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        {{ trans('menu.dashboard')}}
    </a>
</li>

@if(Gate::check('browse users') || Gate::check('browse permissions') || Gate::check('browse group permissions') || Gate::check('browse parameter')  || Gate::check('browse adds')  || Gate::check('browse tax')  || Gate::check('browse customer products')  || Gate::check('browse min orders') || Gate::check('browse category minimum orders'))
<li class="nav-item {{ Request::is('users*') ? 'menu-open' : '' }} {{ Request::is('permissions*') ? 'menu-open' : '' }} {{ Request::is('roles*') ? 'menu-open' : '' }} {{ Request::is('parameters*') ? 'menu-open' : '' }} {{ Request::is('parameterVATs*') ? 'menu-open' : '' }} {{ Request::is('mailSettings*') ? 'menu-open' : '' }}  {{ Request::is('adds*') ? 'menu-open' : '' }} {{ Request::is('customerProducts*') ? 'menu-open' : '' }} {{ Request::is('customerMinOrders*') ? 'menu-open' : '' }} {{ Request::is('categoryMinOrders*') ? 'menu-open' : '' }} {{ Request::is('dsRules*') ? 'menu-open' : '' }} {{ Request::is('packetDiscounts*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('users*') ? 'active' : '' }} {{ Request::is('permissions*') ? 'active' : '' }} {{ Request::is('roles*') ? 'active' : '' }} {{ Request::is('parameters*') ? 'active' : '' }} {{ Request::is('parameterVATs*') ? 'active' : '' }} {{ Request::is('mailSettings*') ? 'active' : '' }}  {{ Request::is('adds*') ? 'active' : '' }} {{ Request::is('customerProducts*') ? 'active' : '' }} {{ Request::is('customerMinOrders*') ? 'active' : '' }} {{ Request::is('categoryMinOrders*') ? 'active' : '' }} {{ Request::is('dsRules*') ? 'active' : '' }} {{ Request::is('packetDiscounts*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
        {{ trans('menu.master')}}
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('browse users')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                    <i class="fa fa-users nav-icon"></i>
                    <p>{{ trans('menu.user')}}</p>
                </a>
            </li>
        @endcan
        @can('browse permissions')
            <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                    <i class="fa fa-paste nav-icon"></i>
                    <p>Permissions</p>
                </a>
            </li>
        @endcan
        @can('browse group permissions')
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                    <i class="fa fa-paste nav-icon"></i>
                    <p>{{ trans('menu.group_permission')}}</p>
                </a>
            </li>
        @endcan
        @can('browse parameter')
        <li class="nav-item">
            <a href="{{ route('parameters.index') }}" class="nav-link {{ Request::is('parameters*') ? 'active' : '' }}">
                <i class="fa fa-clock nav-icon"></i>
                <p>Parameter</p>
            </a>
        </li>
        @endcan
        @can('browse tax')
        <li class="nav-item">
            <a href="{{ route('parameterVATs.index') }}" class="nav-link {{ Request::is('parameterVATs*') ? 'active' : '' }}">
                <i class="fas fa-money-check-alt nav-icon"></i>
                <p>Parameter {{ trans('menu.vat') }}</p>
            </a>
        </li>
        @endcan
        @can('browse mail setting')
        <li class="nav-item">
            <a href="{{ route('mailSettings.index') }}" class="nav-link {{ Request::is('mailSettings*') ? 'active' : '' }}">
                <i class="fas fa-mail-bulk nav-icon"></i>
                <p>{{ trans('menu.mail_setting') }}</p>
            </a>
        </li>
        @endcan
        @can('browse adds')
        <li class="nav-item">
            <a href="{{ route('adds.index') }}" class="nav-link {{ Request::is('adds*') ? 'active' : '' }}">
                <i class="fas fa-tv nav-icon"></i>
                <p>{{ trans('menu.adds') }}</p>
            </a>
        </li>
        @endcan
        @can('browse customer products')
        <li class="nav-item">
            <a href="{{ route('customerProducts.index') }}" class="nav-link {{ Request::is('customerProducts*') ? 'active' : '' }}">
                <i class="fab fa-product-hunt nav-icon"></i>
                <p>Customer Products</p>
            </a>
        </li>
        @endcan
        @can('browse min orders')
        <li class="nav-item">
            <a href="{{ route('customerMinOrders.index') }}" class="nav-link {{ Request::is('customerMinOrders*') ? 'active' : '' }}">
                <i class="fas fa-minus-circle nav-icon"></i>
                <p>Customer Min Orders</p>
            </a>
        </li>
        @endcan
        @can('browse category minimum orders')
        <li class="nav-item">
            <a href="{{ route('categoryMinOrders.index') }}" class="nav-link {{ Request::is('categoryMinOrders*') ? 'active' : '' }}">
                <i class="fas fa-minus-circle nav-icon"></i>
                <p>Category Min Orders</p>
            </a>
        </li>
        @endcan
        @can('setting direct selling rules')
        <li class="nav-item">
            <a href="{{ route('dsRules.index') }}" class="nav-link {{ Request::is('dsRules*') ? 'active' : '' }}">
                <i class="fas fa-paste nav-icon"></i>
                <p>Ds Rules</p>
            </a>
        </li>
        @endcan
        @can('browse packet discounts')
        <li class="nav-item">
            <a href="{{ route('packetDiscounts.index') }}" class="nav-link {{ Request::is('packetDiscounts*') ? 'active' : '' }}">
                <i class="fa fa-percentage nav-icon"></i>
                <p>Packet Discounts</p>
            </a>
        </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('dFormImportProduct') }}" class="nav-link {{ Request::is('dFormImportProduct*') ? 'active' : '' }}">
                <i class="far fa-file-excel nav-icon"></i>
                <p>{{ trans('menu.dformatimport') }}</p>
            </a>
        </li>
    </ul>
</li>
@endif

@if(Gate::check('list sales order') || Gate::check('create sales order'))
<li class="nav-item {{ Request::is('salesOrders*') ? 'menu-open' : '' }} {{ Request::is('createOrder*') ? 'menu-open' : '' }} {{ Request::is('salesOrderBulkSubmit*') ? 'menu-open' : '' }} {{ Request::is('salesOrderPromos*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('salesOrders*') ? 'active' : '' }} {{ Request::is('createOrder*') ? 'active' : '' }} {{ Request::is('salesOrderBulkSubmit*') ? 'active' : '' }} {{ Request::is('salesOrderPromos*') ? 'active' : '' }}" >
        <i class="nav-icon fas fa-dollar-sign"></i>
        <p>
        {{ trans('menu.sales_order')}}
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('create sales order')
            <li class="nav-item">
                <a href="{{ route('createOrder') }}" class="nav-link {{ Request::is('createOrder*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical nav-icon"></i>
                    <p>{{ trans('menu.create_order')}}</p>
                </a>
            </li>
        @endcan
        @can('list sales order')
            <li class="nav-item">
                <a href="{{ route('salesOrders.index') }}" class="nav-link {{ Request::is('salesOrders*') ? 'active' : '' }}">
                    <i class="far fa-list-alt nav-icon"></i>
                    <p>{{ trans('menu.list_order')}}</p>
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a href="{{ route('salesOrderPromos.index') }}" class="nav-link {{ Request::is('salesOrderPromos*') ? 'active' : '' }}">
                <i class="far fa-list-alt nav-icon"></i>
                <p>List Order Promo</p>
            </a>
        </li>
        @can('bulk submit sales order')
            <li class="nav-item">
                <a href="{{ route('salesOrders.bulkSubmitIndex') }}" class="nav-link {{ Request::is('salesOrderBulkSubmit*') ? 'active' : '' }}">
                    <i class="fa fa-upload nav-icon"></i>
                    <p>{{ trans('menu.bulk_submit')}}</p>
                </a>
            </li>
        @endcan
        @can('merge sales order')
            <li class="nav-item">
                <a href="{{ route('salesOrders.mergeIndex') }}" class="nav-link {{ Request::is('salesOrderMerge*') ? 'active' : '' }}">
                    <i class="fa fa-upload nav-icon"></i>
                    <p>{{ trans('menu.merge_order')}}</p>
                </a>
            </li>
        @endcan
    </ul>
</li>
@endif

@if(Gate::check('view report sales order') || Gate::check('view report sales order detail') || Gate::check('view report request 1') || Gate::check('view report customer')  || Gate::check('view report balance') || Gate::check('view report balance rekap'))
<li class="nav-item {{ Request::is('reportSalesOrder*') ? 'menu-open' : '' }} {{ Request::is('reportRequest1*') ? 'menu-open' : '' }} {{ Request::is('reportCustomer*') ? 'menu-open' : '' }} {{ Request::is('reportBalance*') ? 'menu-open' : '' }} {{ Request::is('rekapBalances*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('reportSalesOrder*') ? 'active' : '' }}  {{ Request::is('reportRequest1*') ? 'active' : '' }}  {{ Request::is('reportCustomer*') ? 'active' : '' }} {{ Request::is('reportBalance*') ? 'active' : '' }} {{ Request::is('rekapBalances*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>
            {{ trans('menu.report')}}
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @can('view report sales order')
            <li class="nav-item">
                <a href="{{ route('reportSalesOrder.index') }}" class="nav-link {{ Request::is('reportSalesOrder') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check nav-icon"></i>
                    <p>{{ trans('menu.report_rekap')}}</p>
                </a>
            </li>
        @endcan
        @can('view report sales order detail')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.detailIndex') }}" class="nav-link {{ Request::is('reportSalesOrderDetail') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>{{ trans('menu.report_detail')}}</p>
            </a>
        </li>
        @endcan
        @can('view report request 1')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.report1Index') }}" class="nav-link {{ Request::is('reportRequest1') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>{{ trans('menu.report_1')}}</p>
            </a>
        </li>
        @endcan
        @can('view report customer')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.reportCustomerIndex') }}" class="nav-link {{ Request::is('reportCustomer') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>{{ trans('menu.report_customer')}}</p>
            </a>
        </li>
        @endcan
        @can('view report balance rekap')
        <li class="nav-item">
            <a href="{{ route('rekapBalances') }}" class="nav-link {{ Request::is('rekapBalances') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>{{ trans('menu.report_balance_rekap')}}</p>
            </a>
        </li>
        @endcan
        @can('view report balance')
        <li class="nav-item">
            <a href="{{ route('reportSalesOrder.reportBalanceIndex') }}" class="nav-link {{ Request::is('reportBalance') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>{{ trans('menu.report_balance')}}</p>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endif

@can('browse estimasi')
<li class="nav-item">
    <a href="{{ route('estimasi.index') }}" class="nav-link {{ Request::is('estimasi*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        Estimasi
    </a>
</li>
@endcan
