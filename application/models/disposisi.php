<?php

class Disposisi extends Eloquent {
	public static $table = 'disposisi';	

	/**
	 * Rules standar untuk menambah daftar disposisi.
	 */
	public static $rules = array(
		'nama'=>'required',
		'nip'=>'required|numeric|unique:disposisi,nip'
	);

	/**
	 * Validate input dengan rules standar.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Validate input dengan rules alternatif.
	 */
	public static function validate_alt($data) {
		return Validator::make($data, Disposisi::build_rules());
	}

	/**
	 * Menambahkan record baru ke dalam daftar disposisi.
	 */
	public static function add_disposisi($input) {
		$nama = $input['nama'];
		$nip = $input['nip'];
		$aktif = true;

		// insert ke database
		Disposisi::create(array(
			'nama'=>$nama,
			'nip'=>$nip,
			'aktif'=>$aktif
		));

		// membuat message success
		$msg = $nama . ' telah ditambahkan ke dalam daftar disposisi.';

		return $msg;
	}

	/**
	 * Tidak diperbolehkan mengedit atau menghapus record yg sudah tersimpan
	 * kecuali untuk record terakhir saja.
	 */
	public static function update_disposisi($input) {
		$nama = $input['nama'];
		$nip = $input['nip'];

		// 'id' terakhir tidak diambil dari form, tetapi langsung dari query
		$id = Disposisi::order_by('id', 'desc')->only('id');

		// insert ke database
		Disposisi::update($id, array(
			'nama'=>$nama,
			'nip'=>$nip
		));

		// membuat message success
		$msg = $nama . ' telah diupdate ke dalam daftar disposisi.';

		return $msg;
	}
	
	/**
	 * Toggle status aktif.
	 */
	public static function toggle_disposisi($id) {
		// get current status
		$status = Disposisi::find($id)->aktif;
		// revert status
		$status = !$status;
		
		// update record
		Disposisi::update($id, array(
			'aktif'=>$status
		));

		// membuat message success
		$status_msg =  ($status) ? 'AKTIF' : 'NONAKTIF';
		$msg = Disposisi::find($id)->nama . ' telah diupdate menjadi: ' . $status_msg;

		return $msg;
	}

	/**
	 * -HELPER-
	 * Build array for rules.
	 */
	public static function build_rules() {
		// 'id' terakhir tidak diambil dari form, tetapi langsung dari query
		$id = Disposisi::order_by('id', 'desc')->only('id');

		$rules = array(
			'nama'=>'required',
			'nip'=> strtolower('required|numeric|unique:disposisi,nip,' . $id)
		);

		return $rules;
	}

	/**
	 * -HELPER-
	 * Cek apakah masih dapat menambahkan daftar baru.
	 */
	public static function check_if_can() {
		$max_entries = 16;
		$available_entries = $max_entries - 1;
		$disposisi_entries_aktif = Disposisi::where('aktif', '=', 1)->count();
		
		// tidak dapat menambah daftar baru jika jumlah yang aktif mencapai batas maksimum
		// atau toggle status aktif dari nonaktif ke aktif
		if ($disposisi_entries_aktif <= $available_entries) {
			return true;
		}	else {
			return false;
		}
	}
}