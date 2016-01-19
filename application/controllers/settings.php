<?php

class Settings_Controller extends Base_Controller {
	public $restful = true;

	public function get_index() {
		$daftar_tipe = User::daftar_tipe(); 
		$admin_tipe = $daftar_tipe['admin'];

		if (Auth::user()->tipe == $admin_tipe) {
			// display full settings untuk admin
			$db_disposisi = Disposisi::get();
			$db_jenis_surat = Jenissurat::get();
			$db_konfigurasi = Konfigurasi::get();
			$db_petunjuk = Petunjuk::get();

			return View::make('settings.index')
				->with('title', 'Agenda Surat :: Settings')
				->with('db_disposisi', $db_disposisi)
				->with('db_jenis_surat', $db_jenis_surat)
				->with('db_petunjuk', $db_petunjuk)
				->with('db_konfigurasi', $db_konfigurasi);			
		} else {
			return Redirect::to_route('settings_user');
		}
	}

	public function get_jenissurat() {
		$db_jenis_surat = Jenissurat::get();
		$last_added_jenissurat = Jenissurat::order_by('id', 'desc')->only('jenis_surat');

		return View::make('settings.jenissurat')
			->with('title', 'Agenda Surat :: Settings')
			->with('db_jenis_surat', $db_jenis_surat)
			->with('last_added_jenissurat', $last_added_jenissurat);
	}

	public function get_disposisi() {
		$db_disposisi = Disposisi::get();
		$last_added_disposisi = Disposisi::order_by('id', 'desc')->only('nama');

		return View::make('settings.disposisi')
			->with('title', 'Agenda Surat :: Settings')
			->with('db_disposisi', $db_disposisi)
			->with('last_added_disposisi', $last_added_disposisi);
	}

	public function get_konfigurasi() {
		$db_konfigurasi = Konfigurasi::get();

		return View::make('settings.konfigurasi')
			->with('title', 'Agenda Surat :: Settings')
			->with('db_konfigurasi', $db_konfigurasi);
	}

	public function get_petunjuk() {
		$db_petunjuk = Petunjuk::get();
		$last_added_petunjuk = Petunjuk::order_by('id', 'desc')->only('petunjuk');

		return View::make('settings.petunjuk')
			->with('title', 'Agenda Surat :: Settings')
			->with('db_petunjuk', $db_petunjuk)
			->with('last_added_petunjuk', $last_added_petunjuk);
	}
	
	public function get_liberation() {
		return View::make('settings.liberation')
			->with('title', 'Agenda Surat :: Settings');
	}
	
	public function get_liberation_suratmasuk() {
		Liberation::liberation_suratmasuk();
	}
	
	public function get_liberation_suratkeluar() {
		Liberation::liberation_suratkeluar();
	}

	public function get_liberation_suratkeluarlain() {
		Liberation::liberation_suratkeluarlain();
	}

	public function get_liberation_suratmasukaktivitas() {
		Liberation::liberation_suratmasukaktivitas();
	}

	public function post_disposisi_add() {
		$input = Input::all();
		$validation = Disposisi::validate($input);

		$can_add = Disposisi::check_if_can();
				
		if ($can_add) {
			if ($validation->fails()) {
				return Redirect::to_route('settings_disposisi')->with_errors($validation);
			} else {
				$add = Disposisi::add_disposisi($input);

				return Redirect::to_route('settings_disposisi')
					->with('message', $add);
			}
		} else {
			return Redirect::to_route('settings_disposisi')
				->with('warning', 'Daftar disposisi aktif sudah mencapai maksimum.');
		}
	}

	public function put_disposisi_update() {
		$input = Input::all();
		$validation = Disposisi::validate_alt($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_disposisi')->with_errors($validation);
		} else {
			$update = Disposisi::update_disposisi($input);

			return Redirect::to_route('settings_disposisi')
				->with('message', $update);
		}
	}
	
	public function get_disposisi_toggle($id) {		
		if (is_object(Disposisi::find($id))) {
			$current_status = Disposisi::find($id)->aktif;	
			$can_change = Disposisi::check_if_can();
			
			// oke jika belum mencapai jumlah maksimum aktif atau oke jika untuk toggle ke nonaktif
			if ($can_change || ($current_status == 1)) {
				$jumlah_aktif = Disposisi::where('aktif', '=', 1)->count();
				if (($jumlah_aktif <= 1) && ($current_status == 1)) {
					$warning = "Daftar disposisi aktif minimal satu.";					
					return Redirect::to_route('settings_disposisi')->with('warning', $warning);				
				} else {			
					$toggle = Disposisi::toggle_disposisi($id);
					return Redirect::to_route('settings_disposisi')->with('message', $toggle);
				}
			} else {
					$warning = "Daftar disposisi aktif sudah mencapai maksimum.";					
					return Redirect::to_route('settings_disposisi')->with('warning', $warning);				
			}				
			
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function post_jenissurat_add() {
		$input = Input::all();
		$validation = Jenissurat::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_jenissurat')->with_errors($validation);
		} else {
			$add = Jenissurat::add_jenissurat($input);

			return Redirect::to_route('settings_jenissurat')
				->with('message', $add);
		}
	}

	public function put_jenissurat_update() {
		$input = Input::all();
		$validation = Jenissurat::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_jenissurat')->with_errors($validation);
		} else {
			$update = Jenissurat::update_jenissurat($input);

			return Redirect::to_route('settings_jenissurat')
				->with('message', $update);
		}
	}

	public function get_jenissurat_toggle($id) {		
		if (is_object(Jenissurat::find($id))) {
			$toggle = Jenissurat::toggle_jenissurat($id);

			return Redirect::to_route('settings_jenissurat')->with($toggle['msg_type'], $toggle['message']);			
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function put_konfigurasi_update() {
		$input = Input::all();
		$validation = Konfigurasi::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_konfigurasi')->with_errors($validation);
		} else {
			$update = Konfigurasi::update_konfigurasi($input);
			
			return Redirect::to_route('settings_konfigurasi')
				->with('message', $update['success'])
				->with('warning', $update['warning']);
		}
	}

	public function post_petunjuk_add() {
		$input = Input::all();
		$validation = Petunjuk::validate($input);
		
		$petunjuk_entries = Petunjuk::count();
				
		if ($petunjuk_entries >= 11) {
			return Redirect::to_route('settings_petunjuk')
				->with('warning', 'Daftar petunjuk sudah mencapai maksimum.');
		} else {
			if ($validation->fails()) {
				return Redirect::to_route('settings_petunjuk')->with_errors($validation);
			} else {
				$add = Petunjuk::add_petunjuk($input);

				return Redirect::to_route('settings_petunjuk')
					->with('message', $add);
			}
		}
	}

	public function put_petunjuk_update() {
		$input = Input::all();
		$validation = Petunjuk::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_petunjuk')->with_errors($validation);
		} else {
			$update = Petunjuk::update_petunjuk($input);

			return Redirect::to_route('settings_petunjuk')
				->with('message', $update);
		}
	}

	public function get_user() {
		$daftar_tipe = User::daftar_tipe();

		if (Auth::user()->tipe == $daftar_tipe['admin']) {
			// display full settings
			$db_user = User::get();
			$daftar_tipe = User::daftar_tipe();
			$reversed_daftar_tipe = User::reversed_daftar_tipe();

			return View::make('settings.user_admin')
				->with('title', 'Agenda Surat :: Settings')
				->with('db_user', $db_user)
				->with('daftar_tipe', $daftar_tipe)
				->with('reversed_daftar_tipe', $reversed_daftar_tipe);
		} else {
			// display hanya reset profile untuk user biasa
			$daftar_tipe = User::daftar_tipe();
			$reversed_daftar_tipe = User::reversed_daftar_tipe();

			return View::make('settings.user_user')
				->with('title', 'Agenda Surat :: Settings')
				->with('daftar_tipe', $daftar_tipe)
				->with('reversed_daftar_tipe', $reversed_daftar_tipe);
		}
	}
	
	public function get_user_edit($id) {
		$db_user = User::get();
		$user = User::find($id);
		$daftar_tipe = User::daftar_tipe();
		$reversed_daftar_tipe = User::reversed_daftar_tipe();

		return View::make('settings.user_admin_edit')
			->with('title', 'Agenda Surat :: Settings')
			->with('db_user', $db_user)
			->with('user', $user)
			->with('daftar_tipe', $daftar_tipe)
			->with('reversed_daftar_tipe', $reversed_daftar_tipe);
	
	}

	public function post_user_add() {
		$input = Input::all();
		$validation = User::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('settings_user')->with_errors($validation);
		} else {
			$add = User::add_user($input);

			return Redirect::to_route('settings_user')
				->with('message', $add);
		}
	}

	public function post_user_reset() {
		$input = Input::all();
		$validation = User::validate_alt($input);

		if ($validation->fails()) {
			return Redirect::back()->with_errors($validation);
		} else {
			if (!User::is_last_admin($input)) {			
				$reset = User::reset_user($input);

				return Redirect::to_route('settings_user')
					->with('message', $reset);
			} else {				
				return Redirect::to_route('settings_user')
					->with('warning', 'Anda adalah admin terakhir, profile tidak dapat diubah menjadi user biasa.');
			}
		}
	}
}