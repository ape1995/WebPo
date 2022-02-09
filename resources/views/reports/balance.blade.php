@extends('layouts.app')

@if (isset($reportName))
    @section('title')
        {{ $reportName }}
    @endsection
@endif

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{ trans('report.title_5') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ trans('menu.report') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('report.title_5') }}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="formReport" action="{{ route('reportSalesOrder.reportBalanceView') }}" method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="order_date">{{ trans('report.customer') }}</label>
                                    </div>
                                    <div class="col-md-5">
                                        @if (isset($customer_id))
                                            <select name="customer_id" id="customer_id" class="form-control select2jsCustom" required>
                                                <option value="">- Choose Customer -</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->AcctCD }}" {{ $customer->AcctCD == $customer_id ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select name="customer_id" id="customer_id" class="form-control select2jsCustom" required>
                                                <option value="">- Choose Customer -</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-8">
                                        <input type="submit" name="view" class="btn btn-primary col-md-2" id="view" value="View">
                                        <input type="submit" name="export" class="btn btn-success col-md-2" id="export" value="Export">
                                        <div id="loading" class="spinner-border"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (isset($prePayments))
                        <div class="card mt-3">
                            <div class="card-header bg-info">
                                Customer Code : {{ $customerCode }}<br>
                                Customer Name : {{ $customerName }}<br>
                                Balance : {{ number_format($balance,2,',','.') }}
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    @foreach ($prePayments as $header)
                                        <table class="table table-stripped table-sm" id="sales-order-table">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th class="text-nowrap">PrePaymentRefNbr</th>
                                                    {{-- <th class="text-nowrap">CustomerCD</th> --}}
                                                    {{-- <th class="text-nowrap">CustomerName</th> --}}
                                                    <th class="text-nowrap">TransferAmount</th>
                                                    <th class="text-nowrap">TransferDate</th>
                                                    {{-- <th class="text-nowrap">FinPeriodID</th> --}}
                                                    <th class="text-nowrap">Descr</th>
                                                    {{-- <th class="text-nowrap">Currency</th> --}}
                                                    <th class="text-nowrap">Total Used</th>
                                                    <th class="text-nowrap">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-light">
                                                    <td class="text-nowrap">{{ $header->PrePaymentRefNbr }}</td>
                                                    {{-- <td class="text-nowrap">{{ $header->CustomerCD }}</td> --}}
                                                    {{-- <td class="text-nowrap">{{ $header->CustomerName }}</td> --}}
                                                    <td class="text-nowrap money">{{ number_format($header->TransferAmount,2,',','.') }}</td>
                                                    <td class="text-nowrap">{{ date('Y-m-d', strtotime($header->TransferDate)) }}</td>
                                                    {{-- <td class="text-nowrap">{{ $header->FinPeriodID }}</td> --}}
                                                    <td class="text-nowrap">{{ $header->Descr }}</td>
                                                    {{-- <td class="text-nowrap">{{ $header->Currency }}</td> --}}
                                                    <td class="text-nowrap">{{ number_format($header->detail->sum('TotalPayment'),2,',','.') }}</td>
                                                    <td class="text-nowrap">{{ number_format($header->TransferAmount - $header->detail->sum('TotalPayment'),2,',','.') }}</td>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th class="text-nowrap">OrderNbr</th>
                                                    <th class="text-nowrap">OrderDate</th>
                                                    <th class="text-nowrap">OrderTotal</th>
                                                    <th class="text-nowrap">AlocationPayment</th>
                                                    <th class="text-nowrap">InvoicePayment</th>
                                                    <th class="text-nowrap">TotalPayment</th>
                                                </tr>
                                                @foreach ($header->detail as $detail)  
                                                    <tr>
                                                        <td class="text-nowrap">{{ $detail->OrderNbr }}</td>
                                                        <td class="text-nowrap">{{ date('Y-m-d', strtotime($detail->OrderDate)) }}</td>
                                                        <td class="text-nowrap money">{{ number_format($detail->OrderTotal,2,',','.') }}</td>
                                                        <td class="text-nowrap money">{{ number_format($detail->AlocationPayment,2,',','.') }}</td>
                                                        <td class="text-nowrap money">{{ number_format($detail->InvoicePayment,2,',','.') }}</td>
                                                        <td class="text-nowrap money">{{ number_format($detail->TotalPayment,2,',','.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('page_scripts')
    <script type="text/javascript">
        $('#loading').hide();
        $(document).on('submit','form#formReport',function(){
            // console.log('test');
            $('#loading').show();
            setTimeout(function() {
                $('#loading').hide();
            }, 60000);
        });
        
        // $('#view').button();
        // $('#view').click(function(){
        //     if($('#customer_id').val() == '' || $('#customer_id').val() == null){
                
        //         // console.log('test');
        //         // $('form#formReport').submit();
        //         return null;
        //     } else {

        //         $('#view').prop("value", "Loading...");
        //         $("#view").prop('disabled', true);
        //         // $('form#formReport').submit();     
        //         /* perform processing then reset button when done */
        //         setTimeout(function() {
        //             $('#view').prop("value", "View");
        //             $("#view").prop('disabled', false);
        //         }, 5000);
        //     }
        // });



        $(".select2jsCustom").select2({
            placeholder: "- Choose Outlet -",
        });
    </script>
@endpush