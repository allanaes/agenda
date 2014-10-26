<?php

class Create_Petunjuk {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('petunjuk', function($table) {
			$table->increments('id');
			$table->string('petunjuk');
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
		Schema::drop('petunjuk');
	}

}