<?php

class Add_Jenis_Surat {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('jenis_surat')->insert(array(
			'jenis_surat'=>'S-'
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('jenis_surat')->where('jenis_surat', '=', 'S-')->delete();
	}

}