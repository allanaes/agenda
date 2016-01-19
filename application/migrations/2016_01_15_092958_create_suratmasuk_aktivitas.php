<?php

class Create_Suratmasuk_Aktivitas {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surat_masuk_aktivitas', function($table) {
			$table->increments('id');
			$table->integer('id_surat_masuk');
			$table->string('pic', 50);
			$table->string('aktivitas');
			$table->string('tgl_aktivitas', 10);
			$table->string('tgl_jatuh_tempo', 10)->nullable();
			$table->string('proses', 20);
			$table->string('perekam', 32);
			$table->string('diupdate', 32);
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
		Schema::drop('surat_masuk_aktivitas');
	}

}