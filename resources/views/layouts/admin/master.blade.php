<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Xenon Boostrap Admin Panel" />
	<meta name="author" content="" />

	<title>GTW Hero - Admin</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="{{asset('assets/members/css/fonts/linecons/css/linecons.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/fonts/fontawesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/xenon-core.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/xenon-forms.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/xenon-components.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/xenon-skins.css')}}">
	<link rel="stylesheet" href="{{asset('assets/members/css/custom.css')}}">

	<script src="{{asset('assets/members/js/jquery-1.11.1.min.js')}}"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body skin-aero">


<div class="page-container">
	@include('layouts.admin.navigation')


	<div class="main-content">
		<nav class="navbar user-info-navbar" role="navigation"><!-- User Info, Notifications and Menu Bar -->

			<!-- Right links for user info navbar -->
			<ul class="user-info-menu right-links list-inline list-unstyled pull-right">

				<li class="dropdown user-profile" style="min-height: 76px;">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span>
								{{Auth::user()->email}}
								<i class="fa-angle-down"></i>
							</span>
					</a>

					<ul class="dropdown-menu user-profile-menu list-unstyled">
						<li>
							<a href="#profile">
								<i class="fa-user"></i>
								Profile
							</a>
						</li>
						<li class="last">
							<a href="{{url('auth/logout')}}">
								<i class="fa-lock"></i>
								Logout
							</a>
						</li>
					</ul>
				</li>

			</ul>

		</nav>
		<div class="page-title">

			<div class="title-env">
				<h1 class="title">GTW Hero Admin Area</h1>
				<p class="description"></p>
			</div>

		</div>
		<div class="row">
			@include('errors.request')
			@include('alerts.status')
			@yield('contents')

		</div>
	</div>
</div>



<!-- Bottom Scripts -->
<script src="{{asset('assets/members/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/members/js/TweenMax.min.js')}}"></script>
<script src="{{asset('assets/members/js/resizeable.js')}}"></script>
<script src="{{asset('assets/members/js/joinable.js')}}"></script>
<script src="{{asset('assets/members/js/xenon-api.js')}}"></script>
<script src="{{asset('assets/members/js/xenon-toggles.js')}}"></script>
<script src="{{asset('assets/members/js/jquery-validate/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/members/js/toastr/toastr.min.js')}}"></script>


<!-- JavaScripts initializations and stuff -->
<script src="{{asset('assets/members/js/xenon-custom.js')}}"></script>

</body>
</html>