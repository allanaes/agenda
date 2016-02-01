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


	// pengawasan SELESAI --DONE
	public static function index_aktivitas_selesai() {
		$cfg_jmlbaris = Konfigurasi::find(7)->config_value;
		
		$kriteria = array('SELESAI');
		
		$aktivitas = Suratmasukaktivitas::order_by('id', 'desc')
			->where_in('proses', $kriteria)
			->paginate($cfg_jmlbaris);
		
		return $aktivitas;
	}

	// pengawasan PROSES / BARU --BELUM
	public static function index_aktivitas_proses() {
		$cfg_jmlbaris = Konfigurasi::find(7)->config_value;

		$kriteria = array('BARU', 'PROSES');
		
		$aktivitas = Suratmasukaktivitas::order_by('id', 'desc')
			->where_in('proses', $kriteria)
			->paginate($cfg_jmlbaris);
		
		return $aktivitas;
	}

	// parse data Surat Masuk untuk setiap record aktivitas
	public static function data_aktivitas($s) {
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

			foreach ($s->results as $row) {
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
				$id_aktivitas = $row->id;

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
		$id_aktivitas = Suratmasukaktivitas::where('id_surat_masuk', '=', $id_surat_masuk)->max('id');
		$input['id_aktivitas'] = $id_aktivitas;

		$validation = Suratmasukpengawasan::validate($input);

		if ($validation->fails()) {
			return Redirect::to('suratmasuk/' . $id_surat_masuk . '/aktivitas')->with_errors($validation)->with_input();
		} else {
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