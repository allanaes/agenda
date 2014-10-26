<?php

class Create_Surat_Keluar_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surat_keluar', function($table){
			$table->increments('id');
			$table->string('jenis_surat', 10);
			$table->integer('nomor_urut');
			$table->string('kode_surat', 30);
			$table->string('tahun', 4);
			$table->string('tgl_surat', 10);
			$table->string('tujuan', 64);
			$table->string('hal');
			$table->string('pengirim', 64);
			$table->string('perekam', 32);
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
		Schema::drop('surat_keluar');
	}

}