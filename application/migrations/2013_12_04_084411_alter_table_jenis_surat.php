<?php

class Alter_Table_Jenis_Surat {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `jenis_surat` ADD `aktif` INT NOT NULL DEFAULT '1' AFTER `jenis_surat`");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query('ALTER TABLE `jenis_surat` DROP `aktif`');
	}

}