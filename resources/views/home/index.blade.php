@extends('layouts.app')

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
                                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                                    <li data-target="#demo" data-slide-to="1"></li>
                                    <li data-target="#demo" data-slide-to="2"></li>
                                  </ul>
                                  
                                  <!-- The slideshow -->
                                  <div class="carousel-inner mb-3">
                                    <div class="carousel-item active">
                                      <img src="https://cf.shopee.co.id/file/b9687fa71e25c40acd5e3bc51354c88e" alt="My Roti 1" width="100%" height="100%">
                                    </div>
                                    <div class="carousel-item">
                                      <img src="https://yamazaki.co.id/wp-content/uploads/2020/08/Roti-Isi.jpg" alt="My Roti 2" width="100%" height="100%">
                                    </div>
                                    <div class="carousel-item">
                                      <img src="https://yamazaki.co.id/wp-content/uploads/2020/08/Roti-Tawar.jpg" alt="My Roti 3" width="100%" height="100%">
                                    </div>
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
                                      <div class="card">
                                        <div class="card-body bg-secondary text-light">
                                          {{ trans('dashboard.draft_order')}}
                                          <h1 class="text-right">{{ $draftOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-info">
                                          {{ trans('dashboard.submitted_order')}}
                                          <h1 class="text-right">{{ $submittedOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-success">
                                          {{ trans('dashboard.processed_order')}}
                                          <h1 class="text-right">{{ $processedOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="card">
                                        <div class="card-body">
                                          <h3 class="text-danger">Your Target is IDR {{ number_format($target,2,',','.') }}</h3>
                                          <div class="progress">
                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{ $sumOrderAmount }}" aria-valuemin="0" aria-valuemax="{{ $target }}" style="width: {{ $percentase.'%' }};"><strong>IDR {{ number_format($sumOrderAmount,2,',','.') }}<span class="sr-only">20% Complete</span></div>
                                          </div>
                                          @if ($sumOrderAmount >= $target)
                                            <h5 class="text-danger">Congratulations, you met your target this month</h5>
                                          @endif
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                @else
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-warning">
                                          {{ trans('dashboard.waiting_process')}}
                                          <h1 class="text-right">{{ $waitingProcess->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-success">
                                          {{ trans('dashboard.processed')}}
                                          <h1 class="text-right">{{ $totalProcessed->count() }}</h1>
                                        </div>
                                      </div>
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