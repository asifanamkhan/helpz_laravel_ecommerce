<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="GeniusOcean">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Title -->
	<title>{{$gs->title}}</title>
	<!-- favicon -->
	<link rel="icon" type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}" />
	<!-- Bootstrap -->
	<link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
	<!-- Fontawesome -->
	<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome.css')}}">
	<!-- icofont -->
	<link rel="stylesheet" href="{{asset('assets/admin/css/icofont.min.css')}}">
	<!-- Sidemenu Css -->
	<link href="{{asset('assets/admin/plugins/fullside-menu/css/dark-side-style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/plugins/fullside-menu/waves.min.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/admin/css/plugin.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-coloroicker.css') }}">
	<!-- Main Css -->

	<!-- stylesheet -->
	@if(DB::table('admin_languages')->where('is_default','=',1)->first()->rtl == 1)

	<link href="{{asset('assets/admin/css/rtl/style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/rtl/custom.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/rtl/responsive.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />

	@else

	<link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />
	@endif

	@yield('styles')

</head>

<body>
	<div class="page">
		<div class="page-main">
			<!-- Header Menu Area Start -->
			<div class="header">
				<div class="container-fluid">
					<div class="d-flex justify-content-between">
						<div class="menu-toggle-button">
							<a class="nav-link" href="javascript:;" id="sidebarCollapse">
								<div class="my-toggl-icon">
									<span class="bar1"></span>
									<span class="bar2"></span>
									<span class="bar3"></span>
								</div>
							</a>
						</div>

						<div class="right-eliment">
							<ul class="list">

								<li class="bell-area">
									<a id="notf_conv" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-envelope"></i>
										<span data-href="{{ route('conv-notf-count') }}"
											id="conv-notf-count">{{ App\Models\Notification::countConversation() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('conv-notf-show') }}"
											id="conv-notf-show">
										</div>
									</div>
								</li>

								<li class="bell-area">
									<a id="notf_product" class="dropdown-toggle-1" href="javascript:;">
										<i class="icofont-cart"></i>
										<span data-href="{{ route('product-notf-count') }}"
											id="product-notf-count">{{ App\Models\Notification::countProduct() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('product-notf-show') }}"
											id="product-notf-show">
										</div>
									</div>
								</li>

								<li class="bell-area">
									<a id="notf_user" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-user"></i>
										<span data-href="{{ route('user-notf-count') }}"
											id="user-notf-count">{{ App\Models\Notification::countRegistration() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('user-notf-show') }}"
											id="user-notf-show">
										</div>
									</div>
								</li>

								<li class="bell-area">
									<a id="notf_order" class="dropdown-toggle-1" href="javascript:;">
										<i class="far fa-newspaper"></i>
										<span data-href="{{ route('order-notf-count') }}"
											id="order-notf-count">{{ App\Models\Notification::countOrder() }}</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper" data-href="{{ route('order-notf-show') }}"
											id="order-notf-show">
										</div>
									</div>
								</li>

								<li class="login-profile-area">
									<a class="dropdown-toggle-1" href="javascript:;">
										<div class="user-img">
											<img src="{{ Auth::guard('admin')->user()->photo ? asset('assets/images/admins/'.Auth::guard('admin')->user()->photo ):asset('assets/images/noimage.png') }}"
												alt="">
										</div>
									</a>
									<div class="dropdown-menu">
										<div class="dropdownmenu-wrapper">
											<ul>
												<h5>{{ __('Welcome!') }}</h5>
												<li>
													<a href="{{ route('admin.profile') }}"><i class="fas fa-user"></i>
														{{ __('Edit Profile') }}</a>
												</li>
												<li>
													<a href="{{ route('admin.password') }}"><i class="fas fa-cog"></i>
														{{ __('Change Password') }}</a>
												</li>
												<li>
													<a href="{{ route('admin.logout') }}"><i
															class="fas fa-power-off"></i> {{ __('Logout') }}</a>
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Header Menu Area End -->
			<div class="wrapper">
				<!-- Side Menu Area Start -->
				<nav id="sidebar" class="nav-sidebar">
					<ul class="list-unstyled components" id="accordion">
						<li>
							<a href="{{ route('admin.dashboard') }}" class="wave-effect active"><i
									class="fa fa-home mr-2"></i>{{ __('Dashboard') }}</a>
						</li>
						<li>
							<a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
							<ul class="collapse list-unstyled" id="order" data-parent="#accordion">
								<li>
									<a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-manage')}}"> {{ __('Manage Order') }}</a>
								</li>
								<li>
									<a href="{{route('manage-order-history')}}"> {{ __('Manage Order History') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a>
								</li>
								<li>
									<a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-cart"></i>{{ __('Products') }}
							</a>
							<ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-prod-types') }}"><span>{{ __('Add New Product') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a>
								</li>
							</ul>
						</li>

						<!-- <li>
							<a href="#affiliateprod" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-cart"></i>{{ __('Affiliate Products') }}
							</a>
							<ul class="collapse list-unstyled" id="affiliateprod" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-import-create') }}"><span>{{ __('Add Affiliate Product') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-import-index') }}"><span>{{ __('All Affiliate Products') }}</span></a>
								</li>
							</ul>
						</li> -->

						<li>
							<a href="{{ route('admin-vendor-index') }}" class=" wave-effect">
							<i class="fas fa-user-secret"></i>{{ __('Manage Vendor') }}</a>
						</li>

                        <li>
                            <a href="{{ route('admin-supplier-index') }}" class=" wave-effect">
                                <i class="fas fa-user-secret"></i>{{ __('Manage Supplier') }}</a>
                        </li>

						<li>
							<a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-user"></i>{{ __('Customers') }}
							</a>
							<ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a>
								</li>
							</ul>
						</li>





						<li>
							<a href="#menu5" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false"><i class="fas fa-sitemap"></i>{{ __('Manage Categories') }}</a>
							<ul class="collapse list-unstyled" id="menu5" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-subcat-index') }}"><span>{{ __('Sub Category') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-childcat-index') }}"><span>{{ __('Child Category') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="{{ route('admin-prod-import') }}"><i
									class="fas fa-upload"></i>{{ __('Bulk Product Upload') }}</a>
						</li>

						<li>
							<a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="icofont-speech-comments"></i>{{ __('Product Discussion') }}
							</a>
							<ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-rating-index') }}"><span>{{ __('Product Reviews') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-comment-index') }}"><span>{{ __('Comments') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-report-index') }}"><span>{{ __('Reports') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="{{ route('admin-coupon-index') }}" class=" wave-effect"><i
									class="fas fa-percentage"></i>{{ __('Set Coupons') }}</a>
						</li>
						<li>
							<a href="{{ route('admin-campaign-index') }}" class=" wave-effect"><i
									class="fas fa-percentage"></i>{{ __('Campaign Rule') }}</a>
						</li>
						<li>
							<a href="{{ route('admin-reward-index') }}" class=" wave-effect"><i
									class="fas fa-percentage"></i>{{ __('Reward Point Condition') }}</a>
						</li>
						<li>
							<a href="#offerCreate" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
								<i class="icofont-speech-comments"></i>{{ __('Offer create') }}
							</a>
							<ul class="collapse list-unstyled" id="offerCreate" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-offer-index') }}"><span>{{ __('Offer list') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-offer-index') }}"><span>{{ __('Create offer') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
							</a>
							<ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#msg" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-fw fa-newspaper"></i>{{ __('Messages') }}
							</a>
							<ul class="collapse list-unstyled" id="msg" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a>
								</li>
							</ul>
						</li>


						@if(Auth::guard('admin')->user()->IsAdmin())

						<li>
							<a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-cogs"></i>{{ __('General Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="general" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-gs-logo') }}"><span>{{ __('Logo') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-gs-fav') }}"><span>{{ __('Favicon') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-gs-load') }}"><span>{{ __('Loader') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-shipping-index') }}"><span>{{ __('Shipping Methods') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-package-index') }}"><span>{{ __('Packagings') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-pick-index') }}"><span>{{ __('Pickup Locations') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-gs-contents') }}"><span>{{ __('Website Contents') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-gs-footer') }}"><span>{{ __('Footer') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-gs-affilate') }}"><span>{{__('Affiliate Information')}}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-gs-popup') }}"><span>{{ __('Popup Banner') }}</span></a>
								</li>


								<li>
									<a
										href="{{ route('admin-gs-error-banner') }}"><span>{{ __('Error Banner') }}</span></a>
								</li>

							</ul>
						</li>

						@endif


						<li>
							<a href="#homepage" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-edit"></i>{{ __('Home Page Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="homepage" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-sb-landing') }}"><span>{{ __('Landing Banners') }}</span></a>
								</li>
								<li>
								<li>
									<a href="{{ route('admin-sl-index') }}"><span>{{ __('Sliders') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-featuredlink-index') }}"><span>{{ __('Featured Links') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-featuredbanner-index') }}"><span>{{ __('Featured Banners') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-service-index') }}"><span>{{ __('Services') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-best-seller') }}"><span>{{ __('Right Side Banner1') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-big-save') }}"><span>{{ __('Right Side Banner2') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-sb-index') }}"><span>{{ __('Top Small Banners') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-sb-large') }}"><span>{{ __('Large Banners') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-sb-bottom') }}"><span>{{ __('Bottom Small Banners') }}</span></a>
								</li>

								<li>
									<a href="{{ route('admin-review-index') }}"><span>{{ __('Reviews') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-partner-index') }}"><span>{{ __('Partners') }}</span></a>
								</li>


								<li>
									<a
										href="{{ route('admin-ps-customize') }}"><span>{{ __('Home Page Customization') }}</span></a>
								</li>
							</ul>
						</li>


						@if(Auth::guard('admin')->user()->IsAdmin())


						<li>
							<a href="#menu" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-file-code"></i>{{ __('Menu Page Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="menu" data-parent="#accordion">
								<li>
									<a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a>
								</li>
								<li>
									<a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-at"></i>{{ __('Email Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
								<li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a>
								</li>
								<li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#payments" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-file-code"></i>{{ __('Payment Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="payments" data-parent="#accordion">
								<li><a
										href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a>
								</li>
								<li><a
										href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a>
								</li>
								<li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
								<li><a href="{{route('admin-social-index')}}"><span>{{ __('Social Links') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-social-facebook')}}"><span>{{ __('Facebook Login') }}</span></a>
								</li>
								<li><a href="{{route('admin-social-google')}}"><span>{{ __('Google Login') }}</span></a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#langs" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-language"></i>{{ __('Language Settings') }}
							</a>
							<ul class="collapse list-unstyled" id="langs" data-parent="#accordion">
								<li><a
										href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a>
								</li>
								<li><a
										href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a>
								</li>

							</ul>
						</li>

						<li>
							<a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse"
								aria-expanded="false">
								<i class="fas fa-wrench"></i>{{ __('SEO Tools') }}
							</a>
							<ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
								<li>
									<a
										href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a>
								</li>
								<li>
									<a
										href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="{{ route('admin-staff-index') }}" class=" wave-effect"><i
									class="fas fa-user-secret"></i>{{ __('Manage Staffs') }}</a>
						</li>


						<li>
							<a href="{{ route('admin-subs-index') }}" class=" wave-effect"><i
									class="fas fa-users-cog mr-2"></i>{{ __('Subscribers') }}</a>
						</li>

						@endif

					</ul>

					
				</nav>
				<!-- Main Content Area Start -->
				@yield('content')
				<!-- Main Content Area End -->
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var mainurl = "{{url('/')}}";
		var admin_loader = "{{ $gs->is_admin_loader }}";
		var whole_sell = "{{ $gs->wholesell }}"";
	</script>

	<!-- Dashboard Core -->
	<script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/vendors/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
	<!-- Fullside-menu Js-->
	<script src="{{asset('assets/admin/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('assets/admin/plugins/fullside-menu/waves.min.js')}}"></script>

	<script src="{{asset('assets/admin/js/plugin.js')}}"></script>
	<script src="{{asset('assets/admin/js/Chart.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/tag-it.js')}}"></script>
	<script src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
	<script src="{{asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
	<script src="{{asset('assets/admin/js/notify.js') }}"></script>

	<script src="{{asset('assets/admin/js/jquery.canvasjs.min.js')}}"></script>

	<script src="{{asset('assets/admin/js/load.js')}}"></script>
	<!-- Custom Js-->
	<script src="{{asset('assets/admin/js/custom.js')}}"></script>
	<!-- AJAX Js-->
	<script src="{{asset('assets/admin/js/myscript.js')}}"></script>
	@yield('scripts')

	@if($gs->is_admin_loader == 0)
	<style>
		div#geniustable_processing {
			display: none !important;
		}
	</style>
	@endif

</body>

</html>