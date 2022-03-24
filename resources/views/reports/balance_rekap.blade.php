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
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="rekap-balance-table">
                                    <thead>
                                        <tr class="bg-info">
                                            <th class="text-nowrap">Customer Code</th>
                                            <th class="text-nowrap">Customer Name</th>
                                            <th class="text-nowrap">Transfer Amount</th>
                                            <th class="text-nowrap">Payment</th>
                                            <th class="text-nowrap">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customerBalances as $balance) 
                                            <tr class="bg-light">
                                                <td class="text-nowrap">{{ $balance->CustomerCD }}</td>
                                                <td class="text-nowrap">{{ $balance->CustomerName }}</td>
                                                <td class="text-nowrap money">{{ number_format($balance->TransferAmount, 2, '.', ',') }}</td>
                                                <td class="text-nowrap money">{{ number_format($balance->Payment, 2, '.', ',') }}</td>
                                                <td class="text-nowrap money">{{ number_format($balance->Balance, 2, '.', ',') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"> 
@endsection
@push('page_scripts')
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#rekap-balance-table').DataTable({
            columnDefs: [
                { 
                    orderable: false,
                    className: "text-nowrap",
                    targets: "_all" 
                }
            ],
            searching: true,
            
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
            ],
            "paging":   false,
            "ordering": false,
            "info":     false,
        });
    });
    </script>
@endpush