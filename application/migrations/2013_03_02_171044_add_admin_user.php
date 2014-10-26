<?php

class Add_Admin_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('users')->insert(array(
			'username'=>'admin',
			'password'=>Hash::make('admin'),
			'fullname'=>'Administrator',
			'tipe'=>9,
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->where('username', '=', 'admin')->delete();
	}

}