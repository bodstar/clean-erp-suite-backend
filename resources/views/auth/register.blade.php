@extends('layouts.full-screen')


@section('content')
	{{--<div class="container">--}}
	{{--<div class="row justify-content-center">--}}
	{{--<div class="col-md-8">--}}
	{{--<div class="card">--}}
	{{--<div class="card-header">{{ __('Register') }}</div>--}}

	{{--<div class="card-body">--}}
	{{--<form method="POST" action="{{ route('register') }}">--}}
	{{--@csrf--}}

	{{--<div class="form-group row">--}}
	{{--<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

	{{--<div class="col-md-6">--}}
	{{--<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>--}}

	{{--@if ($errors->has('name'))--}}
	{{--<span class="invalid-feedback">--}}
	{{--<strong>{{ $errors->first('name') }}</strong>--}}
	{{--</span>--}}
	{{--@endif--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group row">--}}
	{{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

	{{--<div class="col-md-6">--}}
	{{--<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>--}}

	{{--@if ($errors->has('email'))--}}
	{{--<span class="invalid-feedback">--}}
	{{--<strong>{{ $errors->first('email') }}</strong>--}}
	{{--</span>--}}
	{{--@endif--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group row">--}}
	{{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

	{{--<div class="col-md-6">--}}
	{{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

	{{--@if ($errors->has('password'))--}}
	{{--<span class="invalid-feedback">--}}
	{{--<strong>{{ $errors->first('password') }}</strong>--}}
	{{--</span>--}}
	{{--@endif--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group row">--}}
	{{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

	{{--<div class="col-md-6">--}}
	{{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group row mb-0">--}}
	{{--<div class="col-md-6 offset-md-4">--}}
	{{--<button type="submit" class="btn btn-primary">--}}
	{{--{{ __('Register') }}--}}
	{{--</button>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</form>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	<section class="flexbox-container">
		<div class="col-12 d-flex align-items-center justify-content-center">
			<div class="col-md-4 col-10 box-shadow-2 p-0">
				<div class="card border-grey border-lighten-3 px-1 py-1 m-0">
					<div class="card-header border-0 pb-0">
						<div class="card-title text-center">
							<img src="{{ asset('images/logo/stack-logo-dark.png') }}" alt="branding logo">
							</div>
						{{--<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">--}}
							{{--<span>Easily Using</span>--}}
						{{--</h6>--}}
						</div>
					<div class="card-content">
						{{--<div class="text-center">--}}
							{{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">--}}
								{{--<span class="fa fa-facebook"></span>--}}
							{{--</a>--}}
							{{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">--}}
								{{--<span class="fa fa-twitter"></span>--}}
							{{--</a>--}}
							{{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin">--}}
								{{--<span class="fa fa-linkedin font-medium-4"></span>--}}
							{{--</a>--}}
							{{--<a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github">--}}
								{{--<span class="fa fa-github font-medium-4"></span>--}}
							{{--</a>--}}
						{{--</div>--}}
						{{--<p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">--}}
							{{--<span>OR Using Email</span>--}}
						{{--</p>--}}
							<div class="card-body">
							<form class="form-horizontal" method="post" action="" autocomplete="off">
								@csrf
								<fieldset class="form-group position-relative has-icon-left {{ $errors->has('name')?'has-danger':'' }}">
									<input type="text" class="form-control" id="user-name" placeholder="User Name" name="name" value="{{ old('name') }}">
									<div class="form-control-position">
										<i class="ft-user"></i>
										</div>
									@if($errors->has('name'))
										<p class="text-left danger text-muted">{{ $errors->first('name') }}</p>
									@endif
									</fieldset>
								<fieldset class="form-group position-relative has-icon-left {{ $errors->has('email')?'has-danger':'' }}">
									<input type="email" class="form-control" id="user-email"
									       placeholder="Your Email Address" required name="email" value="{{ old('email') }}">
									<div class="form-control-position">
										<i class="ft-mail"></i>
										</div>
									@if($errors->has('email'))
										<p class="text-left danger text-muted">{{ $errors->first('email') }}</p>
									@endif
									</fieldset>
								<fieldset class="form-group position-relative has-icon-left {{ $errors->has('password')?'has-danger':'' }}">
									<input type="password" class="form-control" id="user-password"
									       placeholder="Enter Password" name="password"
									       required>
									<div class="form-control-position">
										<i class="fa fa-key"></i>
												</div>
									@if($errors->has('password'))
										<p class="text-left danger text-muted">{{ $errors->first('password') }}</p>
									@endif
								</fieldset>

								<fieldset class="form-group position-relative has-icon-left">
									<input type="password" class="form-control" id="user-password"
									       placeholder="Confirm Password"
									       required name="password_confirmation">
									<div class="form-control-position">
										<i class="fa fa-key"></i>
										</div>
									</fieldset>
								<div class="form-group row">
									<div class="col-12 text-center text-sm-left">
									<fieldset>
											<input type="checkbox" id="remember-me" class="chk-remember">
											<label for="remember-me"> Accept terms and conditions</label>
										</fieldset>
												</div>
												</div>
								<button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-user"></i>
									Register
								</button>
							</form>
										</div>
						<div class="card-body">
							<a href="{{ route('login') }}" class="btn btn-outline-danger btn-block"><i
										class="ft-unlock"></i> Login</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
@endsection
