<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" media="screen" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
	<script type="text/javascript" src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
	@yield('head')
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="https://github.com/mxp100/">Y-Soft</a>
	</div>

	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li{{ (Request::is('/') ? ' class="active"' : '') }}><a href="{!! url('/') !!}">Dashboard</a></li>
			<li{{ (Request::is('miners') ? ' class="active"' : '') }}><a href="{!! url('/miners/') !!}">Miners</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li><a href="#">Separated link</a></li>
				</ul>
			</li>
		</ul>
		<form class="navbar-form navbar-right" role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</nav>
<br><br><br>
<div class="container">
	@yield('content')
</div>
</body>
</html>