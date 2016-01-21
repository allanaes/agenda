<?php

class Suratmasukpengawasan extends Eloquent {
	public static $table = 'surat_masuk_pengawasan';

	/**
	 * Rules untuk add pengawasan.
	 */
	public static $rules = array(
		'id_surat_masuk' => 'required',
		'id_aktivitas' => 'required'
	);

	/**
	 * Validate input untuk create.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Mendapatkan daftar pengawasan surat, hanya saja nanti datanya tidak diviewkan langsung.
	 */
	public static function pengawasan_index() {
		$cfg_jmlbaris = Konfigurasi::find(7)->config_value;

		$s = Suratmasukpengawasan::order_by('id', 'desc')->paginate($cfg_jmlbaris);

		return $s;
	}

	/**
	 * Oleh karena data diambil dari dua tabel yakni tabel surat_masuk dan surat_masuk_aktivitas,
	 * agar lebih efisien dan tidak membebani server database, maka data di-query-kan sekali saja
	 * kemudian diiterasi secara manual.
	 */
	public static function data_pengawasan($s) {

		// fetch daftar id surat masuk dan id aktivitas
		$array_id_surat_masuk = array();

		// inisiasi variabel
		$data_pengawasan_surat = array();		

		if ($s->total > 0) {
			foreach ($s->results as $row) {
				array_push($array_id_surat_masuk, $row->id_surat_masuk);
			}

			$array_id_aktivitas = array();
			foreach ($s->results as $row) {
				array_push($array_id_aktivitas, $row->id_aktivitas);
			}

			// querykan sekaligus id-nya
			$_surat_masuk = Suratmasuk::where_in('id', $array_id_surat_masuk)->get();
			$_aktivitas = Suratmasukaktivitas::where_in('id', $array_id_aktivitas)->get();

			// convert object data surat masuk ke array
			$data_surat_masuk = array();

			foreach ($_surat_masuk as $row) {
				$item = array(
					'nomor_surat' => $row->nomor_surat,
					'pengirim' => $row->pengirim,
					'tgl_surat' => $row->tgl_surat,
					'hal' => $row->hal
				);

				$data_surat_masuk[$row->id] = $item;
			}

			// convert object data aktivitas ke array
			$data_aktivitas = array();

			foreach ($_aktivitas as $row) {
				$item = array(
					'pic' => $row->pic,
					'aktivitas' => $row->aktivitas,
					'tgl_aktivitas' => $row->tgl_aktivitas,
					'tgl_jatuh_tempo' => $row->tgl_jatuh_tempo,
					'proses' => $row->proses
				);

				$data_aktivitas[$row->id] = $item;
			}

			// building data pengawasan surat
			foreach ($s->results as $row) {
				$id_surat_masuk = $row->id_surat_masuk;
				$id_aktivitas = $row->id_aktivitas;

				$item = array(
					'id' => $row->id,
					'id_surat_masuk' => $id_surat_masuk,
					'id_aktivitas' => $id_aktivitas,
					'nomor_surat' => $data_surat_masuk[$id_surat_masuk]['nomor_surat'],
					'pengirim' => $data_surat_masuk[$id_surat_masuk]['pengirim'],
					'tgl_surat' => $data_surat_masuk[$id_surat_masuk]['tgl_surat'],
					'hal' => $data_surat_masuk[$id_surat_masuk]['hal'],
					'pic' => $data_aktivitas[$id_aktivitas]['pic'],
					'aktivitas' => $data_aktivitas[$id_aktivitas]['aktivitas'],
					'tgl_aktivitas' => $data_aktivitas[$id_aktivitas]['tgl_aktivitas'],
					'tgl_jatuh_tempo' => $data_aktivitas[$id_aktivitas]['tgl_jatuh_tempo'],
					'proses' => $data_aktivitas[$id_aktivitas]['proses'],
					);
				array_push($data_pengawasan_surat, $item);

			}
		}
		
		// return hasilnya
		return $data_pengawasan_surat;
	}



	/**
	 * Masukan surat masuk ke tabel pengawasan.
	 */
	public static function pengawasan_create($id_surat_masuk, $id_aktivitas) {

		// Tambahkan id surat masuk jika belum
		$cek_id_surat_masuk = Suratmasukpengawasan::where('id_surat_masuk', '=', $id_surat_masuk)->count();

		if ($cek_id_surat_masuk > 0) {
			$id = Suratmasukpengawasan::where('id_surat_masuk', '=', $id_surat_masuk)->only('id');			

			Suratmasukpengawasan::update($id, array(
				'id_surat_masuk' => $id_surat_masuk,
				'id_aktivitas' => $id_aktivitas
			));
		} else {
			Suratmasukpengawasan::create(array(
				'id_surat_masuk' => $id_surat_masuk,
				'id_aktivitas' => $id_aktivitas
			));
		}
	}

	/**
	 * Custom warna text untuk keterangan proses pada aktivitas.
	 */
	public static function warna_teks($teks) {
		$proses = Suratmasukaktivitas::daftar_proses();

		switch ($teks) {
			case $proses['BARU']:
				$t = '<strong><span class="alert-success">' . $teks . '</span></strong>';
				return $t;
				break;
			
			case $proses['PROSES']:
				$t = '<strong><span class="alert-error">' . $teks . '</span></strong>';
				return $t;
				break;
			
			default:
				$t = '<span class="alert-info">' . $teks . '</span>';
				return $t;
				break;
		}
	}
}