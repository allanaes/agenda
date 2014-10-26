<?php

class Beranda_Controller extends Base_Controller {

	public $restful = true;

	public static function get_index() {
		$pagination_surat_masuk_locked = true;
		$pagination_surat_keluar_locked = true;

		$db_surat_masuk = Suratmasuk::index_surat($pagination_surat_masuk_locked);
		$db_surat_keluar = Suratkeluar::index_surat($pagination_surat_keluar_locked);

		return View::make('index.index')
				->with('title', 'Agenda Surat :: Beranda')
				->with('suratmasuks', $db_surat_masuk)
				->with('suratkeluars', $db_surat_keluar)
				->with('pagination_surat_masuk_locked', $pagination_surat_masuk_locked)
				->with('pagination_surat_keluar_locked', $pagination_surat_keluar_locked);
	}
}