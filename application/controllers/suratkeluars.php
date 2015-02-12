<?php

class Suratkeluars_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() {
		$db_surat_keluar = Suratkeluar::index_surat();

		return View::make('suratkeluar.index')
			->with('title', 'Agenda Surat :: Surat Keluar')
			->with('suratkeluars', $db_surat_keluar);
	}

	public function get_indexmassal() {
		$db_surat_keluar = Suratkeluar::index_surat();

		return View::make('suratkeluar.index_massal')
			->with('title', 'Agenda Surat :: Surat Keluar')
			->with('suratkeluars', $db_surat_keluar);
	}

	public function get_view($id) {
		$view_surat = Suratkeluar::view_surat($id);

		if ($view_surat)
			return View::make('suratkeluar.view')
				->with('title', 'Agenda Surat :: Detail Surat')
				->with('suratkeluar', $view_surat);
		 else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function post_create() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluar")
		$validation = Suratkeluar::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('suratkeluar')->with_errors($validation)->with_input();
		} else {
			$sk = Suratkeluar::create_surat($input);

			// redirect dengan session variable untuk kemudahan input surat sejenis
			// variablenya bisa diakses dengan function Session::get('variable')
			return Redirect::to_route('suratkeluar')
				->with('message', $sk['msg'])
				->with('jenis', $sk['jenis'])
				->with('tanggal', $sk['tanggal'])
				->with('pengirim', $sk['pengirim'])
				->with('hal', $sk['hal']);
		}
	}

	public function post_createmassal() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluar")
		$validation = Suratkeluar::validate_upload($input);

		if ($validation->fails()) {
			return Redirect::to_route('suratkeluar_massal')->with_errors($validation)->with_input();
		} else {
			$file = Input::file('csv_upload');

			if (isset($file)) {
				$csv_file =  Suratkeluar::upload_handle($file);

				if ($csv_file) {
					$csv_rows = Suratkeluar::upload_preview($csv_file);

					return View::make('suratkeluar.preview_massal')
						->with('title', 'Agenda Surat :: Preview Import Surat Keluar Seksi')
						->with('csv_rows', $csv_rows)
						->with('csv_file', $csv_file)
						->with('input', $input);
				} else {
					return Redirect::to_route('suratkeluar_massal')
						->with('warning', 'Format file tidak valid!');
				}
			} else {
				return Redirect::to_route('suratkeluar_massal')->with('message', 'Unknown Error!');
			}
		}
	}

	public function post_import() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluar")
		$validation = Suratkeluar::validate_import($input);


		if ($validation->fails()) {
			return Redirect::to_route('suratkeluar_massal')->with_errors($validation)->with_input();
		} else {
			$file = Input::get('csv_file');

			$sk = Suratkeluar::upload_create($file, $input);

			// redirect dengan message
			return Redirect::to_route('suratkeluar')
				->with('message', $sk);

		}
	}	

	public function get_edit($id) {
		$edit_surat = Suratkeluar::edit_surat($id);

		if ($edit_surat) {
			return View::make('suratkeluar.edit')
				->with('title', 'Buku Agenda :: Edit Surat Keluar')
				->with('suratkeluar', $edit_surat);
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function put_update() {
		$id = Input::get('id');

		// validasi input apakah sesuai rules (cek di model "suratkeluar")
		$validation = Suratkeluar::validate_update(Input::all());

		if ($validation->fails()) {
			return Redirect::to_route('edit_suratkeluar', $id)->with_errors($validation);
		} else {
			Suratkeluar::update_surat($id);

			return Redirect::to_route('suratkeluar', $id)
				->with('message', 'Surat keluar berhasil diupdate.');
		}
	}

	public function delete_undo() {
		// function undo_last_surat juga mereturn array value surat yg dihapus,
		// array tersebut kemudian dikembalikan ke form apabila diperlukan kembali
		$hapus = Suratkeluar::undo_last_surat();

		// value dari record yang dihapus dikembalikan lagi ke form
		// variablenya bisa diakses dengan function Session::get('variable')
		return Redirect::to_route('suratkeluar')
			->with('alert', $hapus['pesan'])
			->with('tanggal', $hapus['tanggal'])
			->with('tujuan', $hapus['tujuan'])
			->with('hal', $hapus['hal'])
			->with('jenis', $hapus['jenis'])
			->with('pengirim', $hapus['pengirim']);
	}

	public function get_search() {
		$input = Input::all();

		// lengkapi_array harus dipanggil pada controller karena akan direturn kembali ke view
		$input = Suratkeluar::lengkapi_array($input);

		$db_surat_keluar = Suratkeluar::search_surat($input);			

		return View::make('suratkeluar.search')
			->with('title', 'Buku Agenda :: Search Surat Keluar')
			->with('suratkeluars', $db_surat_keluar);
	}

	public function get_print() {
		$input = Input::all();
		$input = Suratkeluar::lengkapi_array($input);
		$db_surat_keluar = Suratkeluar::print_surat($input);

		return View::make('suratkeluar.print')
			->with('title', 'Buku Agenda :: Print Surat Keluar')
			->with('suratkeluars', $db_surat_keluar);
	}
}