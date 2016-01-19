<?php

class Suratmasukaktivitas extends Eloquent {
	public static $table = 'surat_masuk_aktivitas';

	/**
	 * Rules untuk add aktivitas.
	 */
	public static $rules = array(
		'id_surat_masuk' => 'required',
		'tgl_aktivitas' => 'required|date_format:d/m/Y',
		'aktivitas' => 'required',
		'pic' => 'required',
		'proses' => 'required'
	);

	/**
	 * Validate input untuk create.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * View aktivitas: jika id surat yg diinput (secara manual) tidak ada
	 * maka return false.
	 */
	public static function aktivitas_surat($id) {
		$f = Suratmasuk::find($id);
		
		// check validitas id surat masuk, proses jika valid
		if (is_object($f)) {
			//print_r("ada");			
			return $f;

		} else {
			//print_r("id_surat_masuk tidak valid");
			return 0;
		}
	}

	/**
	 * Masukan surat masuk ke tabel aktivitas dan add atau update tabel pengawasan.
	 */
	public static function aktivitas_create($input) {
		$i = $input;

		$id_surat_masuk = $i['id_surat_masuk'];
		$tgl_aktivitas = $i['tgl_aktivitas'];
		$aktivitas = $i['aktivitas'];
		$pic = $i['pic'];
		$proses = $i['proses'];

		// kolom tgl_jatuh_tempo nullable
		$tgl_jatuh_tempo = isset($i['tgl_jatuh_tempo']) ? $i['tgl_jatuh_tempo'] : null;
		
		// -Eloquent query-
		// "diupdate" -> fitur update aktivitas tidak disediakan, tetapi dibuat kolomnya
		// agar suatu saat ditambahkan tidak perlu migration ulang
		Suratmasukaktivitas::create(array(
			'id_surat_masuk' => $id_surat_masuk,
			'tgl_aktivitas' => $tgl_aktivitas,
			'aktivitas' => $aktivitas,
			'pic' => $pic,
			'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
			'proses' => $proses,
			'perekam' => Auth::user()->username,
			'diupdate' => Auth::user()->username
		));

		// validate untuk update / create record pengawasan
		$validation = Suratmasukpengawasan::validate($input);

		if ($validation->fails()) {
			return Redirect::to('suratmasuk/' . $id_surat_masuk . '/aktivitas')->with_errors($validation)->with_input();
		} else {
			$id_aktivitas = Suratmasukaktivitas::where('id_surat_masuk', '=', $id_surat_masuk)->max('id');

			Suratmasukpengawasan::pengawasan_create($id_surat_masuk, $id_aktivitas);

			$msg = 'Berhasil ditambahkan aktivitas baru untuk ' . $pic . '.';
		}


		return $msg;
	}

	/**
	 * Array untuk status tahapan proses pada input aktivitas surat.
	 */
	public static function daftar_proses() {
		$a = array('BARU'=>'BARU', 'PROSES'=>'PROSES', 'SELESAI'=>'SELESAI', 'BATAL'=>'BATAL', 'ARSIP'=>'ARSIP');

		return $a;
	}

}