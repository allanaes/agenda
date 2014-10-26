<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<link href="{{ URL::to_asset('css/alternate.css') }}" media="all" type="text/css" rel="stylesheet">
</head>
<body>
	@yield('content')
	<script type="text/javascript">window.print();</script>
</body>
</html>