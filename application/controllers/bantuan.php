<?php

class Bantuan_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() {
		return View::make('bantuan.index')
			->with('title', 'Agenda Surat :: Bantuan');
	}

	public function get_bantuan_suratmasuk() {
		return View::make('bantuan.suratmasuk')
			->with('title', 'Agenda Surat :: Bantuan');
	}

	public function get_bantuan_suratkeluar() {
		return View::make('bantuan.suratkeluar')
			->with('title', 'Agenda Surat :: Bantuan');
	}

	public function get_bantuan_settings() {
		return View::make('bantuan.settings')
			->with('title', 'Agenda Surat :: Bantuan');
	}

	public function get_bantuan_faq() {
		return View::make('bantuan.faq')
			->with('title', 'Agenda Surat :: Bantuan');
	}

}