<?php

class Suratkeluarlains_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() {
		$db_surat_keluar = Suratkeluarlain::index_surat();

		return View::make('suratkeluarlain.index')
			->with('title', 'Agenda Surat :: Surat Keluar Lain')
			->with('suratkeluarlains', $db_surat_keluar);
	}

	public function get_indexmassal() {
		$db_surat_keluar_lain = Suratkeluarlain::index_surat();

		return View::make('suratkeluarlain.index_massal')
			->with('title', 'Agenda Surat :: Surat Keluar Lain')
			->with('suratkeluarlains', $db_surat_keluar_lain);
	}

	public function get_view($id) {
		$view_surat = Suratkeluarlain::view_surat($id);

		if ($view_surat)
			return View::make('suratkeluarlain.view')
				->with('title', 'Agenda Surat :: Detail Surat')
				->with('suratkeluarlain', $view_surat);
		 else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function post_create() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluarlain")
		$validation = Suratkeluarlain::validate($input);

		if ($validation->fails()) {
			return Redirect::to_route('suratkeluarlain')->with_errors($validation)->with_input();
		} else {
			$sk = Suratkeluarlain::create_surat($input);

			// redirect dengan session variable untuk kemudahan input surat sejenis
			// variablenya bisa diakses dengan function Session::get('variable')
			return Redirect::to_route('suratkeluarlain')
				->with('message', $sk['msg'])
				->with('tujuan', $sk['tujuan'])
				->with('tanggal', $sk['tanggal'])
				->with('pengirim', $sk['pengirim'])
				->with('hal', $sk['hal']);
		}
	}

	public function post_createmassal() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluarlain")
		$validation = Suratkeluarlain::validate_upload($input);

		if ($validation->fails()) {
			return Redirect::to_route('suratkeluarlain_massal')->with_errors($validation)->with_input();
		} else {
			$file = Input::file('csv_upload');

			if (isset($file)) {
				$csv_file =  Suratkeluarlain::upload_handle($file);

				if ($csv_file) {
					$csv_rows = Suratkeluarlain::upload_preview($csv_file);

					return View::make('suratkeluarlain.preview_massal')
						->with('title', 'Agenda Surat :: Preview Import Surat Keluar Lain')
						->with('csv_rows', $csv_rows)
						->with('csv_file', $csv_file);
				} else {
					return Redirect::to_route('suratkeluarlain_massal')
						->with('warning', 'Format file tidak valid!');
				}
			} else {
				return Redirect::to_route('suratkeluarlain_massal')->with('message', 'Unknown Error!');
			}
		}

	}

	public function post_import() {
		$input = Input::all();

		// validasi input apakah sesuai rules (cek di model "suratkeluarlain")
		$validation = Suratkeluarlain::validate_import($input);


		if ($validation->fails()) {
			return Redirect::to_route('suratkeluarlain_massal')->with_errors($validation)->with_input();
		} else {
			$file = Input::get('csv_file');

			$sk = Suratkeluarlain::upload_create($file);

			// redirect dengan message
			return Redirect::to_route('suratkeluarlain')
				->with('message', $sk);

		}
	}


	public function get_edit($id) {
		$edit_surat = Suratkeluarlain::edit_surat($id);

		if ($edit_surat) {
			return View::make('suratkeluarlain.edit')
				->with('title', 'Buku Agenda :: Edit Surat Keluar Lain')
				->with('suratkeluarlain', $edit_surat);
		} else {
			// return error 404 apabila mengakses ID surat yg tidak ada di database
			return View::make('error.404');
		}
	}

	public function put_update() {
		$id = Input::get('id');

		// validasi input apakah sesuai rules (cek di model "suratkeluarlain")
		$validation = Suratkeluarlain::validate(Input::all());

		if ($validation->fails()) {
			return Redirect::to_route('edit_suratkeluarlain', $id)->with_errors($validation);
		} else {
			Suratkeluarlain::update_surat($id);

			return Redirect::to_route('suratkeluarlain', $id)
				->with('message', 'Surat keluar berhasil diupdate.');
		}
	}

	public function delete_destroy() {
		// function destroy_surat juga mereturn array value surat yg dihapus,
		// array tersebut kemudian dikembalikan ke form apabila diperlukan kembali
		$id = Input::get('id');

		$sk = Suratkeluarlain::find($id);

		if (is_object($sk)) {
			$hapus = Suratkeluarlain::destroy_surat($id);

			// value dari record yang dihapus dikembalikan lagi ke form
			// variablenya bisa diakses dengan function Session::get('variable')
			return Redirect::to_route('suratkeluarlain')
				->with('alert', $hapus['pesan'])
				->with('tanggal', $hapus['tanggal'])
				->with('tujuan', $hapus['tujuan'])
				->with('hal', $hapus['hal'])
				->with('nomor_surat', $hapus['nomor_surat'])
				->with('pengirim', $hapus['pengirim']);
		} else {
			return Redirect::to_route('suratkeluarlain')
				->with('warning', 'ID Nomor Surat Lain yang akan dihapus tidak valid.');
		}
	}

	public function get_search() {
		$input = Input::all();

		// lengkapi_array harus dipanggil pada controller karena akan direturn kembali ke view
		$input = Suratkeluarlain::lengkapi_array($input);

		$db_surat_keluar = Suratkeluarlain::search_surat($input);			

		return View::make('suratkeluarlain.search')
			->with('title', 'Buku Agenda :: Search Surat Keluar Lain')
			->with('suratkeluarlains', $db_surat_keluar);
	}

	public function get_print() {
		$input = Input::all();
		$input = Suratkeluarlain::lengkapi_array($input);
		$db_surat_keluar = Suratkeluarlain::print_surat($input);

		return View::make('suratkeluarlain.print')
			->with('title', 'Buku Agenda :: Print Surat Keluar Lain')
			->with('suratkeluarlains', $db_surat_keluar);
	}
}