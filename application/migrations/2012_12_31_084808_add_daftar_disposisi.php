<?php

class Add_Daftar_Disposisi {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('disposisi')->insert(array(
			'nama'=>'UDIN',
			'nip'=>'060106665',
			'aktif'=>true
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('disposisi')->where('nama', '=', 'UDIN')->delete();
	}

}