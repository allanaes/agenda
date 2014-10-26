<?php

class Create_Surat_Masuk_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surat_masuk', function($table) {
			$table->increments('id');
			$table->integer('nomor_agenda_seksi');
			$table->string('tgl_diterima', 10);
			$table->string('nomor_agenda_sekre', 50);
			$table->string('nomor_surat', 50);
			$table->string('tgl_surat', 10);
			$table->string('pengirim', 100);
			$table->string('hal');
			$table->string('disposisi', 20);
			$table->string('lain_lain', 50)->nullable();
			$table->string('sifat', 20)->nullable();
			$table->string('petunjuk', 20)->nullable();
			$table->integer('copy')->nullable();
			$table->string('catatan')->nullable();
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
		Schema::drop('surat_masuk');
	}

}