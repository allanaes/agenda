<?php

class Create_Disposisi_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disposisi', function($table) {
			$table->increments('id');
			$table->string('nama', 60);
			$table->string('nip', 18);
			$table->boolean('aktif');
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
		Schema::drop('disposisi');
	}

}