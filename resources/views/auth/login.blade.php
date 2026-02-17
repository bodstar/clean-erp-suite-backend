@extends('layout.full-screen')

{{--@section('bg-image','bg-full-screen-image')--}}

@section('content')

	<section class="flexbox-container" >

		<div class="col-12 d-flex align-items-center justify-content-center">
			<div class="col-12 col-md-6 col-lg-4">
				<div class="row">
					<div class="col-12">
						<div class="card-title text-center">
							<img style="width:20%;" class="logo" src="{{ asset('images/logo/congologo.png') }}" alt="congo_logo">

							<p>{{__('auth.top_description')}}</p>
						</div>
					</div>
				</div>
				<div class="card border-grey border-lighten-3 px-1 py-1 m-0  box-shadow-2 p-0">
					<div class="card-header border-0">
					</div>
					<div class="card-content">
						<div class="card-body">
							

							@if($errors->has('inactive'))
								<p class="text-center danger text-muted">{{ __('Your status is inactive') }}</p>
							@endif

							<div class="col-lg-12">
								@if($errors->has('email'))
									<p class="text-center danger text-muted">{{ __('auth.failed') }}</p>
								@endif
							</div>
							<form class="form-horizontal" method="post" action="{{ route('auth.login') }}" autocomplete="off">
								@csrf

								<fieldset
										class="form-group position-relative has-icon-left {{ $errors->has('email')?'has-danger':''}}">

									<input type="email" required class="form-control has-danger" name="email" id="user-name"
									       placeholder="{{__('auth.your_email')}}"
									        value="{{ old('email') }}">
									<div class="form-control-position">
										<i class="ft-user"></i>
									</div>

								</fieldset>
								<fieldset
										class="form-group position-relative has-icon-left {{ $errors->has('password')?'has-danger':''}}">
									<input type="password" required class="form-control" id="user-password"
									       placeholder="{{__('auth.enter_password')}}" name="password" >
									<div class="form-control-position">
										<i class="fa fa-key"></i>
									</div>
									@if($errors->has('password'))
										<p class="text-left danger text-muted">{{ $errors->first('password') }}</p>
									@endif
								</fieldset>
								<div class="form-group row">

									{{--<div class="col-md-7 col-12 float-sm-left text-center text-sm-left">
										<div id="google_translate_element"></div>
									</div>  --}}
									<div class="col-md-7 col-12 float-sm-left text-center text-sm-left">
										<a class="dropdown-toggle" id="dropdown-flag" href="javascript:;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											{{__('auth.select_language')}} 
											{{--
											@if (app()->isLocale('en')) <i
													class="flag-icon flag-icon-gb"></i> @else <i
													class="flag-icon flag-icon-fr"></i>
											@endif
											--}}
											<span class="selected-language"></span>
										</a>
										<div class="dropdown-menu" aria-labelledby="dropdown-flag">
											<a class="dropdown-item" href="{{ url('locale/en') }}">{{__('auth.english')}}</a>
											<a class="dropdown-item" href="{{ url('locale/fr') }}">{{__('auth.french')}}</a>
										</div>
									</div>
									<div class="col-md-5 col-12 float-sm-left text-center text-sm-right"><a
												href="{{ route('password.request') }}" class="card-link" style="white-space: nowrap">{{__('auth.forgot_password')}}?</a>
									</div>
								</div>
								<button type="submit" class="btn btn-outline-primary btn-block"><i
											class="ft-unlock"></i> {{strtoupper(__('auth.sign_in'))}}
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


	</section>
	@include('layout.footer')

	<script src="{{ asset('js/ajax/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/translate.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'fr',includedLanguages: 'fr,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
        }
	</script>
	<script>
		$('document').ready(function () {
			$('#google_translate_element').on("click", function () {
	
				// Change font family and color
				$("iframe").contents().find(".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div") //, .goog-te-menu2 *
					.css({
						'color': '#544F4B',
						'background-color': 'white',
						'font-family': '"Open Sans",Helvetica,Arial,sans-serif',
					});
					
				//hover
				$("iframe").contents().find(".goog-te-menu2-item div").hover(function () {
					$(this).css('background-color', '#e8eff3').find('span.text').css('color', '#505253');
				
				});
	
				//border
				$("iframe").contents().find('.goog-te-menu2').css('border', 'none');
		
			});
		});
	</script>
	
    <style type="text/css">

        /* To hide the suggestion box */
        #goog-gt-tt, .goog-te-balloon-frame { display: none !important; } 
        .goog-text-highlight { background: none !important; box-shadow: none !important; }

        /* To hide the powered by */
        .goog-logo-link { display: none !important; }
        .goog-te-gadget { height: 28px !important;  overflow: hidden; }

        /* To remove the top frame */
        body{ top: 0 !important; }
        
        /* To hide the google translate toolbar */
        .goog-te-banner-frame { display: none !important; }
		
		/**/
		.goog-te-menu-value {
			color: #0a90a1 !important;
			border:none;
			font-size: 16.5px;
			font-family: 'Calibri Light';
			outline: none;
		}

		/*dropdown*/
        .goog-te-menu-value span:nth-child(5) {
			color:rgb(184, 184, 184) !important;
			font-size:12.5px;
			margin-left:-8px;
		}
		
		/* Remove span with left border line | (next to the arrow) in Chrome & Firefox */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left: 1px solid rgb(187, 187, 187);"] {
            display: none;
		}
		
        /* Remove span with left border line | (next to the arrow) in Edge & IE11 */
        div#google_translate_element div.goog-te-gadget-simple a.goog-te-menu-value span[style="border-left-color: rgb(187, 187, 187); border-left-width: 1px; border-left-style: solid;"] {
            display: none;
        }
		
		.goog-te-gadget-simple  {
			border: none;
		}

		.goog-te-gadget-icon {
    		display: none;
		}
		
		
    </style>

@endsection
