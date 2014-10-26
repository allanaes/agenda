<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];

	// stupid method get dirname
	$cwd = getcwd();
	chdir("..");
	$nwd = getcwd();
	$dirname = str_replace('\\', '/', str_replace($nwd, '', $cwd));

	header('Location: '.$uri.$dirname.'/agenda');
	exit;
?>
Pastikan Aplikasi Agenda Surat terinstall dengan benar.