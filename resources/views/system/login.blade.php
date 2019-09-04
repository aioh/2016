<!-- light-blue - v3.1.0 - 2014-12-06 -->
<!DOCTYPE html>
<html>
<head>
    <title>SP ADMIN</title>
    <link href="{{asset('assets/admin/css/application.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('assets/site/images/favicon.ico')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
        */
    </script>    
</head>
<body class="background-dark">
	<div class="single-widget-container">
		<section class="widget login-widget">
			<header class="text-align-center">
				<h4>Login to your account</h4>
			</header>
			<div class="body">
				{!! Form::open(array('url'=>\URL('system/login'),'method'=>'post','class'=>'no-margin'))!!}
					<fieldset>
						<div class="form-group">
							<label for="email" >Email</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-user"></i>
								</span>
								<input id="email" type="email" name="email" class="form-control input-lg"
								placeholder="Your Email">
							</div>
						</div>
						<div class="form-group">
							<label for="password" >Password</label>
							<div class="input-group input-group-lg">
								<span class="input-group-addon">
									<i class="fa fa-lock"></i>
								</span>
								<input id="password" type="password" name="password" class="form-control input-lg"
								placeholder="Your Password">
							</div>
						</div>
					</fieldset>
					<div class="form-actions">
						<button type="submit" class="btn btn-block btn-lg btn-danger">
							<span class="small-circle"><i class="fa fa-caret-right"></i></span>
							<small>Sign In</small>
						</button>
						<a class="forgot" href="#">
							<!-- Forgot Username or Password? -->
						</a>
					</div>
				{!! Form::close() !!}
			</div>                
		</section>
	</div>
	<!-- common libraries. required for every page-->
	<!-- common libraries. required for every page-->
	<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('assets/admin/lib/jquery-pjax/jquery.pjax.js')}}"></script>
	<script src="{{asset('assets/admin/lib/bootstrap-sass-official/assets/javascripts/bootstrap.js')}}"></script>
	<script src="{{asset('assets/admin/lib/widgster/widgster.js')}}"></script>
	<script src="{{asset('assets/admin/lib/underscore/underscore.js')}}"></script>
	<!-- common application js -->
	<script src="{{asset('assets/admin/lib/messenger/build/js/messenger.js')}}"></script>
	<script src="{{asset('assets/admin/lib/messenger/build/js/messenger-theme-flat.js')}}"></script>
	<script src="{{asset('assets/admin/js/app.js')}}"></script>
	<script src="{{asset('assets/admin/js/settings.js')}}"></script>
	<script src="{{asset('assets/admin/js/ui-notifications.js')}}"></script>
	<!-- common application js -->
	<script src="{{asset('assets/admin/js/app.js')}}"></script>
	<script src="{{asset('assets/admin/js/settings.js')}}"></script>
</body>
</html>