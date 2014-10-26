<?php

class Add_Config_Nomor_Agenda {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('konfigurasi')->insert(array(
			'config_name'=>'tampilkan_nomor_agenda',
			'config_info'=>'Print nomor agenda otomatis? (Masukan angka 1 jika Ya)',
			'config_value'=>'1',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('konfigurasi')->where('config_name', '=', 'tampilkan_nomor_agenda')->delete();
	}

}