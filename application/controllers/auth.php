<?php

class Auth_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * Display login form
	 */
	public function get_index() {
		return View::make('auth.index')->with('title', 'Agenda Surat :: Login');
	}

	/**
	 * Authenticate user dan redirect ke homepage
	 */
	public function post_authenticate() {
		// get credential
		$credentials = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
    
		// simple authentication
		if (Auth::attempt($credentials))
		{
			return Redirect::to('beranda');
		} else {
			return Redirect::to_route('login')->with('error', 'Username atau Password tidak valid.');
		}
	}

	/**
	 * Logout dan redirect ke login form
	 */
	public function get_logout() {
		// Trigger: 
		// Sebelum logout, mengkosongkan kembali isi folder 'pdf' dari file-file
		// lembar disposisi yang digenerate.
		Printpdf::empty_pdf_folder();

		Auth::logout();
		
		return Redirect::to_route('login')->with('title', 'Agenda Surat :: Login');
	}
}