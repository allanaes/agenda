<?php

class User extends Eloquent {

	public static $table = 'users';

	/**
	 * Rules standar untuk menambah user baru.
	 */
	public static $rules = array(
		'username' => 'required|alpha_num|unique:users,username',
		'fullname' => 'required',
		'password' => 'required|confirmed|min:5',
		'tipe' => 'required'
	);

	/**
	 * Validate dengan rules standar.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Validate dengan rules alternatif.
	 */
	public static function validate_alt($data) {
		return Validator::make($data, User::build_rules_alt($data));
	}

	/**
	 * Tambah user baru.
	 */
	public static function add_user($input) {
		// sanitize daftar tipe
		$tipe = in_array($input['tipe'], User::daftar_tipe()) ? $input['tipe'] : 1;

		// tambah user baru
		User::create(array(
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'fullname' => $input['fullname'],
			'tipe' => $tipe
		));

		// message sukses
		$msg = $input['fullname'] . ' telah ditambahkan ke dalam daftar pengguna aplikasi ini.';
		
		return $msg;
	}
	
	/**
	 * Cek apakah user last admin sebelum dapat mereset profile dirinya,
	 * jika ya, maka tidak diizinkan mengubah tipe dari admin ke normal user.
	 */
	public static function is_last_admin($input) {
		$to_tipe = isset($input['tipe']) ? $input['tipe'] : 1;
		$current_tipe = Auth::user()->tipe;		
		$my_id = Auth::user()->id;		
		$user_id = $input['id'];		
		$daftar_tipe = User::daftar_tipe();		
		$admin_count = User::where('tipe', '=', $daftar_tipe['admin'])->count();
		
		if (($to_tipe != $daftar_tipe['admin'])
			&& ($admin_count == 1)
			&& ($current_tipe == $daftar_tipe['admin'])
			&& ($my_id == $user_id)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Reset profile user.
	 */
	public static function reset_user($input) {
		// sanitize daftar tipe
		if (isset($input['tipe'])) {
			$tipe = (in_array($input['tipe'], User::daftar_tipe())) ? $input['tipe'] : 1;
		} else {
			$tipe = 1;
		}

		// update profile user
		User::update($input['id'], array(
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'fullname' => $input['fullname'],
			'tipe' => $tipe
		));

		// user logged in dengan username dan password yang baru tanpa harus login ulang
		Auth::login(Auth::user()->id);

		// message sukses
		$msg = $input['fullname'] . ' telah diupdate ke dalam daftar pengguna aplikasi ini.';
		
		return $msg;
	}

	/**
	 * Store daftar tipe user dalam array.
	 * 'user' atau 'admin' digunakan untuk view, sementara 1 atau 9 untuk database
	 */
	public static function daftar_tipe() {
		$daftar = array(
			'user' => 1,
			'admin' => 9,
			'guest' => 99,
		);

		return $daftar;
	}

	/**
	 * Untuk keperluan form select, array daftar tipe harus dibalik.
	 */
	public static function reversed_daftar_tipe() {
		$daftar = User::daftar_tipe();

		foreach ($daftar as $key => $value) {
			$reversed[$value] = $key;
		}

		return $reversed;
	}

	/**
	 * Truncate full name yang terlalu panjang.
	 */
	public static function filtered_fullname() {
		if (Auth::check()) {
			$fullname = Auth::user()->fullname;
			$fullname_length = strlen($fullname);

			// shorter for annoying name :)
			if (substr($fullname, 0, 10) == 'WWWWWWWWWW') {
				$max_length = 9;					
			} else {
				$max_length = 15;					
			}

			if ($fullname_length > $max_length) {
				$fullname = substr($fullname, 0, $max_length) . '...';
			}

			return $fullname;
		}
	}

	/**
	 * Rules alternatif untuk update/reset profile user.
	 */
	public static function build_rules_alt() {
		$input_id = Input::get('id');
		$my_id = isset($input_id) ? $input_id : Auth::user()->id;

		$rules = array(
			'username' => strtolower('required|alpha_num|unique:users,username,' . $my_id),
			'fullname' => 'required',
			'password' => 'required|confirmed|min:5',
		);

		return $rules;
	}

	/**
	 * Checking untuk guest mode agar tidak menampilkan menu partial view tertentu.
	 */
	public static function is_user_allowed() {
		$daftar_tipe = User::daftar_tipe();
		$is_auth = Auth::user();

		if (isset($is_auth)) {
			if (($is_auth->tipe == $daftar_tipe['user']) || ($is_auth->tipe == $daftar_tipe['admin'])) {
				return true;
			} else if ($is_auth->tipe = $daftar_tipe['guest']) {
				return false;
			}
		} else {
			return false;		
		}
	}

}