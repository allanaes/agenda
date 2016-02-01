<?php

class Suratmasuk extends Eloquent {
	public static $table = 'surat_masuk';

	/**
	 * Rules untuk create surat.
	 */
	public static $rules = array(
		'tgl_diterima' => 'required|date_format:d/m/Y',
		'nomor_surat' => 'required',
		'tgl_surat' => 'required|date_format:d/m/Y',
		'pengirim' => 'required',
		'hal' => 'required',
		'copy' => 'integer|min:0|max:99'
	);

	/**
	 * Rules untuk update surat.
	 */
	public static $rules_alt = array(
		'tgl_diterima' => 'required|date_format:d/m/Y',
		'nomor_surat' => 'required',
		'tgl_surat' => 'required|date_format:d/m/Y',
		'pengirim' => 'required',
		'hal' => 'required',
		'copy' => 'integer|min:0|max:99'
	);



	/**
	 * Validate input untuk create.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Validate input untuk update.
	 */
	public static function validate_alt($data) {
		return Validator::make($data, static::$rules_alt);
	}

	/**
	 * Return daftar surat masuk dan data lain untuk keperluan form.
	 * Karena digunakan oleh dua view (suratmasuk.index dan beranda), sedangkan
	 * pagination hanya digunakan pada view suratmasuk.index, maka disertakan opsi
	 * untuk melock pagination untuk view beranda.
	 */
	public static function index_surat($pagination_locked = false) {
		$cfg_jmlbaris_suratmasuk = Konfigurasi::find(5)->config_value;

		// gunakan limit apabila pagination dikunci, misal untuk display table di beranda
		if ($pagination_locked) {
			$sm = Suratmasuk::order_by('id', 'desc')->take($cfg_jmlbaris_suratmasuk)->get();
		} else {
			$sm = Suratmasuk::order_by('id', 'desc')->paginate($cfg_jmlbaris_suratmasuk);

			// bind data lain
			$sm->nomor_agenda_seksi = Suratmasuk::generate_nomor_agenda_seksi();
			$sm->nomor_agenda_sekre = Suratmasuk::generate_nomor_agenda_sekre();
			$sm->daftar_disposisi = Disposisi::get();
			$sm->daftar_petunjuk = Petunjuk::get();
			$sm->daftar_sifat = Suratmasuk::daftar_sifat();
		}

		return $sm;
	}

	/**
	 * Merekam surat masuk.
	 */
	public static function create_surat($input) {
		// #1 ubah input array ke string dengan pembatas koma
		// (lihat comment di function input_array_to_string())
		Suratmasuk::input_array_to_string($input);

		// #2 retrieve nomor_agenda_seksi langsung, tidak menggunakan input form
		// karena di form didisable dan valuenya tidak diteruskan ke POST
		$input['nomor_agenda_seksi'] = Suratmasuk::generate_nomor_agenda_seksi();

		// #2.0 khusus untuk Sekre, nomor agenda akan digenerate karena pada
		// input form didisable / hanya view
		if (Konfigurasi::find(9)->config_value == 1) {
			$input['nomor_agenda_sekre'] = Suratmasuk::generate_nomor_agenda_sekre();
		}

		// #2.1 retrieve tahun buku pembuatan agenda (berfungsi untuk reset nomor agenda
		// apabila terjadi perubahan tahun buku)
		$input['tahun_buku'] = Konfigurasi::find(4)->config_value;

		// #2.2 record username perekam
		$input['perekam'] = Auth::user()->username;

		// #2.3 record username diupdate
		$input['diupdate'] = Auth::user()->username;

		// #3 hapus csrf_token dari input array, agar tidak dimasukkan ke database
		//unset($input['csrf_token']);
		Suratmasuk::clean_input($input);

		// #4 rekam langsung input array setelah data dibersihkan
		Suratmasuk::create($input);

		// mereturn message
		$msg = "Surat Masuk dengan nomor: " . $input['nomor_surat'] . 
			', dari ' . $input['pengirim'] . ' berhasil direkam.';

		return $msg; 
	}

	/**
	 * Function update surat.
	 */
	public static function update_surat($id) {
		$input = Input::all();
		
		// #1 ubah input array ke string dengan pembatas koma
		Suratmasuk::input_array_to_string($input);


		// #2 retrieve nomor_agenda_seksi langsung, tidak menggunakan input form
		// karena di form didisable dan valuenya tidak diteruskan ke POST
		$input['nomor_agenda_seksi'] = Suratmasuk::find($input['id'])->nomor_agenda_seksi;

		if (Konfigurasi::find(9)->config_value != 1) {
			$input['nomor_agenda_sekre'] = Suratmasuk::find($input['id'])->nomor_agenda_sekre;
		}

		// #2.1 rekam nama user pengupdate
		$input['diupdate'] = Auth::user()->username;

		// #3 hapus csrf_token dari input array, agar tidak dimasukkan ke database
		// unset($input['csrf_token']) dll.
		Suratmasuk::clean_input($input);

		// #4 rekam langsung input array setelah data dibersihkan
		Suratmasuk::update($id, $input);

		// mereturn message
		$msg = "Surat Masuk dengan nomor: " . $input['nomor_surat'] . 
			', dari ' . $input['pengirim'] . ' berhasil diupdate.';

		return $msg; 
	}

	/**
	 * View detail surat: jika id surat yg diinput (secara manual) tidak ada
	 * maka return false. Value digunakan untuk view.
	 */
	public static function view_surat($id) {
		$f = Suratmasuk::find($id);
		
		if (is_object($f)) {
			$f->daftar_disposisi = Disposisi::get();
			$f->daftar_petunjuk = Petunjuk::get();
			$f->nama_kpp = Konfigurasi::find(1)->config_value;
			$f->nama_seksi = Konfigurasi::find(2)->config_value;
			$f->daftar_sifat = Suratmasuk::daftar_sifat();

			// convert beberapa daftar dari text menjadi array
			Suratmasuk::string_to_input_array($f);

			return $f;
		} else {
			return 0;
		}
	}

	/**
	 * Edit surat: jika id surat yg diinput (secara manual) tidak ada
	 * maka return false. Value digunakan untuk form.
	 */
	public static function edit_surat($id) {
		$f = Suratmasuk::find($id);
		
		if (is_object($f)) {
			$f->daftar_disposisi = Disposisi::get();
			$f->daftar_petunjuk = Petunjuk::get();
			$f->daftar_sifat = Suratmasuk::daftar_sifat();

			// convert beberapa daftar dari text menjadi array
			Suratmasuk::string_to_input_array($f);

			return $f;
		} else {
			return 0;
		}
	}

	/**
	 * Membuat query untuk search surat, binding data lain untuk keperluan form search.
	 */
	public static function search_surat($input) {
		$limit = ($input['limit'] > 0) ? ceil($input['limit']) : Konfigurasi::find(7)->config_value;

		// Mengingat keterbatasan query, maka dibedakan menjadi dua query untuk search surat,
		// apabila user memfilter datar menggunakan field id_start atw id_end
		// maka akan dilimit hanya 1000 list saja.
		// Jika kosong, maka akan full.
		if (empty($input['id_start']) && empty($input['id_end'])) {
			$sm = Suratmasuk::order_by('id', $input['sort_order'])
				->where('nomor_agenda_seksi', 'LIKE', '%' . $input['nomor_agenda_seksi'] . '%')
				->where('tgl_diterima', 'LIKE', '%' . $input['tgl_diterima'] . '%')
				->where('nomor_agenda_sekre', 'LIKE', '%' . $input['nomor_agenda_sekre'] . '%')
				->where('nomor_surat', 'LIKE', '%' . $input['nomor_surat'] . '%')
				->where('tgl_surat', 'LIKE', '%' . $input['tgl_surat'] . '%')
				->where('pengirim', 'LIKE', '%' . $input['pengirim'] . '%')
				->where('hal', 'LIKE', '%' . $input['hal'] . '%')
				->where('disposisi', 'LIKE', '%' . $input['disposisi'] . '%')
				->where('lain_lain', 'LIKE', '%' . $input['lain_lain'] . '%')
				->paginate($limit);
		} else {
			$id_between = Suratmasuk::get_id_between($input);

			$sm = Suratmasuk::order_by('id', $input['sort_order'])
				->where('nomor_agenda_seksi', 'LIKE', '%' . $input['nomor_agenda_seksi'] . '%')
				->where('tgl_diterima', 'LIKE', '%' . $input['tgl_diterima'] . '%')
				->where('nomor_agenda_sekre', 'LIKE', '%' . $input['nomor_agenda_sekre'] . '%')
				->where('nomor_surat', 'LIKE', '%' . $input['nomor_surat'] . '%')
				->where('tgl_surat', 'LIKE', '%' . $input['tgl_surat'] . '%')
				->where('pengirim', 'LIKE', '%' . $input['pengirim'] . '%')
				->where('hal', 'LIKE', '%' . $input['hal'] . '%')
				->where('disposisi', 'LIKE', '%' . $input['disposisi'] . '%')
				->where('lain_lain', 'LIKE', '%' . $input['lain_lain'] . '%')
				->where_in('id', $id_between)
				->paginate($limit);
		}

		// bind data lain
		$sm->daftar_disposisi = Disposisi::get();
		$sm->input = $input;

		// append filter ke pagination
		$filter = Suratmasuk::pagination_filter($input);
		$sm->appends($filter);

		return $sm;
	}

	/***************************************************************************/
	/************************ START HELPER FUNCTIONS ***************************/

	/**
	 * Return array daftar sifat
	 */
	public static function daftar_sifat() {
		$daftar = array(
		 1 => 'Kilat',
		 2 => 'Sangat Segera',
		 3 => 'Segera',
		 4 => 'Biasa'
		);
		return $daftar;
	}

	/**
	 * Convert input array ke string.
	 */
	public static function input_array_to_string(&$input) {
		// ubah beberapa input array ke string dengan pembatas koma, jika diset
		if (isset($input['disposisi'])) {
			$input['disposisi'] = implode(',', $input['disposisi']);
		}

		if (isset($input['petunjuk'])) {
			$input['petunjuk'] = implode(',', $input['petunjuk']);
		}

		if (isset($input['sifat'])) {
			$input['sifat'] = implode(',', $input['sifat']);
		}
	}

	/**
	 * Convert string ke input array. Modifikasi langsung input disposisi,
	 * petunjuk, dan sifat.
	 */
	public static function string_to_input_array(&$f) {
		// convert beberapa daftar dari text menjadi array, default array kosong
		$f->disposisi = (!empty($f->disposisi)) ? explode(',', $f->disposisi) : array();
		$f->petunjuk = (!empty($f->petunjuk)) ? explode(',', $f->petunjuk) : array();
		$f->sifat = (!empty($f->sifat)) ? explode(',', $f->sifat) : array();
	}

	/**
	 * Clean input sebelum direkam ke database.
	 */
	public static function clean_input(&$input) {
		// daftar field yang diperbolehkan
		$accepted_input = array(
			'id',
			'nomor_agenda_seksi',
			'tgl_diterima',
			'nomor_agenda_sekre',
			'nomor_surat',
			'tgl_surat',
			'pengirim',
			'hal',
			'disposisi',
			'lain_lain',
			'sifat',
			'petunjuk',
			'copy',
			'perekam',
			'diupdate',
			'catatan',
			'tahun_buku'
		);

		// unset variable lain di luar daftar $accepted_input
		foreach ($input as $key => $value) {
			if (!in_array($key, $accepted_input)) {
				unset($input[$key]);
			}
		}

		// set ke blank jika checkbox tidak diisi
		if (!isset($input['sifat'])) $input['sifat'] = '';
		if (!isset($input['petunjuk'])) $input['petunjuk'] = '';
		if (!isset($input['disposisi'])) $input['disposisi'] = '';
	}

	/**
	 * Set input array ke valuenya, mencegah index tidak ditemukan.
	 */
	public static function lengkapi_array($i) {
		$input = array();

		$input['nomor_agenda_seksi'] = isset($i['nomor_agenda_seksi']) ? $i['nomor_agenda_seksi'] : '';
		$input['tgl_diterima'] = isset($i['tgl_diterima']) ? $i['tgl_diterima'] : '';
		$input['nomor_agenda_sekre'] = isset($i['nomor_agenda_sekre']) ? $i['nomor_agenda_sekre'] : '';
		$input['nomor_surat'] = isset($i['nomor_surat']) ? $i['nomor_surat'] : '';
		$input['tgl_surat'] = isset($i['tgl_surat']) ? $i['tgl_surat'] : '';
		$input['pengirim'] = isset($i['pengirim']) ? $i['pengirim'] : '';
		$input['hal'] = isset($i['hal']) ? $i['hal'] : '';
		$input['disposisi'] = isset($i['disposisi']) ? $i['disposisi'] : '';
		$input['lain_lain'] = isset($i['lain_lain']) ? $i['lain_lain'] : '';
		$input['limit'] = isset($i['limit']) ? $i['limit'] : '';
		$input['page'] = isset($i['page']) ? $i['page'] : 1;
		$input['id_start'] = isset($i['id_start']) ? $i['id_start'] : '';
		$input['id_end'] = isset($i['id_end']) ? $i['id_end'] : '';
		
		// sanitasi sort order
		$input['sort_order'] = isset($i['sort_order']) ? $i['sort_order'] : 'desc';
		$so = $input['sort_order'];
		$input['sort_order'] = ($so == 'asc' || $so == 'desc') ? $so : 'desc';

		return $input;
	}

	/**
	 * Convert tampilan daftar disposisi dari id ke nama.
	 * -TIDAK DIGUNAKAN-
	 */
	public static function disposisi_id_to_name($id_string) {
		$daftar = Disposisi::get();
		$id_array = explode(',', $id_string);
		$nama_array = array();

		foreach ($daftar as $row) {
			if (in_array($row->id, $id_array)) {
				array_push($nama_array, $row->nama);
			}
		}

		$nama_results = implode(', ', $nama_array);

		return $nama_results;
	}

	/**
	 * Return input dari form untuk filter pagination.
	 * unset 'page' dari input karena digenerate oleh Laravel pagination
	 */
	public static function pagination_filter($input) {
		// unset item 'page' dari array
		unset($input['page']);

		return $input;
	}

	/**
	 * Generate nomor agenda seksi, dalam hal terjadi pergantian tahun
	 * maka nomor agenda direset ke 1.
	 */
	public static function generate_nomor_agenda_seksi() {
		$cfg_tahun_surat = Konfigurasi::find(4)->config_value;
		$last_surat_tahun = DB::table('surat_keluar')->order_by('id', 'desc')->only('tahun');
		$last_number = Suratmasuk::order_by('id', 'desc')
										->where('tahun_buku', '=', Konfigurasi::find(4)->config_value)
										->only('nomor_agenda_seksi');

		if (empty($last_number)) {
			$now_number = 1;
		} else {
			$now_number = $last_number + 1;			
		}

		return $now_number;
	}

	/**
	 * Generate nomor agenda sekre sesuai penomoran surat masuk SIDJP.
	 */
	public static function generate_nomor_agenda_sekre() {
		$cfg_tahun_surat = Konfigurasi::find(4)->config_value;
		$cfg_kode_agenda_sekre = Konfigurasi::find(10)->config_value;

		$sekre_tahun = substr($cfg_tahun_surat, 2, 2);
		$sekre_bulan = date('n');

		$sekre_bulan_tahun = Suratmasuk::romanic_number($sekre_bulan) . '/' . $sekre_tahun;

		$sekre_kode_agenda = '/' . $sekre_bulan_tahun . $cfg_kode_agenda_sekre;

		// fleksibilitas untuk penomorannya di mana kode agenda sekre hanya opsional saja
		$count_current = Suratmasuk::where('nomor_agenda_sekre', 'LIKE', '%' . $sekre_bulan_tahun . '%')->count();

		$now_number = ($count_current + 1) . $sekre_kode_agenda;

		return $now_number;
	}

	/**
	 * Konversi bulan arabic ke roman
	 * ref: http://stackoverflow.com/questions/14994941/numbers-to-roman-numbers-with-php
	 */
	public static function romanic_number($integer, $upcase = true) { 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) 
		{ 
			foreach($table as $rom=>$arb) 
			{ 
				if($integer >= $arb) 
				{ 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	} 

	/**
	 * Mengumpulkan daftar id yang akan dicari. Hasilnya berupa array yang dapat
	 * digunakan untuk membuat query where_in().
	 */
	public static function get_id_between($input) {

		// min and max id dalam database
		$min_id = Suratmasuk::min('id');
		$max_id = Suratmasuk::max('id');

		// membatasi range id
		if (($max_id - $min_id) >= 1000) {
			$min_id = $max_id - 1000;
		}

		// clean id_start
		# clean dalam hal input kosong atau lebih rendah dari min_id
		$id_start = (!empty($input['id_start']) && ($input['id_start'] >= $min_id)) ? $input['id_start']: $min_id;
		# clean dalam hal input lebih tinggi dari max_id
		$id_start = ($id_start >= $max_id) ? $max_id : $id_start;

		// clean id_end
		# clean dalam hal input kosong atau lebih tinggi dari min_id
		$id_end = (!empty($input['id_end']) && ($input['id_end'] <= $max_id)) ? $input['id_end'] : $max_id;
		# clean dalam hal input lebih rendah dari id_start
		$id_end = ($id_end <= $id_start) ? $id_start : $id_end;

		$collected_id = range($id_start, $id_end);

		// return array collected id
		return $collected_id;
	}
}

