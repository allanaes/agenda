<?php

class Suratkeluarlain extends Eloquent {
	public static $table = 'surat_keluar_lain';

	/**
	 * Rules untuk create dan update surat keluar.
	 */
	public static $rules = array(
		'nomor_surat'=>'required',
		'tujuan'=>'required',
		'hal'=>'required',
		'tanggal'=>'required|date_format:d/m/Y',
		'pengirim'=>'required',
	);

	/**
	 * Rules untuk upload file CSV.
	 */
	public static $rules_upload = array(
		'csv_upload'=>'required|mimes:csv,txt'
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
	public static function index_surat() {
		// mengambil value dari table "konfigurasi"
		$cfg_jmlbaris_suratkeluar = Konfigurasi::find(6)->config_value;

		$sk = Suratkeluarlain::order_by('id', 'desc')->paginate($cfg_jmlbaris_suratkeluar);

		// bind data lain
		$sk->daftar_disposisi = Disposisi::order_by('nama')->get();

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

		$pengirim = Disposisi::find($i['pengirim']);
		$tanggal = $i['tanggal'];
		$hal = $i['hal'];
		$tujuan = $i['tujuan'];
		$nomor_surat = $i['nomor_surat'];
		
		// -Eloquent query-
		Suratkeluarlain::create(array(
			'nomor_surat' => $nomor_surat,
			'tgl_surat' => $tanggal,
			'pengirim' => $pengirim->nama,
			'tujuan' => $tujuan,
			'hal' => $hal,
			'perekam' => Auth::user()->username
		));

		// menyimpan old input untuk memudahkan penginputan surat keluar sejenis berikutnya
		// ** field nomor_surat dikosongkan
		$tanggal_old = $tanggal;
		$pengirim_old = $pengirim->id;
		$hal_old = $hal;
		$tujuan_old = $tujuan;

		// menyusun nomor surat yg baru saja direkam, untuk penerusan message :)
		$msg = 'Surat untuk ' . $tujuan . ' berhasil direkam dengan nomor: ' . $nomor_surat;

		// return array old input dan pesan untuk memudahkan penginputan selanjutnya
		$a = array(
				'tanggal' => $tanggal_old,
				'pengirim' => $pengirim_old,
				'hal' => $hal_old,
				'tujuan' => $tujuan_old,
				'msg' => $msg
			);

		return $a;
	}

	/**
	 * Undo surat terakhir dimaksudkan apabila terjadi kesalahan input surat
	 * keluar terakhir. Fungsi ini disediakan sebagai alternatif -tidak diperkenankan-
	 * mengubah nomor surat yang telah terekam.
	 */
	public static function destroy_surat($id) {
		// mengquery surat keluar dengan id terakhir
		$sk = Suratkeluarlain::find($id);	

		// sebelum dihapus, nomor surat disimpan untuk keperluan message
		$ns_dihapus = $sk->nomor_surat; 
		$pesan = 'Nomor surat ' . $ns_dihapus . ' berhasil dihapus. Data surat dikembalikan ke form.'; 

		// mengumpulkan value dari surat yg dihapus untuk dikembalikan
		// pada placeholder form dan message
		$a = array(
			'tanggal' => $sk->tanggal,
			'tujuan' => $sk->tujuan,
			'hal' => $sk->hal,
			'nomor_surat' => $sk->nomor_surat,
			'pengirim' => DB::table('disposisi')->where('nama', '=', $sk->pengirim)->only('id'),
			'pesan' => $pesan,
		);

		// menghapus nomor surat
		Suratkeluarlain::find($id)->delete();

		// return array nomor surat yang dihapus
		return $a;
	}

	/**
	 * View detail surat: jika id surat yg diiunput (secara manual) tidak ada
	 * maka return false.
	 */
	public static function view_surat($id) {
		$f = Suratkeluarlain::find($id);
		
		if (is_object($f)) {
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
		$f = Suratkeluarlain::find($id);

		if (is_object($f)) {			
			// membalikan PENGIRIM ke ID-nya kembali
			$nama_pengirim_dipakai = $f->pengirim;
			$f->id_pengirim = DB::table('disposisi')->where('nama', '=', $nama_pengirim_dipakai)->only('id');

			// bind data lainnya
			$f->daftar_disposisi = Disposisi::order_by('nama')->get();

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
		Suratkeluarlain::update($id, array(
			'nomor_surat' => Input::get('nomor_surat'),
			'tgl_surat' => Input::get('tanggal'),
			'pengirim' => Disposisi::find(Input::get('pengirim'))->nama,
			'tujuan' => Input::get('tujuan'),
			'hal' => Input::get('hal'),
			'perekam' => Auth::user()->username
		));
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

		$input['pengirim'] = isset($i['pengirim']) ? $i['pengirim'] : '';
		$input['nomor_surat'] = isset($i['nomor_surat']) ? $i['nomor_surat'] : '';
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

		$sk = Suratkeluarlain::order_by('id', $sort_order)
			->where('nomor_surat', 'LIKE', '%' . $input['nomor_surat'] . '%')
			->where('pengirim', 'LIKE', Suratkeluarlain::clean_id_pengirim($input['pengirim']))
			->where('tgl_surat', 'LIKE', '%' . $input['tanggal'] . '%')
			->where('tujuan', 'LIKE', '%' . $input['tujuan'] . '%')
			->where('hal', 'LIKE', '%' . $input['hal'] . '%')
			->paginate($limit);


		$sk->daftar_disposisi = Disposisi::order_by('nama')->get();
		$sk->input = $input;

		// append filter terhadap pagination
		$filter  = Suratkeluarlain::pagination_filter($input);
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
		$qry = Suratkeluarlain::order_by('id', 'desc')
			->where('pengirim', 'LIKE', Suratkeluarlain::clean_id_pengirim($input['pengirim']))
			->where('nomor_surat', 'LIKE', '%' . $input['nomor_surat'] . '%')
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

		// query kedua mengambil row surat dgn order_by tanggal_rekam lalu pengirim
		$sk = Suratkeluarlain::where_in('id', $id_array)
			->order_by('created_at')
			->order_by('pengirim')
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

	// upload file CSV dan return file pathnya
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


	public static function upload_preview($file) {
		$csv_rows = array();

		// detect delimiter antara ',' atau ';'
		$allowed_header = array('nomor_surat', 'tanggal', 'tujuan', 'hal', 'pengirim');
		
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

	// rekam file CSV yang terupload
	public static function upload_create($file) {
		$csv_rows = array();

		// detect delimiter antara ',' atau ';'
		$allowed_header = array('nomor_surat', 'tanggal', 'tujuan', 'hal', 'pengirim');
		
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

			$jumlah = 0;
			foreach ($csv_rows as $row) {
				// rekam data surat lain
				// -Eloquent query-
				Suratkeluarlain::create(array(
					'nomor_surat'=>$row[0],
					'tgl_surat'=>$row[1],
					'tujuan'=>$row[2],
					'hal'=>$row[3],
					'pengirim'=>$row[4],
					'perekam' => Auth::user()->username
				));

				// set counter
				$jumlah++;
			}

			$message = 'Surat Keluar Lain sebanyak ' . $jumlah . ' surat berhasil direkam.';
			
			return $message;
		}
	}

}