<?php

class Suratkeluar extends Eloquent {
	public static $table = 'surat_keluar';

	/**
	 * Rules untuk create surat keluar.
	 */
	public static $rules = array(
		'jenis'=>'required',
		'hal'=>'required',
		'tanggal'=>'required|date_format:d/m/Y',
		'pengirim'=>'required',
		'tujuan'=>'required',
	);

	/**
	 * Rules untuk update surat keluar.
	 */
	public static $rules_update = array(
		'hal'=>'required',
		'tanggal'=>'required|date_format:d/m/Y',
		'pengirim'=>'required',
		'tujuan'=>'required',
	);

	/**
	 * Rules untuk upload file CSV.
	 */
	public static $rules_upload = array(
		'jenis'=>'required',
		'hal'=>'required',
		'tanggal'=>'required|date_format:d/m/Y',
		'pengirim'=>'required',
		'csv_upload'=>'required|mimes:csv,txt',
	);

	/**
	 * Rules untuk import file CSV.
	 */
	public static $rules_import = array(
		'csv_file'=>'required'
	);

	/**
	 * Validate input.
	 */
	public static function validate($data) {
		return Validator::make($data, static::$rules);
	}

	/**
	 * Validate input untuk update.
	 */
	public static function validate_update($data) {
		return Validator::make($data, static::$rules_update);
	}

	/**
	 * Validate input untuk upload.
	 */
	public static function validate_upload($data) {
		return Validator::make($data, static::$rules_upload);
	}

	/**
	 * Validate input untuk import.
	 */
	public static function validate_import($data) {
		return Validator::make($data, static::$rules_import);
	}

	/**
	 * Mengambil record surat dengan urutan descending (terbaru berada paling
	 * awal) plus pagination.
	 * Juga mereturn data lain yang diperlukan baik untuk form ataupun tabel.
	 */
	public static function index_surat($pagination_locked = false) {
		// mengambil value dari table "konfigurasi"
		$cfg_kode_surat = Konfigurasi::find(3)->config_value;
		$cfg_tahun_surat = Konfigurasi::find(4)->config_value;
		$cfg_jmlbaris_suratkeluar = Konfigurasi::find(6)->config_value;

		// Menampilkan daftar surat terakhir (order DESC) dengan pagination
		$filter = Input::get('filter');		

		// gunakan limit apabila pagination dikunci, misal untuk display table di beranda
		if ($pagination_locked) {
			$sk = Suratkeluar::order_by('id', 'desc')
				->take($cfg_jmlbaris_suratkeluar)			
				->get();
		} else {
			$sk = Suratkeluar::where('jenis_surat', 'LIKE', Suratkeluar::clean_id_jenis($filter))
				->order_by('id', 'desc')
				->paginate($cfg_jmlbaris_suratkeluar);
	
			// last surat
			$last_id = DB::table('surat_keluar')->order_by('id', 'desc')->only('id');

			// bind data lainnya
			$sk->last_surat = Suratkeluar::find($last_id);
			$sk->filter = $filter;
			$sk->daftar_disposisi = Disposisi::order_by('nama')->get();
			$sk->daftar_jenis = Jenissurat::order_by('jenis_surat')->get();
			$sk->kode_surat = $cfg_kode_surat;
			$sk->tahun_surat = $cfg_tahun_surat;
		}

		return $sk;
	}

	/**
	 * Merekam surat keluar baru dengan data yang diambil dari form dan nomor urut
	 * yang digenerate otomatis.
	 * Juga, mereturn input sebelumnya sebagai placeholder form untuk memudahkan
	 * penginputan surat keluar sejenis selanjutnya.
	 */
	public static function create_surat($input) {
		$i = $input;
		$cfg_kode_surat = Konfigurasi::find(3)->config_value;
		$cfg_tahun_surat = Konfigurasi::find(4)->config_value;

		$jenis = Jenissurat::find($i['jenis']);
		$pengirim = Disposisi::find($i['pengirim']);
		$tanggal = $i['tanggal'];
		$hal = $i['hal'];
		$tujuan = $i['tujuan'];
		
		// Menentukan urutan selanjutnya untuk jenis surat X, dengan cara
		// "mengambil nomor urut jenis surat X terakhir" untuk nanti diincrement saat direkam ke database
		// -Fluent query-
		// Rulesnya: apabila tahun surat terakhir masih sama dengan tahun konfigurasi
		// surat, maka nomor urut dilanjutkan.
		// Apabila berbeda tahun, maka direset menjadi 1.
		$last_number = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
				->order_by('id', 'desc')
				->only('nomor_urut');

		$last_surat_tahun = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
				->order_by('id', 'desc')
				->only('tahun');

		if ($last_surat_tahun == $cfg_tahun_surat) {
			$now_number = $last_number + 1;
		} else {
			$now_number = 1;
		}

		// -Eloquent query-
		Suratkeluar::create(array(
			'jenis_surat' => $jenis->jenis_surat,
			'nomor_urut' => $now_number,
			'kode_surat' => $cfg_kode_surat,
			'tahun' => $cfg_tahun_surat,
			'tgl_surat' => $tanggal,
			'pengirim' => $pengirim->nama,
			'tujuan' => $tujuan,
			'hal' => $hal,
			'perekam' => Auth::user()->username,
			'diupdate' => Auth::user()->username
		));

		// menyimpan old input untuk memudahkan penginputan surat keluar sejenis berikutnya
		// ** field tujuan dikosongkan
		$jenis_old = $jenis->id;
		$tanggal_old = $tanggal;
		$pengirim_old = $pengirim->id;
		$hal_old = $hal;

		// menyusun nomor surat yg baru saja direkam, untuk penerusan message :)
		$last_id = DB::table('surat_keluar')->order_by('id', 'desc')->only('id');
		$sk = Suratkeluar::find($last_id);
		$nomor_surat = $sk->jenis_surat . $sk->nomor_urut . $sk->kode_surat . $sk->tahun;
		$msg = 'Surat keluar berhasil direkam dengan nomor: ' . $nomor_surat;

		// return array old input dan pesan untuk memudahkan penginputan selanjutnya
		$a = array(
				'message' => $msg,
				'jenis' => $jenis_old,
				'tanggal' => $tanggal_old,
				'pengirim' => $pengirim_old,
				'hal' => $hal_old,
				'msg' => $msg
			);

		return $a;
	}

	// TIDAK DIGUNAKAN, DIGANTI DENGAN upload_create()
	//
	//
	// /**
	//  * Merekam surat keluar baru dengan mass assignment.
	//  */
	// public static function create_surat_massal($input) {
	// 	$i = $input;
	// 	$cfg_kode_surat = Konfigurasi::find(3)->config_value;
	// 	$cfg_tahun_surat = Konfigurasi::find(4)->config_value;

	// 	$jenis = Jenissurat::find($i['jenis']);
	// 	$pengirim = Disposisi::find($i['pengirim']);
	// 	$tanggal = $i['tanggal'];
	// 	$hal = $i['hal'];

	// 	$array_tujuan = array_filter(explode(";", $i['tujuan']));

	// 	$count_sk = 0;

	// 	foreach ($array_tujuan as $key => $tujuan) {
	// 		$tujuan = trim($tujuan);

	// 		if (!empty($tujuan)) {
	// 			// Menentukan urutan selanjutnya untuk jenis surat X, dengan cara
	// 			// "mengambil nomor urut jenis surat X terakhir" untuk nanti diincrement saat direkam ke database
	// 			// -Fluent query-
	// 			// Rulesnya: apabila tahun surat terakhir masih sama dengan tahun konfigurasi
	// 			// surat, maka nomor urut dilanjutkan.
	// 			// Apabila berbeda tahun, maka direset menjadi 1.
	// 			$last_number = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
	// 					->order_by('id', 'desc')
	// 					->only('nomor_urut');

	// 			$last_surat_tahun = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
	// 					->order_by('id', 'desc')
	// 					->only('tahun');

	// 			if ($last_surat_tahun == $cfg_tahun_surat) {
	// 				$now_number = $last_number + 1;
	// 			} else {
	// 				$now_number = 1;
	// 			}

	// 			// -Eloquent query-
	// 			Suratkeluar::create(array(
	// 				'jenis_surat' => $jenis->jenis_surat,
	// 				'nomor_urut' => $now_number,
	// 				'kode_surat' => $cfg_kode_surat,
	// 				'tahun' => $cfg_tahun_surat,
	// 				'tgl_surat' => $tanggal,
	// 				'pengirim' => $pengirim->nama,
	// 				'tujuan' => $tujuan,
	// 				'hal' => $hal,
	// 				'perekam' => Auth::user()->username
	// 			));

	// 			$count_sk++;
	// 		}
	// 	}

	// 	// menyimpan old input untuk memudahkan penginputan surat keluar sejenis berikutnya
	// 	// ** field tujuan dikosongkan
	// 	$jenis_old = $jenis->id;
	// 	$tanggal_old = $tanggal;
	// 	$pengirim_old = $pengirim->id;
	// 	$hal_old = $hal;

	// 	// menyusun nomor surat yg baru saja direkam, untuk penerusan message :)
	// 	$msg = 'Surat keluar berhasil direkam sebanyak: ' . $count_sk . ' surat.';

	// 	// return array old input dan pesan untuk memudahkan penginputan selanjutnya
	// 	$a = array(
	// 			'message' => $msg,
	// 			'jenis' => $jenis_old,
	// 			'tanggal' => $tanggal_old,
	// 			'pengirim' => $pengirim_old,
	// 			'hal' => $hal_old,
	// 			'msg' => $msg
	// 		);

	// 	return $a;
					
	// }

	/**
	 * Undo surat terakhir dimaksudkan apabila terjadi kesalahan input surat
	 * keluar terakhir. Fungsi ini disediakan sebagai alternatif -tidak diperkenankan-
	 * mengubah nomor surat yang telah terekam.
	 */
	public static function undo_last_surat() {
		// mengambil id terakhir
		$id = DB::table('surat_keluar')->order_by('id', 'desc')->only('id');

		// mengquery surat keluar dengan id terakhir
		$sk = Suratkeluar::find($id);		

		// sebelum dihapus, nomor surat disimpan untuk keperluan message
		$ns_dihapus = $sk->jenis_surat . $sk->nomor_urut . $sk->kode_surat . $sk->tahun; 
		$pesan = 'Nomor surat ' . $ns_dihapus . ' berhasil dibatalkan....'; 

		// mengumpulkan value dari surat yg dihapus untuk dikembalikan
		// pada placeholder form dan message
		$a = array(
			'tanggal' => $sk->tanggal,
			'tujuan' => $sk->tujuan,
			'hal' => $sk->hal,
			'jenis' => DB::table('jenis_surat')->where('jenis_surat', '=', $sk->jenis_surat)->only('id') ,
			'pengirim' => DB::table('disposisi')->where('nama', '=', $sk->pengirim)->only('id'),
			'pesan' => $pesan,
		);

		// menghapus nomor surat
		Suratkeluar::find($id)->delete();

		// return array nomor surat yang dihapus
		return $a;
	}

	/**
	 * View detail surat: jika id surat yg diiunput (secara manual) tidak ada
	 * maka return false.
	 */
	public static function view_surat($id) {
		$f = Suratkeluar::find($id);
		
		if (is_object($f)) {
			// compile nomor surat
			$nomor_surat = $f->jenis_surat . $f->nomor_urut . $f->kode_surat . $f->tahun;
			$nomor_surat_alt = $f->jenis_surat . '<span class="text-red">' . $f->nomor_urut . '</span>' . $f->kode_surat . $f->tahun;

			// menambahkan object nomor surat yg dicompile
			$f->nomor_surat = $nomor_surat;
			$f->nomor_surat_alt = $nomor_surat_alt;

			return $f;
		} else {
			return 0;
		}
	}

	/**
	 * Menampilkan form edit berdasarkan id suratnya.
	 * Return false jika id tidak terdapat dalam database.
	 */
	public static function edit_surat($id) {
		// cek apakah ID surat ada dalam database, user mungkin saja menebak URL secara manual
		$f = Suratkeluar::find($id);

		if (is_object($f)) {
			// membalikan JENIS SURAT ke ID-nya kembali
			$jenis_surat_dipakai = $f->jenis_surat;
			$f->id_jenis = DB::table('jenis_surat')->where('jenis_surat', '=', $jenis_surat_dipakai)->only('id');

			// membalikan PENGIRIM ke ID-nya kembali
			$nama_pengirim_dipakai = $f->pengirim;
			$f->id_pengirim = DB::table('disposisi')->where('nama', '=', $nama_pengirim_dipakai)->only('id');

			// compile nomor surat
			$f->nomor_surat = $f->jenis_surat . $f->nomor_urut . $f->kode_surat . $f->tahun;

			// bind data lainnya
			//$f->daftar_jenis = Jenissurat::order_by('jenis_surat')->get();
			$f->kode_surat = Konfigurasi::find(3)->config_value;
			$f->tahun_surat = Konfigurasi::find(4)->config_value;
			$f->daftar_disposisi = Disposisi::order_by('nama')->get();
			$f->daftar_jenis = Jenissurat::order_by('jenis_surat')->get();

			return $f;
		} else {
			return 0;
		}
	}

	/**
	* Eloquent query untuk update surat.
	* Untuk 'jenis_surat', 'nomor_urut', 'kode_surat', dan 'tahun' tidak menggunakan value dari form
	* (didisable untuk diedit), tetapi menggunakan value dari record asalnya.
	*/
	public static function update_surat($id) {
		/* catatan: record 'perekam' tidak dilakukan update untuk membedakan
		   user yang membuat dan yang mengubah */
		Suratkeluar::update($id, array(
			'jenis_surat' => Suratkeluar::find($id)->jenis_surat,
			'nomor_urut' => Suratkeluar::find($id)->nomor_urut,
			'kode_surat' => Suratkeluar::find($id)->kode_surat,
			'tahun' => Suratkeluar::find($id)->tahun,
			'tgl_surat' => Input::get('tanggal'),
			'pengirim' => Disposisi::find(Input::get('pengirim'))->nama,
			'tujuan' => Input::get('tujuan'),
			'hal' => Input::get('hal'),
			'diupdate' => Auth::user()->username
		));
	}

	/**
	 * Digunakan untuk query jenis surat karena input dari form yg
	 * disubmit berupa id-nya saja, sehingga perlu dikonversi ke jenis suratnya.
	 * Oleh karena proses konversi ini dilakukan dengan query database, untuk
	 * menghindari error: Trying to get property of non-object
	 * maka dilakukan cleaning terlebih dahulu secara manual.
	 */
	public static function clean_id_jenis($input) {
		$id = $input;
		$find = Jenissurat::find($id);

		if (is_object($find)) {
			$keyword = $find->jenis_surat;

			return $keyword;
		} else {
			return '%';
		}
	}

	/**
	 * Function sama seperti clean_id_jenis, perbedaan hanya di database dan
	 * field yg digunakan.
	 */
	public static function clean_id_pengirim($input) {
		$id = $input;
		$find = Disposisi::find($id);

		if (is_object($find)) {
			$keyword = $find->nama;

			return $keyword;
		} else {
			return '%';
		}
	}


	/**
	 * Mencegah error "Undefined index:" dalam hal user mengubah atau menghapus
	 * secara manual index dari form. 
	 */
	public static function lengkapi_array($i) {
		$input = array();

		$input['jenis'] = isset($i['jenis']) ? $i['jenis'] : '';
		$input['pengirim'] = isset($i['pengirim']) ? $i['pengirim'] : '';
		$input['nomor'] = isset($i['nomor']) ? $i['nomor'] : '';
		$input['kode'] = isset($i['kode']) ? $i['kode'] : '';
		$input['tahun'] = isset($i['tahun']) ? $i['tahun'] : '';
		$input['tanggal'] = isset($i['tanggal']) ? $i['tanggal'] : '';
		$input['tujuan'] = isset($i['tujuan']) ? $i['tujuan'] : '';
		$input['limit'] = isset($i['limit']) ? $i['limit'] : '';
		$input['hal'] = isset($i['hal']) ? $i['hal'] : '';
		$input['page'] = isset($i['page']) ? $i['page'] : 1;
		
		// sanitasi sort order
		$input['sort_order'] = isset($i['sort_order']) ? $i['sort_order'] : 'desc';
		$so = $input['sort_order'];
		$input['sort_order'] = ($so == 'asc' || $so == 'desc') ? $so : 'desc';

		return $input;
	}

	/**
	 * Membuat query untuk fungsi search dan return bersama yang diinput user.
	 */
	public static function search_surat($input) {
		// jika limit berupa string atau lebih kecil dari 1, gunakan limit default
		// juga dibulatkan ke atas jika user mencoba menginput manual pecahan
		// untuk sanitasi, otomatis dilakukan oleh class paginator (default)
		$limit = ($input['limit'] > 0) ? ceil($input['limit']) : Konfigurasi::find(7)->config_value;
		
		// sanitasi sort order
		$so = $input['sort_order'];
		$sort_order = ($so == 'asc' || $so == 'desc') ? $so : 'desc';

		$sk = Suratkeluar::order_by('id', $sort_order)
			->where('jenis_surat', 'LIKE', Suratkeluar::clean_id_jenis($input['jenis']))
			->where('pengirim', 'LIKE', Suratkeluar::clean_id_pengirim($input['pengirim']))
			->where('nomor_urut', 'LIKE', '%' . $input['nomor'] . '%')
			->where('kode_surat', 'LIKE', '%' . $input['kode'] . '%')
			->where('tahun', 'LIKE', '%' . $input['tahun'] . '%')
			->where('tgl_surat', 'LIKE', '%' . $input['tanggal'] . '%')
			->where('tujuan', 'LIKE', '%' . $input['tujuan'] . '%')
			->where('hal', 'LIKE', '%' . $input['hal'] . '%')
			->paginate($limit);


		$sk->daftar_disposisi = Disposisi::order_by('nama')->get();
		$sk->daftar_jenis = Jenissurat::order_by('jenis_surat')->get();
		$sk->input = $input;

		// append filter terhadap pagination
		$filter  = Suratkeluar::pagination_filter($input);
		$sk->appends($filter);

		return $sk;
	}

	/**
	 * Membuat query untuk fungsi print.
	 */
	public static function print_surat($input) {
		// sanitize page dan limit jika diinput secara manual
		$limit = (is_numeric( (int)($input['limit']) ) && $input['limit'] > 0) ? (int)($input['limit']) : Konfigurasi::find(7)->config_value;
		$page = (is_numeric( (int)($input['page']) ) && $input['page'] > 0) ? (int)($input['page']) : 1;


		// query pertama hanya mendapatkan id-nya saja,
		// ---query BELUM diexecute---
		$qry = Suratkeluar::order_by('id', 'desc')
			->where('jenis_surat', 'LIKE', Suratkeluar::clean_id_jenis($input['jenis']))
			->where('pengirim', 'LIKE', Suratkeluar::clean_id_pengirim($input['pengirim']))
			->where('nomor_urut', 'LIKE', '%' . $input['nomor'] . '%')
			->where('kode_surat', 'LIKE', '%' . $input['kode'] . '%')
			->where('tahun', 'LIKE', '%' . $input['tahun'] . '%')
			->where('tgl_surat', 'LIKE', '%' . $input['tanggal'] . '%')
			->where('tujuan', 'LIKE', '%' . $input['tujuan'] . '%')
			->where('hal', 'LIKE', '%' . $input['hal'] . '%');

		// Cek apakah user mencoba mengakses page secara manual, lebih dari max page
		//
		// mengexecute query $qry di atas untuk mendapatkan total records yg didapat
		$total_records = $qry->count();

		// rounding up untuk max page, misal total = 15, limit = 7,
		// maka max page = 2.14 -> round up menjadi 3
		$max_page = ceil($total_records / $limit);

		// jika page diinput manual dan melebihi maxpage, maka diset ke max page
		$page = ($page > $max_page) ? $max_page : $page;

		// karena menggunakan pagination, maka rows yg diambil harus sesuai pagenya
		$skipped = ($page - 1) * $limit;

		// mengexecute query $qry di atas untuk mendapatkan recordsnya
		$rows = $qry->skip($skipped)->take($limit)->get();

		// menyusun id dari query pertama ke dalam array
		// karena akan disort ulang, records yg didapat hanya diambil id-nya saja
		$id_array = array();
		foreach ($rows as $r) {
			$id_array = array_merge($id_array, array($r->id));
		}

		// query kedua mengambil row surat dgn order_by jenis_surat lalu nomor_urut
		$sk = Suratkeluar::where_in('id', $id_array)
			->order_by('tahun')
			->order_by('jenis_surat')
			->order_by('nomor_urut')
			->get();

		return $sk;
	}

	/**
	 * Return input dari form untuk filter pagination.
	 * unset 'page' dari input
	 */
	public static function pagination_filter($input) {
		// unset item 'page' dari array
		unset($input['page']);

		return $input;
	}

	/**
	 * Upload file CSV dan return file pathnya.
	 */
	public static function upload_handle($file) {
		
		$file_name = $file['name'];
		$file_tmp = $file['tmp_name'];
		$file_size = $file['size'];
		$file_error = $file['error'];

		$file_ext = explode('.', $file_name);
		$file_ext = strtolower(end($file_ext));

		$allowed = array('txt', 'csv');

		if (in_array($file_ext, $allowed)) {
			if ($file_error === 0) {
				// generate nama unik
				$file_name_new = uniqid('', true) . '.' . $file_ext;

				// lokasi untuk menyimpan file yang diupload
				$file_upload_destination = $GLOBALS['laravel_paths']['public'] . '/files/' . $file_name_new;

				// pindahkan file terupload dari temp ke path tujuan upload dan RETURN file pathnya
				if (move_uploaded_file($file_tmp, $file_upload_destination)) {
					return $file_upload_destination;
				}

			}
		}

	}

	/**
	 * Fetch file CSV untuk preview.
	 */
	public static function upload_preview($file) {
		$csv_rows = array();

		// detect delimiter antara ',' atau ';'
		$allowed_header = array('tujuan');
		
		$csv_uploded = file($file, FILE_IGNORE_NEW_LINES);

		$csv_header = str_getcsv($csv_uploded[0], ',');
		$csv_header2 = str_getcsv($csv_uploded[0], ';');
		if ($csv_header == $allowed_header) {
			$csv_delimiter = ',';
		} else if ($csv_header2 == $allowed_header) {						
			$csv_delimiter = ';';
		} else {
			echo 'wrong delimiter'; // FIXME throw error
			exit;
		}

		// push data csv ke array
		if (isset($csv_delimiter)) {						
			foreach ($csv_uploded as $line) {
				$csv_rows[] = str_getcsv($line, $csv_delimiter);						
			}

			// remove header dari file csv
			unset($csv_rows[0]);

			// return array dari CSV yang diproses
			return $csv_rows;			
		}
	}

	/**
	 * Rekam file CSV yang terupload.
	 */
	public static function upload_create($file, $input) {
		$csv_rows = array();

		// detect delimiter antara ',' atau ';'
		$allowed_header = array('tujuan');
		
		$csv_uploded = file($file, FILE_IGNORE_NEW_LINES);

		$csv_header = str_getcsv($csv_uploded[0], ',');
		$csv_header2 = str_getcsv($csv_uploded[0], ';');
		if ($csv_header == $allowed_header) {
			$csv_delimiter = ',';
		} else if ($csv_header2 == $allowed_header) {						
			$csv_delimiter = ';';
		} else {
			echo 'wrong delimiter'; // FIXME throw error
			exit;
		}

		// push data csv ke array
		if (isset($csv_delimiter)) {						
			foreach ($csv_uploded as $line) {
				$csv_rows[] = str_getcsv($line, $csv_delimiter);
			}

			// remove header dari file csv
			unset($csv_rows[0]);

			$i = $input;
			$cfg_kode_surat = Konfigurasi::find(3)->config_value;
			$cfg_tahun_surat = Konfigurasi::find(4)->config_value;

			$jenis = Jenissurat::find($i['jenis']);
			$pengirim = Disposisi::find($i['pengirim']);
			$tanggal = $i['tanggal'];
			$hal = $i['hal'];

			// remove header dari file csv
			unset($csv_rows[0]);

			$jumlah = 0;

			foreach ($csv_rows as $tujuan) {
				$tujuan = trim($tujuan[0]);

				if (!empty($tujuan)) {
					// Menentukan urutan selanjutnya untuk jenis surat X, dengan cara
					// "mengambil nomor urut jenis surat X terakhir" untuk nanti diincrement saat direkam ke database
					// -Fluent query-
					// Rulesnya: apabila tahun surat terakhir masih sama dengan tahun konfigurasi
					// surat, maka nomor urut dilanjutkan.
					// Apabila berbeda tahun, maka direset menjadi 1.
					$last_number = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
							->order_by('id', 'desc')
							->only('nomor_urut');

					$last_surat_tahun = DB::table('surat_keluar')->where('jenis_surat', '=', $jenis->jenis_surat)
							->order_by('id', 'desc')
							->only('tahun');

					if ($last_surat_tahun == $cfg_tahun_surat) {
						$now_number = $last_number + 1;
					} else {
						$now_number = 1;
					}

					// -Eloquent query-
					Suratkeluar::create(array(
						'jenis_surat' => $jenis->jenis_surat,
						'nomor_urut' => $now_number,
						'kode_surat' => $cfg_kode_surat,
						'tahun' => $cfg_tahun_surat,
						'tgl_surat' => $tanggal,
						'pengirim' => $pengirim->nama,
						'tujuan' => $tujuan,
						'hal' => $hal,
						'perekam' => Auth::user()->username,
						'diupdate' => Auth::user()->username
					));

					$jumlah++;
				}
			}

			$message = 'Surat Keluar Seksi sebanyak ' . $jumlah . ' surat berhasil direkam.';
			
			$a['message'] = $message;

			return $a['message'];
		}
	}

	// Kosongkan folder files hasil import dari Surat Keluar Seksi dan Surat Keluar Lain
	public static function empty_csv_folder() {
		// get path to csv folder
		$folder_path = $GLOBALS['laravel_paths']['public'] . '/files/';

		// scan directory
		$files = scandir($folder_path);

		// unset current and parent directory
		unset($files[0]);
		unset($files[1]);

		// menghapus semua file csv dalam folder tersebut
		foreach ($files as $key => $fname) {
			$full_path_to_file = $folder_path . $fname;
			unlink($full_path_to_file);
		}
	}
}