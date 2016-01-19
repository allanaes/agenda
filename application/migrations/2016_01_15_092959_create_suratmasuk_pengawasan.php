<?php

class Create_Suratmasuk_Pengawasan {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surat_masuk_pengawasan', function($table) {
			$table->increments('id');
			$table->integer('id_surat_masuk');
			$table->integer('id_aktivitas');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('surat_masuk_pengawasan');
	}

}