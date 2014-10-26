<?php

class Create_Konfigurasi_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('konfigurasi', function($table) {
			$table->increments('id');
			$table->string('config_name');
			$table->string('config_info');
			$table->string('config_value');
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
		Schema::drop('konfigurasi');
	}

}