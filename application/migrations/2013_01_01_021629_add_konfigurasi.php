<?php

class Add_Konfigurasi {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('konfigurasi')->insert(array(
			'config_name'=>'nama_kpp',
			'config_info'=>'Nama KPP',
			'config_value'=>'Kantor Pelayanan Pajak Pratama Kuningan',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));
			
		DB::table('konfigurasi')->insert(array(
			'config_name'=>'nama_seksi',
			'config_info'=>'Nama Seksi',
			'config_value'=>'Seksi Pengawasan dan Konsultasi II',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('konfigurasi')->insert(array(
			'config_name'=>'kode_surat',
			'config_info'=>'Kode Surat',
			'config_value'=>'/WPJ.22/KP.1408/',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('konfigurasi')->insert(array(
			'config_name'=>'tahun_surat',
			'config_info'=>'Tahun Surat',
			'config_value'=>date('Y'),
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('konfigurasi')->insert(array(
			'config_name'=>'jumlah_baris_surat_masuk',
			'config_info'=>'Jumlah Baris untuk Tabel Input Surat Masuk',
			'config_value'=>'5',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('konfigurasi')->insert(array(
			'config_name'=>'jumlah_baris_surat_keluar',
			'config_info'=>'Jumlah Baris untuk Tabel Input Surat Keluar',
			'config_value'=>'5',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('konfigurasi')->insert(array(
			'config_name'=>'jumlah_baris_pencarian_surat',
			'config_info'=>'Jumlah Baris untuk Tabel Hasil Pencarian',
			'config_value'=>'20',
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
		DB::table('konfigurasi')->where('config_name', '=', 'nama_kpp')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'nama_seksi')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'kode_surat')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'tahun_surat')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'jumlah_baris_surat_masuk')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'jumlah_baris_surat_keluar')->delete();
		DB::table('konfigurasi')->where('config_name', '=', 'jumlah_baris_pencarian_surat')->delete();
	}

}