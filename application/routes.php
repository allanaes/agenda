<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

// Route::get('/', function()
// {
// 	return View::make('home.index');
// });

// Redirect ke route beranda
Route::get('/', function()
{
	return Redirect::to_route('beranda');
});

// Kalau user sudah login, redirect ke route index (-> diredirect lagi ke beranda)
Route::get('login', array('before'=>'is_logged_in', 'as'=>'login', 'uses'=>'auth@index'));

// Login dan logout
Route::post('login/auth', array('before'=>'csrf', 'uses'=>'auth@authenticate'));
Route::get('logout', array('uses'=>'auth@logout'));

/**
 * Route selanjutnya mengharuskan user untuk login.
 */
// Route untuk beranda.
Route::get('beranda', array('before'=>'auth', 'as'=>'beranda', 'uses'=>'beranda@index'));

// Route untuk surat masuk.
// all users, no guest
Route::get('suratmasuk', array('before'=>'auth', 'before'=>'is_user', 'as'=>'suratmasuks', 'uses'=>'suratmasuks@index'));
Route::post('suratmasuk/create', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratmasuks@create'));
Route::get('suratmasuk/(:any?)/edit', array('before'=>'auth', 'before'=>'is_user', 'as'=>'edit_suratmasuk', 'uses'=>'suratmasuks@edit'));
Route::get('suratmasuk/(:any?)/disposisi', array('before'=>'auth', 'before'=>'is_user', 'as'=>'disposisi_suratmasuk', 'uses'=>'suratmasuks@disposisi'));
Route::put('suratmasuk/update', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratmasuks@update'));
// aktivitas surat masuk 
Route::get('suratmasuk/(:any?)/aktivitas', array('before'=>'auth', 'before'=>'is_user', 'as'=>'aktivitas_suratmasuk', 'uses'=>'suratmasuks@aktivitas'));
Route::post('suratmasuk/(:any?)/aktivitas/create', array('before'=>'auth', 'before'=>'is_user', 'as'=>'aktivitas_suratmasuk_create', 'uses'=>'suratmasuks@aktivitas_create'));
// pengawasan surat masuk
Route::get('suratmasuk/pengawasan', array('before'=>'auth', 'before'=>'is_user', 'as'=>'pengawasan_suratmasuk', 'uses'=>'suratmasuks@pengawasan'));

// all users, guest ok
Route::get('suratmasuk/(:any)', array('before'=>'auth', 'as'=>'suratmasuk', 'uses'=>'suratmasuks@view'));
Route::get('suratmasuk/search', array('before'=>'auth', 'as'=>'search_suratmasuk', 'uses'=>'suratmasuks@search'));
Route::get('suratmasuk/print', array('before'=>'auth', 'as'=>'print_suratmasuk', 'uses'=>'suratmasuks@print'));

// Route untuk surat keluar
// all users, no guest
Route::get('suratkeluar', array('before'=>'auth', 'before'=>'is_user', 'as'=>'suratkeluars', 'uses'=>'suratkeluars@index'));
Route::get('suratkeluar/massal', array('before'=>'auth', 'before'=>'is_user', 'as'=>'suratkeluar_massal', 'uses'=>'suratkeluars@indexmassal'));
Route::post('suratkeluar/create', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluars@create'));
Route::post('suratkeluar/createmassal', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluars@createmassal'));
Route::post('suratkeluar/import', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluars@import'));
Route::get('suratkeluar/(:any?)/edit', array('before'=>'auth', 'before'=>'is_user', 'as'=>'edit_suratkeluar', 'uses'=>'suratkeluars@edit'));
Route::put('suratkeluar/update', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluars@update'));
Route::delete('suratkeluar/delete', array('before'=>'auth', 'before'=>'is_user', 'before'=>'crsf', 'uses'=>'suratkeluars@undo'));
// all users, guest ok
Route::get('suratkeluar/(:any)', array('before'=>'auth', 'as'=>'suratkeluar', 'uses'=>'suratkeluars@view'));
Route::get('suratkeluar/search', array('before'=>'auth', 'as'=>'search_suratkeluar', 'uses'=>'suratkeluars@search'));
Route::get('suratkeluar/print', array('before'=>'auth', 'as'=>'print_suratkeluar', 'uses'=>'suratkeluars@print'));

// Route untuk surat keluar lain ----------------------------------
// all users, no guest
Route::get('suratkeluarlain', array('before'=>'auth', 'before'=>'is_user', 'as'=>'suratkeluarlains', 'uses'=>'suratkeluarlains@index'));
Route::get('suratkeluarlain/massal', array('before'=>'auth', 'before'=>'is_user', 'as'=>'suratkeluarlain_massal', 'uses'=>'suratkeluarlains@indexmassal'));
Route::post('suratkeluarlain/create', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluarlains@create'));
Route::post('suratkeluarlain/createmassal', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluarlains@createmassal'));
Route::post('suratkeluarlain/import', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluarlains@import'));
Route::get('suratkeluarlain/(:any?)/edit', array('before'=>'auth', 'before'=>'is_user', 'as'=>'edit_suratkeluarlain', 'uses'=>'suratkeluarlains@edit'));
Route::put('suratkeluarlain/update', array('before'=>'auth', 'before'=>'is_user', 'before'=>'csrf', 'uses'=>'suratkeluarlains@update'));
Route::delete('suratkeluarlain/delete', array('before'=>'auth', 'before'=>'is_user', 'before'=>'crsf', 'uses'=>'suratkeluarlains@destroy'));
// all users, guest ok
Route::get('suratkeluarlain/(:any)', array('before'=>'auth', 'as'=>'suratkeluarlain', 'uses'=>'suratkeluarlains@view'));
Route::get('suratkeluarlain/search', array('before'=>'auth', 'as'=>'search_suratkeluarlain', 'uses'=>'suratkeluarlains@search'));
Route::get('suratkeluarlain/print', array('before'=>'auth', 'as'=>'print_suratkeluarlain', 'uses'=>'suratkeluarlains@print'));

// Route settings untuk semua tipe user
Route::get('settings', array('before'=>'auth', 'before'=>'is_user', 'as'=>'settings', 'uses'=>'settings@index'));

// Route settings berikut hanya available untuk admin
Route::get('settings/disposisi', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_disposisi', 'uses'=>'settings@disposisi'));
Route::post('settings/disposisi/add', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@disposisi_add'));
Route::put('settings/disposisi/update', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@disposisi_update'));
Route::get('settings/disposisi/(:any)/toggle', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_disposisi_toggle', 'uses'=>'settings@disposisi_toggle'));
Route::get('settings/jenissurat', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_jenissurat', 'uses'=>'settings@jenissurat'));
Route::post('settings/jenissurat/add', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@jenissurat_add'));
Route::put('settings/jenissurat/update', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@jenissurat_update'));
Route::get('settings/jenissurat/(:any)/toggle', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_jenissurat_toggle', 'uses'=>'settings@jenissurat_toggle'));
Route::get('settings/konfigurasi', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_konfigurasi', 'uses'=>'settings@konfigurasi'));
Route::put('settings/konfigurasi/update', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@konfigurasi_update'));
Route::get('settings/petunjuk', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_petunjuk', 'uses'=>'settings@petunjuk'));
Route::post('settings/petunjuk/add', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@petunjuk_add'));
Route::put('settings/petunjuk/update', array('before'=>'auth','before' => 'is_admin', 'before'=>'csrf', 'uses'=>'settings@petunjuk_update'));

// Admin dan user biasa dapat mengakses
Route::get('settings/user', array('before'=>'auth', 'as'=>'settings_user', 'uses'=>'settings@user'));

// For admin lagi
Route::get('settings/user/(:any?)/edit', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_user_edit', 'uses'=>'settings@user_edit'));
Route::post('settings/user/add', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_user_add', 'uses'=>'settings@user_add'));
Route::get('settings/liberation', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_liberation', 'uses'=>'settings@liberation'));
Route::get('settings/liberation/suratmasuk', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_liberation_suratmasuk', 'uses'=>'settings@liberation_suratmasuk'));
Route::get('settings/liberation/suratkeluar', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_liberation_suratkeluar', 'uses'=>'settings@liberation_suratkeluar'));
Route::get('settings/liberation/suratkeluarlain', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_liberation_suratkeluarlain', 'uses'=>'settings@liberation_suratkeluarlain'));
Route::get('settings/liberation/suratmasukaktivitas', array('before'=>'auth','before' => 'is_admin', 'as'=>'settings_liberation_suratmasukaktivitas', 'uses'=>'settings@liberation_suratmasukaktivitas'));

// Route untuk reset profile untuk semua tipe user
Route::post('settings/user/reset', array('before'=>'auth', 'before'=>'csrf', 'uses'=>'settings@user_reset'));

// Route help page untuk semua tipe user
Route::get('bantuan', array('before'=>'auth', 'as'=>'bantuan', 'uses'=>'bantuan@index'));
Route::get('bantuan/suratmasuk', array('before'=>'auth', 'as'=>'bantuan_suratmasuk', 'uses'=>'bantuan@bantuan_suratmasuk'));
Route::get('bantuan/suratkeluar', array('before'=>'auth', 'as'=>'bantuan_suratkeluar', 'uses'=>'bantuan@bantuan_suratkeluar'));
Route::get('bantuan/settings', array('before'=>'auth', 'as'=>'bantuan_settings', 'uses'=>'bantuan@bantuan_settings'));
Route::get('bantuan/faq', array('before'=>'auth', 'as'=>'bantuan_faq', 'uses'=>'bantuan@bantuan_faq'));


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to_route('login')->with('warning', 'Anda belum login.');
});

Route::filter('is_admin', function()
{
	if (Auth::guest()) {
		return Redirect::to_route('login')->with('warning', 'Anda belum login.');
	} else {
		$daftar_tipe = User::daftar_tipe();
		$is_auth = Auth::user();

		// jika tipe user selain 'admin', maka return error 500 (forbidden)
		if (isset($is_auth)) {
			if ($is_auth->tipe != $daftar_tipe['admin']) return Response::error('500');		
		} else {
			 return Redirect::to_route('login')->with('warning', 'Session habis, silakan login kembali.');			
		}
	}
});

Route::filter('is_user', function()
{
	if (Auth::guest()) {
		return Redirect::to_route('login')->with('warning', 'Anda belum login.');
	} else {
		$daftar_tipe = User::daftar_tipe();
		$is_auth = Auth::user();

		// jika tipe user selain 'admin' atau 'user', maka return error 500 (forbidden)
		// filter ini dipakai untuk membatasi akses 'guest'
		if (isset($is_auth)) {
			if (($is_auth->tipe != $daftar_tipe['user']) && ($is_auth->tipe != $daftar_tipe['admin'])) return Response::error('500');		
		} else {
			 return Redirect::to_route('login')->with('warning', 'Session habis, silakan login kembali.');			
		}
	}
});

Route::filter('is_logged_in', function()
{
	if (Auth::check()) return Redirect::to('/');
});