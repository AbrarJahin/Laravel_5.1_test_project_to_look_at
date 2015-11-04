@extends('layouts.auth.master')

@section('content')


	<script type="text/javascript">
		jQuery(document).ready(function($)
		{

			// Validation and Ajax action
			$("form#login").validate({
				rules: {
					username: {
						required: true
					},

					passwd: {
						required: true
					}
				},

				messages: {
					username: {
						required: 'Please enter your email.'
					},

					passwd: {
						required: 'Please enter your password.'
					}
				}

			});

			// Set Form focus
			$("form#login .form-group:has(.form-control):first .form-control").focus();
		});
	</script>

	<!-- Errors container -->
	<div class="errors-container">
		@include('errors.form')
	</div>

	<!-- Add class "fade-in-effect" for login form effect -->
	{!! Form::open(array('url' => 'auth/login', 'class' => 'login-form fade-in', 'id'=>'login')) !!}

		<div class="login-header">
			<a href="#" class="logo">
				<img src="{{asset('assets/members/images/generic-logo-sample.png')}}" alt="" width="200" />
			</a>

			<p>Dear user, log in to access the mebers area!</p>
		</div>


		<div class="form-group">
			<label class="control-label" for="email">Email</label>
			<input type="text" class="form-control" name="email" id="email" autocomplete="off" />
		</div>

		<div class="form-group">
			<label class="control-label" for="password">Password</label>
			<input type="password" class="form-control" name="password" id="password" autocomplete="off" />
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-info  btn-block text-left">
				<i class="fa-lock"></i>
				Log In
			</button>
		</div>

		<div class="login-footer">
			<a href="#">Forgot your password?</a>

			<div class="info-links">
				<a href="#">ToS</a> -
				<a href="#">Privacy Policy</a>
			</div>
            <hr>
            Sample logins if you use seed.
            <p>email : admin@kvsocial.com, pass : ufn13d (admin)</p>
            <p>email : anik@kvsocial.com, pass : pass (admin)</p>
            <p>email : echoanik@gmail.com, pass : pass (customer)</p>

		</div>

	{!! Form::close() !!}
@endsection