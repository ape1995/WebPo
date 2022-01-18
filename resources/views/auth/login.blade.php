<!doctype html>
<html lang="en">
  <head>
  	<title>Yamazaki Indonesia</title>
    <meta charset="utf-8">
	<link rel="icon" href="{{ asset('assets/images/yamazaki.ico') }}">
	<meta name="theme-color" content="#c61325"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('assets/css/login-style.css') }}">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img p-3" style="background-image: url('/assets/images/yamazaki-myroti.png')">
			        </div>
					<div class="login-wrap p-4 p-md-5">
			      		<div class="d-flex">
							<div class="w-100">
								<h3 class="mb-4">{{ trans('login.title')}}</h3>
							</div>
							{{-- <div class="w-100">
								<p class="social-media d-flex justify-content-end">
									<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
									<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
								</p>
							</div> --}}
						</div>
							<form method="POST" action="{{ route('login') }}" class="signin-form">
								@csrf
								<div class="form-group mb-3">
									<label class="label" for="name">{{ trans('login.email')}}</label>
									<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
		            			<div class="form-group mb-3">
		            				<label class="label" for="password">{{ trans('login.password')}}</label>
		              				<input type="password" name="password" class="form-control" placeholder="Password"  required autocomplete="current-password">
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="form-group">
									<button type="submit" class="form-control btn btn-primary rounded submit px-3">{{ trans('login.button')}}</button>
								</div>
		            			<div class="form-group d-md-flex">
		            				{{-- <div class="w-50 text-left">
			            				<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
											<input type="checkbox" checked>
											<span class="checkmark"></span>
										</label>
									</div> --}}
									{{-- <div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div> --}}
		            			</div>
		          			</form>
		          			{{-- <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p> --}}
		        		</div>
		      		</div>
				</div>
			</div>
		</div>
	</section>
	</body>
</html>