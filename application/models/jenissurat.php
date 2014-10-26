<?php

class Jenissurat extends Eloquent {
	public static $table = 'jenis_surat';

	/**
	 * Rules untuk add dan update surat.
	 */
	public static $rules = array(
		'jenis_surat' => 'required|unique:jenis_surat,jenis_surat'
	);

	/**
	 * Validate input.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Menambahkan record baru ke dalam daftar jenis surat.
	 */
	public static function add_jenissurat($input) {
		$jenis_surat = $input['jenis_surat'];

		Jenissurat::create(array(
			'jenis_surat'=>$jenis_surat
		));

		// membuat message success
		$msg = 'Jenis surat ' . $jenis_surat . ' telah ditambahkan ke dalam daftar jenis surat.';

		return $msg;
	}

	/**
	 * Tidak diperbolehkan mengedit atau menghapus record yg sudah tersimpan
	 * kecuali untuk record terakhir saja.
	 */
	public static function update_jenissurat($input) {
		$jenis_surat = $input['jenis_surat'];

		// 'id' terakhir tidak diambil dari form, tetapi langsung dari query
		$id = Jenissurat::order_by('id', 'desc')->only('id');

		Jenissurat::update($id, array(
			'jenis_surat'=>$jenis_surat
		));

		// membuat message success
		$msg = 'Jenis surat ' . $jenis_surat . ' telah diupdate ke dalam daftar jenis surat.';

		return $msg;
	}

	/**
	 * Toggle status jenis surat sehingga hanya yg aktif saja yang akan ditampilkan dalam
	 * dalam form input surat keluar. Untuk form edit surat keluar tetap ditampilkan, tetapi
	 * tidak dapat diedit. Untuk form search surat keluar, ditampilkan dan dapat digunakan.
	 */
	public static function toggle_jenissurat($id) {
		$current_aktif = Jenissurat::find($id)->aktif;
		$jumlah_aktif = Jenissurat::where('aktif', '=', 1)->count();

		if (($jumlah_aktif <= 1) && ($current_aktif == 1)) {
			$warning = 'Daftar jenis surat minimum 1 (satu) entry. Perubahan tidak dapat dilakukan.';

			$msg = array();
			$msg['msg_type'] = 'warning';
			$msg['message'] = $warning;
		} else {
			if ($current_aktif == 1) {
				$aktif_status = 0;

				Jenissurat::update($id, array(
					'aktif'=>$aktif_status
				));
			} else {
				$aktif_status = 1;

				Jenissurat::update($id, array(
					'aktif'=>$aktif_status
				));
			}

			$current_jenis_surat = Jenissurat::find($id)->jenis_surat;
			$message = 'Jenis surat: ' . $current_jenis_surat . ' berhasil diupdate.';

			$msg = array();
			$msg['msg_type'] = 'message';
			$msg['message'] = $message;
		}

		return $msg;
	}
}