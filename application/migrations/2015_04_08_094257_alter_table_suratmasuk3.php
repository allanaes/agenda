<?php

class Alter_Table_Suratmasuk3 {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::query("ALTER TABLE `surat_masuk` ADD `diupdate` VARCHAR(32) NOT NULL DEFAULT 'admin' AFTER `catatan`");
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::query('ALTER TABLE `surat_masuk` DROP `diupdate`');
	}

}
