<?php

class Konfigurasi extends Eloquent {
	public static $table = 'konfigurasi';

	/**
	 * Rules standar untuk update konfigurasi.
	 */
	public static $rules = array(
		"nama_kpp"=>"required",
		"nama_seksi"=>"required",
		"kode_surat"=>"required",
		"tahun_surat"=> "required|integer",
		"jumlah_baris_surat_masuk"=>"required|integer|min:1",
		"jumlah_baris_surat_keluar"=>"required|integer|min:1",
		"jumlah_baris_pencarian_surat"=>"required|integer|min:1"
	);

	/**
	 * Validate input.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Menyimpan setiap input form ke rownya masing-masing.
	 */
	public static function update_konfigurasi($input) {
		// update setiap value konfigurasi
		Konfigurasi::update(1, array('config_value'=>$input['nama_kpp']));
		Konfigurasi::update(2, array('config_value'=>$input['nama_seksi']));
		Konfigurasi::update(3, array('config_value'=>$input['kode_surat']));
		Konfigurasi::update(5, array('config_value'=>$input['jumlah_baris_surat_masuk']));
		Konfigurasi::update(6, array('config_value'=>$input['jumlah_baris_surat_keluar']));
		Konfigurasi::update(7, array('config_value'=>$input['jumlah_baris_pencarian_surat']));
		Konfigurasi::update(8, array('config_value'=>$input['tampilkan_nomor_agenda']));

		// rules untuk konfigurasi tahun agar tidak mengacaukan pengurutan nomor
		$max_tahun_used = Suratkeluar::max('tahun');

		$msg_warning = NULL;
		if ($input['tahun_surat'] < $max_tahun_used) {
			// perubahan tahun tidak disimpan, return pesan warning
			$msg_warning = 'Perubahan tahun tidak dapat disimpan. ' . 
				'Untuk menggunakan kembali tahun: ' . $input['tahun_surat'] . 
				', silakan undo/batalkan semua Surat Keluar (<em>sangat tidak disarankan</em>) ' .
				'yang telah menggunakan tahun: ' . $max_tahun_used . '.';
		} else {
			Konfigurasi::update(4, array('config_value'=>$input['tahun_surat']));
		}

		// membuat message success dan warning ke dalam array
		$add_notes = isset($msg_warning) ? ' Lihat pesan warning!' : '';
		$msg_success = 'Konfigurasi berhasil diupdate.' . $add_notes;
		
		$msg = array();
		$msg['success'] = $msg_success;
		$msg['warning'] = $msg_warning;

		return $msg;
	}

	/**
	 * Info versi aplikasi
	 */
	public static function versi() {
		$versi = '0.9.6.20151126';

		return $versi;
	}
}