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
              <h1 class="m-0">{{ trans('dashboard.title')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                          <div class="text-right card-body p-2 rounded">
                            {{ trans('dashboard.language')}}
                            <a href="/lang/en">
                              <img src="{{ asset('assets/images/flag-en.png') }}" class="img-rounded text-right mx-1" width="25px">
                            </a>
                            <a href="/lang/id">
                              <img src="{{ asset('assets/images/flag-id.png') }}" class="img-rounded text-right mx-1" width="25px">
                            </a>
                          </div>
                            <div class="row">
                              <div class="col-md-6">
                                <h4 style="margin-bottom: 5px; margin-top: 5px;">{{ $greeting.', '.Auth::user()->name }}</h4>
                                <p>It's {{ $date }}</p>
                              </div>
                              @if (Auth::user()->role == 'Customers' || Auth::user()->role == 'Staff Customers')
                              <div class="col-md-3">
                                <h5>{{ trans('dashboard.question')}}</h5>
                                <a href="{{ route('createOrder') }}" class="btn btn-outline-info btn-block">{{ trans('dashboard.btn_order_here') }}</a>
                              </div>
                              @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">
                                <div id="demo" class="carousel slide" data-ride="carousel">

                                  <!-- Indicators -->
                                  <ul class="carousel-indicators">
                                    @foreach ($adds as $index => $add)
                                      <li data-target="#demo" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" style="border-radius: 50%; width: 12px; height: 12px;"></li>
                                    @endforeach
                                  </ul>
                                  
                                  <!-- The slideshow -->
                                  <div class="carousel-inner mb-3">
                                    @foreach ($adds as $index => $add)
                                      <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('uploads/adds/'.$add->image) }}" alt="{{ $add->name }}" width="100%" height="100%">
                                        <div class="carousel-caption d-none d-md-block first rounded-lg">
                                          <h5>{{ $add->name }}</h5>
                                          <p>{{ $add->description }}</p>
                                        </div>
                                      </div>
                                    @endforeach
                                  </div>
                                  
                                  <!-- Left and right controls -->
                                  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                  </a>
                                  <a class="carousel-control-next" href="#demo" data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                  </a>
                                </div>
                              </div>
                              <div class="col-md-8">
                                <!-- /.row -->
                                @if (Auth::user()->role == 'Customers' || Auth::user()->role == 'Staff Customers')
                                  <div class="row">
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=S&sort=id,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-secondary text-light">
                                            {{ trans('dashboard.draft_order')}}
                                            <h1 class="text-right">{{ $draftOrder }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=R&sort=id,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-info">
                                            {{ trans('dashboard.submitted_order')}}
                                            <h1 class="text-right">{{ $submittedOrder }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=P&sort=created_at,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-success">
                                            {{ trans('dashboard.processed_order')}}
                                            <h1 class="text-right">{{ $processedOrder }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=B&sort=created_at,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-danger">
                                            {{ trans('dashboard.rejected_order')}}
                                            <h1 class="text-right">{{ $rejectedOrder }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    @if (Auth::user()->role == 'Customers')
                                    <div class="col-md-12">
                                      <div class="card">
                                        <div class="card-body">
                                          <h4>Target this month</h4> <h3 class="text-danger">IDR {{ number_format($sumOrderAmount,2,',','.') }} / IDR {{ number_format($target,2,',','.') }}</h3>
                                          <div class="progress m-3">
                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $sumOrderAmount }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentase.'%' }};"><strong>{{ $percentase }} %</strong></div>
                                          </div>
                                          @if ($sumOrderAmount >= $target)
                                            <h5 class="text-success">Congratulations, you achieved target this month</h5>
                                          @endif
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                @else
                                  <div class="row">
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=R&sort=id,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-warning">
                                            {{ trans('dashboard.waiting_process')}}
                                            <h1 class="text-right">{{ $waitingProcess }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=P&sort=id,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-success">
                                            {{ trans('dashboard.processed')}}
                                            <h1 class="text-right">{{ $totalProcessed }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                    <div class="col-md-4">
                                      <a href="{{ url('/salesOrders-Filter?status=B&sort=id,desc') }}">
                                        <div class="card">
                                          <div class="card-body bg-danger">
                                            {{ trans('dashboard.rejected_order')}}
                                            <h1 class="text-right">{{ $rejectedOrderAdmin }}</h1>
                                          </div>
                                        </div>
                                      </a>
                                    </div>
                                  </div>
                                  {{-- <div class="row">
                                    <div class="col-md-12">
                                      <figure class="highcharts-figure">
                                          <div id="container"></div>
                                      </figure>
                                    </div>
                                  </div> --}}
                                @endif
                              </div>
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


@push('page_scripts')
  {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-3d.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script> --}}
  <script>
    $('.carousel').carousel({
      interval: 4000
    });

    // Highcharts.chart('container', {
    //     chart: {
    //         type: 'pie',
    //         options3d: {
    //             enabled: true,
    //             alpha: 45
    //         }
    //     },
    //     title: {
    //         text: 'Most Popular Bread of the month'
    //     },
    //     subtitle: {
    //         text: 'Jan 2022'
    //     },
    //     plotOptions: {
    //         pie: {
    //             innerSize: 100,
    //             depth: 45
    //         }
    //     },
    //     series: [{
    //         name: 'Delivered amount',
    //         data: [
    //             ['Bananas', 8],
    //             ['Kiwi', 3],
    //             ['Mixed nuts', 1],
    //             ['Oranges', 6],
    //             ['Apples', 8],
    //             ['Pears', 4],
    //             ['Clementines', 4],
    //             ['Reddish (bag)', 1],
    //             ['Grapes (bunch)', 1]
    //         ]
    //     }]
    // });
  </script>
@endpush  