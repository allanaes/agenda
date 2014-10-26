<?php

class Alter_Table_Suratmasuk {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `surat_masuk` ADD `tahun_buku` INT NOT NULL DEFAULT '2013' AFTER `catatan`");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query('ALTER TABLE `surat_masuk` DROP `tahun_buku`');
	}

}