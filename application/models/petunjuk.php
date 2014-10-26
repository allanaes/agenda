<?php

class Petunjuk extends Eloquent {
	public static $table = 'petunjuk';

	/**
	 * Rules untuk add dan update petunjuk.
	 */
	public static $rules = array(
		'petunjuk'=>'required'
	);

	/**
	 * Validate input.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Menambahkan record baru ke dalam daftar petunjuk.
	 */
	public static function add_petunjuk($input) {
		$petunjuk = $input['petunjuk'];

		Petunjuk::create(array(
			'petunjuk'=>$petunjuk
		));

		// membuat message success
		$msg = 'Petunjuk telah ditambahkan: "' . $petunjuk . '".';

		return $msg;
	}

	/**
	 * Tidak diperbolehkan mengedit atau menghapus record yg sudah tersimpan
	 * agar integrasi surat tidak kacau, kecuali untuk record terakhir saja.
	 */
	public static function update_petunjuk($input) {
		$petunjuk = $input['petunjuk'];

		// 'id' terakhir tidak diambil dari form, tetapi langsung dari query
		$id = Petunjuk::order_by('id', 'desc')->only('id');

		Petunjuk::update($id, array(
			'petunjuk'=>$petunjuk
		));

		// membuat message success
		$msg = 'Petunjuk: "' . $petunjuk . '" telah diupdate ke dalam daftar.';

		return $msg;
	}
	
}