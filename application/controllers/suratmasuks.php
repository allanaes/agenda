<?php

class Suratmasuks_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() {
		$db_surat_masuk = Suratmasuk::index_surat();

		// Trigger: 
		// membuka page input surat masuk sebagai trigger untuk
		// mengkosongkan kembali isi folder 'pdf' dari file-file
		// lembar disposisi yang digenerate
		Printpdf::empty_pdf_folder();

		return View::make('suratmasuk.index')
			->with('title', 'Agenda Surat :: Surat Masuk')
			->with('suratmasuks', $db_surat_masuk);
	}

	public function get_pengawasan() {
		$pengawasan_surat = Suratmasukpengawasan::pengawasan_index();
		$data_pengawasan = Suratmasukpengawasan::data_pengawasan($pengawasan_surat);

		return View::make('suratmasuk.pengawasan')
			->with('title', 'Agenda Surat :: Pengawasan Surat')
			->with('data_pengawasan', $data_pengawasan)
			->with('pengawasan_surat', $pengawasan_surat);
	}

	public function get_pengawasan_selesai() {
		$pengawasan_surat_selesai = Suratmasukaktivitas::index_aktivitas_selesai();
		$a = Suratmasukaktivitas::data_aktivitas($pengawasan_surat_selesai);

		return View::make('suratmasuk.pengawasan_selesai')
			->with('title', 'Agenda Surat :: Pengawasan Surat')
			->with('pengawasan_surat_selesai', $pengawasan_surat_selesai)
			->with('pengawasan_surat', $a);
	}

	public function get_aktivitas($id) {
		$aktivitas_surat = Suratmasukaktivitas::aktivitas_surat($id);

		if ($aktivitas_surat) {
			$s = Suratmasukaktivitas::where('id_surat_masuk', '=', $id)->get();

			$msg = isset($message) ? $message : null;

			return View::make('suratmasuk.aktivitas')
				->with('title', 'Agenda Surat :: Aktivitas Surat')
				->with('suratmasuk', $aktivitas_surat)
				->with('message', $msg)
				->with('aktivitas', $s);
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function post_aktivitas_create() {
		$input = Input::all();
		$id_surat_masuk = $input["id_surat_masuk"];
		$validation = Suratmasukaktivitas::validate($input);

		if ($validation->fails()) {
			return Redirect::to('suratmasuk/' . $id_surat_masuk . '/aktivitas')->with_errors($validation)->with_input();
		} else {
			$tambah_aktivitas = Suratmasukaktivitas::aktivitas_create($input);	

			return Redirect::to('suratmasuk/' . $id_surat_masuk . '/aktivitas')->with('message', $tambah_aktivitas);;
		}
	}


	public function post_create() {
		$input = Input::all();
		$validation = Suratmasuk::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('suratmasuk')->with_errors($validation)->with_input();
		} else {
			$sm = Suratmasuk::create_surat($input);
			
			return Redirect::to_route('suratmasuk')
				->with('message', $sm);
		}
	}

	public function get_view($id) {
		$view_surat = Suratmasuk::view_surat($id);

		if ($view_surat)
			return View::make('suratmasuk.view')
				->with('title', 'Agenda Surat :: Detail Surat')
				->with('suratmasuk', $view_surat);
		 else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function get_edit($id) {
		$edit_surat = Suratmasuk::edit_surat($id);

		if ($edit_surat) {
			return View::make('suratmasuk.edit')
				->with('title', 'Agenda Surat :: Edit Surat')
				->with('suratmasuk', $edit_surat);
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function put_update() {
		$id = Input::get('id');

		// validasi input apakah sesuai rules (cek di model "suratmasuk")
		$validation = Suratmasuk::validate_alt(Input::all());

		if ($validation->fails()) {
			return Redirect::to_route('edit_suratmasuk', $id)->with_errors($validation);
		} else {
			$update_surat = Suratmasuk::update_surat($id);

			return Redirect::to_route('suratmasuk', $id)
				->with('message', $update_surat);
		}
	}

	public function get_search() {
		$input = Input::all();

		// lengkapi array agar tidak missing index
		$input = Suratmasuk::lengkapi_array($input);

		// melakukan query dengan/tanpa input dari form search
		$db_surat_masuk = Suratmasuk::search_surat($input);

		return View::make('suratmasuk.search')
			->with('title', 'Agenda Surat :: Surat Masuk')
			->with('suratmasuks', $db_surat_masuk);
	}

	public function get_print() {
		$input = Input::all();

		// lengkapi array agar tidak missing index
		$input = Suratmasuk::lengkapi_array($input);

		// melakukan query dengan/tanpa input dari form search
		$db_surat_masuk = Suratmasuk::search_surat($input);

		return View::make('suratmasuk.print')
			->with('title', 'Agenda Surat :: Surat Masuk')
			->with('suratmasuks', $db_surat_masuk);
	}

	/** print lembar disposisi */
	public function get_disposisi($id) {
		// re-use model view_surat
		$view_surat = Suratmasuk::view_surat($id);

		if ($view_surat) {
			// generate pdf, return string file name, simpan di variabel
			$generate_pdf = Printpdf::generate_lembar_disposisi($view_surat);

			// open generated pdf file
			$path_to_pdf = 'pdf/' . $generate_pdf;
			$url_to_pdf = URL::to_asset($path_to_pdf);
			return Redirect::to($url_to_pdf);
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}
}