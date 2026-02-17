<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-border">
	<div class="navbar-wrapper">
		<div class="navbar-header">
			<ul class="nav navbar-nav flex-row">
				<li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
				<li class="nav-item">
					<a href="{{ route('home') }}" class="navbar-brand">
						<img style="width:32px;height: 25px" class="brand-logo" src="{{ asset('images/logo/congologo.png') }}" alt="congo logo">
						<h5 style="font-family:sans-serif, Verdana" class="brand-text">{{__('sidebar.heading')}}</h5>
					</a>
				</li>
				<li class="nav-item d-md-none">
					<a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
				</li>
				{{--<li class="nav-item d-none d-md-block float-right"><a data-toggle="collapse" class="nav-link modern-nav-toggle pr-0"><i data-ticon="ft-toggle-right" class="toggle-icon ft-toggle-right font-medium-3 white"></i></a></li>
				<li class="nav-item d-md-none">
					<a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
				</li>--}}
			</ul>
		</div>
		<div class="navbar-container content">
			<div id="navbar-mobile" class="collapse navbar-collapse">
				<ul class="nav navbar-nav mr-auto float-left">
					<li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
					{{--<li class="pr-1">
						<img style="width:70px;height: 47px" class="logo" src="{{ asset('images/logo/congologo.png') }}" alt="congo logo">
					</li>--}}
					<li class="d-flex flex-column">
						<h4 class="mb-0">{{__("DEMOCRATIC REPUBLIC OF CONGO")}}</h4>
						<hr class="my-0" width="100%">
						<h5 style="margin-top: 0.3rem">{{__("MINISTRY OF SOCIAL AFFAIRS")}}</h5>
					</li>
					
				</ul>
				
				{{-- <ul class="nav navbar-nav">
					<li class="">
						<a id="google_translate_element" data-toggle="dropdown" class="nav-link"></a>
					</li>
				</ul> --}}

				<ul class="nav navbar-nav float-right">

					<li class="dropdown dropdown-language nav-item">
						<a style="font-size: 13px" class="dropdown-toggle nav-link" id="dropdown-flag"
						   href="javascript:;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
					</li>
					
					<li class="dropdown dropdown-user nav-item">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
							<span style="font-size: 13px;line-height: 30px" class="user-name">{{auth()->user()->name}}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{ route('manage.user.profile') }}" >
								{{__('auth.profile')}}
							</a>
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								{{ __('auth.logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
<script src="{{ asset('js/ajax/jquery.min.js') }}" type="text/javascript"></script>
{{--<script src="{{ asset('js/translate.js') }}" type="text/javascript"></script>--}}

{{--<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'fr',includedLanguages: 'fr,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
    }
</script>
<script>
	$('document').ready(function () {
		$('#google_translate_element').on("click", function () {

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
</script>--}}

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
        color: #505253 !important;
        border:none;
		font-size: 13px;
		font-family: 'Montserrat Light';
		outline: none;
	}

	#google_translate_element{
		margin-top: -20px;
		height: 10px;
	}

    .goog-te-gadget-simple  {
        border: none;
    }

    .goog-te-gadget-icon {
        display: none;
    }
    
</style>


