<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ url('cms/app/Modules/Core/Resources/assets/css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Laravel</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="{{ url('/admin') }}">Home</a></li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				@if (Auth::guest())
				<li><a href="{{ url('admin/Acl/login') }}">Login</a></li>
				<li><a href="{{ url('admin/Acl/register') }}">Register</a></li>
				<li><a href="{{ url('/') }}">View Site</a></li>
				@else
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('/') }}">View Site</a></li>
						<li><a href="{{ url('admin/Acl/logout') }}">Logout</a></li>
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
<!-- sidebar start -->
@if ( ! Auth::guest() && \CMS::users()->userHasGroup(\Auth::user()->id, 'admin'))
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
			<p class="visible-xs">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
			</p>
			<div class="well sidebar-nav">
				<ul class="nav">
					@foreach ($sidebar as $element)
						@foreach ($element as $key => $value)
							<ul class="nav navbar-nav col-sm-12">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa {{ $value['icon'] }}"></i> {{ $key }} 
									</a>
									<ul class="dropdown-menu">
										@foreach ($value as $key => $link)
											@if($key !== 'icon')
												<li>
													<a href="{{ $link['url'] }}">
													 	<i class="fa {{ $link['icon'] }}"></i> {{ $key }}
													</a>
												</li>
												<li class="divider"></li>
											@endif
										@endforeach
									</ul>
								</li>
							</ul>
						@endforeach
					@endforeach
				</ul>
			</div><!--/.well -->
		</div><!--/span-->
	@endif
	<!-- sidebar ends -->
	

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
