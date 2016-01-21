<?php

class Add_Config_Sekre {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{		
		DB::table('konfigurasi')->insert(array(
			'config_name'=>'is_sekre',
			'config_info'=>'Apakah Seksi atau Bagian merupakan Sekretariat? (Masukan angka 1 jika Ya)',
			'config_value'=>'0',
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
		DB::table('konfigurasi')->where('config_name', '=', 'is_sekre')->delete();
	}

}