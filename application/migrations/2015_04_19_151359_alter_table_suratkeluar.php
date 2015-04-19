<?php

class Alter_Table_Suratkeluar {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `surat_keluar` ADD `diupdate` VARCHAR(32) NOT NULL DEFAULT 'admin' AFTER `perekam`");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query('ALTER TABLE `surat_keluar` DROP `diupdate`');
	}

}