<?php

class Create_Jenis_Surat_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jenis_surat', function($table) {
			$table->increments('id');
			$table->string('jenis_surat', 10);
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
		Schema::drop('jenis_surat');
	}

}