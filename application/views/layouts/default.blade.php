<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	{{ Asset::styles() }}
	{{ Asset::scripts() }}
	<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
</head>
<body>

	<?php
		$daftar_tipe = User::daftar_tipe();
		$is_auth = Auth::user();
		if (isset($is_auth)) {
			if (($is_auth->tipe == $daftar_tipe['user']) || ($is_auth->tipe == $daftar_tipe['admin'])) {
				echo render('layouts.navigation_bar');
			} else if ($is_auth->tipe = $daftar_tipe['guest']) {
				echo render('layouts.navigation_bar_guest');
			}
		} else {
			echo render('layouts.navigation_bar_anon');		
		}
	?>

	<div class="container">
		@yield('content')
	</div>
	
	{{ render('layouts.footer') }}	
</body>
</html>