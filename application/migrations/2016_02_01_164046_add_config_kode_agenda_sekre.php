<?php

class Add_Config_Kode_Agenda_Sekre {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{		
		DB::table('konfigurasi')->insert(array(
			'config_name'=>'kode_agenda_sekre',
			'config_info'=>'Ekstensi Kode Nomor Agenda Sekre untuk penomoran surat masuk Sekre sesuai SIDJP? (Contoh: /438/KAP)',
			'config_value'=>'/438/KAP',
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
		DB::table('konfigurasi')->where('config_name', '=', 'kode_agenda_sekre')->delete();
	}

}