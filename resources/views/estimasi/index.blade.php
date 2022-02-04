@extends('layouts.app')

@section('css')
  <style>
    div.first {
      /*setting alpha = 0.1*/
      background: rgba(0, 0, 0, 0.2);
    }
  </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Estimasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Estimasi</a></li>
                <li class="breadcrumb-item active">Index</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-5">
                  <label for="customer">Customer</label>
                  <select name="customer" id="customer" class="form-control select2jsCustom1" required>
                      <option value="">- Choose Customer -</option>
                      @foreach ($customers as $customer)
                          <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="outlet">Outlet</label>
                  <select name="outlet" id="outlet" class="form-control select2jsCustom2" placeholder="tes" required>
                  </select>
                </div>
                <div class="col-md-3">
                  <label for="date">Date</label>
                  <input type="date" name="date" id="date" class="form-control" required>
                </div>
              </div>
              {{-- Table --}}
              <div class="table-responsive mt-3">
                <table class="table table-hover table-sm" id="dataTable">
                  <thead>
                    <tr>
                      <th>Shipped Date</th>
                      <th>Order Type</th>
                      <th>Order Number</th>
                      <th>Product Name</th>
                      <th>Order Qty</th>
                      <th>Adjustment</th>
                      <th>After Adjustment</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection


@push('page_scripts')
<script type="text/javascript">

  $(".select2jsCustom1").select2({
      placeholder: "- Choose Customer -",
  });

  $(".select2jsCustom2").select2({
      placeholder: "- Choose Outlet -",
  });

  $(document).ready(function() { 
      var customer =  $("select#customer");
      var outlet =  $("select#outlet");
      var date =  $("#date");
      date.prop("disabled", true);
      outlet.prop("disabled", true);
      var table = null;

      customer.on('change', function() {

        outlet.select2("val", "");;
        date.val('');
        date.prop("disabled", true);
        outlet.prop("disabled", true);

        var url = "{{ url('api/get-outlet-data') }}" + '/' + customer.val();
        $.ajax({
            url: url,
            method: 'get',
            dataType: 'json',
            success: function(response) {
              outlet.html(response);
              outlet.prop("disabled", false);
            }
        });


      });

      outlet.on('change', function() {
          if(outlet.val() == null || outlet.val() == ''){
            date.prop("disabled", true);
          } else {
            date.prop("disabled", false);
          }
      });

      date.on('change', function() {
        if(date.val() == null || date.val() == ''){
          console.log('waiting');
        } else {
          console.log(date.val());
          fetch_data();
        }
      });

      // fetch_data();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      function fetch_data(){   
        if(table == null){
          // ASSIGN DATATABLE
          table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            paging:   false,
            ordering: false,
            info:     false,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
            },
            rowCallback: function( row, data ) {
                $('td:eq(4)', row).addClass("money");
                $('td:eq(5)', row).addClass("money");
                $('td:eq(6)', row).addClass("money");
                $('td:eq(7)', row).addClass("money");
            },
            ajax: {
                url:"{{route('estimasi.data')}}",
                type: "post",
                data:{
                  customer:function() { return $('#customer').val() }, 
                  outlet:function() { return $('#outlet').val() }, 
                  date:function() { return $('#date').val() },
                },
                    
            },
            columns: [
                {
                    data: 'ShippedDate'                                    
                }, 
                {
                    data: 'OrderType'                                    
                }, 
                {
                    data: 'OrderNbr'                                    
                }, 
                {
                    data: 'InventoryID'                                    
                }, 
                {
                    data: 'OrderQty'                                    
                }, 
                {
                    data: 'OrderQty'                                    
                }, 
                {
                    data: 'ShippedQty'                                    
                }, 
              ]
            });
        } else {
          // DRAW TABLE
          table.draw();
        }                 
      }         
  });
</script>
@endpush  