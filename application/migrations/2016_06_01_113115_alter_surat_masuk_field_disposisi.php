<?php

class Alter_Surat_Masuk_Field_Disposisi {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE  `surat_masuk` CHANGE  `disposisi`  `disposisi` VARCHAR( 50 )");
		DB::query("ALTER TABLE  `surat_masuk` CHANGE  `petunjuk`  `petunjuk` VARCHAR( 50 )");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
