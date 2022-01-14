@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
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
                            <div class="row">
                              <div class="col-md-6">
                                <h4 style="margin-bottom: 5px; margin-top: 5px;">{{ $greeting.', '.Auth::user()->name }}</h4>
                                <p>It's {{ $date }}</p>
                              </div>
                              @if (Auth::user()->role == 'Customers')
                              <div class="col-md-3">
                                <h5>Out of stock?</h5>
                                <a href="{{ route('createOrder') }}" class="btn btn-outline-info btn-block">Order Here</a>
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
                                @if (Auth::user()->role == 'Customers')
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-secondary text-light">
                                          DRAFT ORDER
                                          <h1 class="text-right">{{ $draftOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-info">
                                          SUBMITTED ORDER
                                          <h1 class="text-right">{{ $submittedOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-success">
                                          PROCESSED ORDER
                                          <h1 class="text-right">{{ $processedOrder->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                @else
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-warning">
                                          WAITING TO PROCESS
                                          <h1 class="text-right">{{ $waitingProcess->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="card">
                                        <div class="card-body bg-success">
                                          PROCESSED
                                          <h1 class="text-right">{{ $totalProcessed->count() }}</h1>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
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
  <script>
    $('.carousel').carousel({
      interval: 4000
    })
  </script>
@endpush  