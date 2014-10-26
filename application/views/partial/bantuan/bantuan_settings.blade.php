@section('bantuan_settings')
<div class="span7 push-bottom">
	<?php $daftar_tipe = User::daftar_tipe(); ?>
	@if(Auth::user()->tipe == $daftar_tipe['admin'])
	<div class="row">
		<h3>Overview</h3>
		<p>Menu Settings digunakan untuk mengkonfigurasi aplikasi sesuai kebutuhan
			masing-masing seksi (atau instansi). Halaman Settings diklasifikasikan
			menurut pengaturan dan modul aplikasi yang menggunakan nilai konfigurasinya.
		</p>

		<h4>Submenu: Index Settings</h4>
		<p>Merupakan halaman overview untuk melihat daftar konfigurasi dari aplikasi ini.
			Untuk Daftar User Account, dapat dilihat pada submenunya tersendiri.</p>

		<h4>Submenu: Daftar Jenis Surat</h4>
		<p>Menu ini digunakan untuk menambahkan jenis surat pada Input Surat Keluar. Harap diperhatikan
			bahwa jenis surat yang telah diinput tidak dapat dihapus. Tujuannya agar
			tidak merusak integrasi record lama surat keluar. Akan tetapi, apabila
			ada kesalahaan saat menambahkan jenis surat, masih dapat diperbaiki dengan
			menggunakan form Update di bawahnya. Dengan kata lain, daftar jenis surat
			yang terakhir ditambahkan masih bisa diubah.</p>

		<h4>Submenu: Daftar Disposisi</h4>
		<p>Sama seperti Daftar Jenis Surat, pada settings Daftar Disposisi juga dapat
			digunakan untuk menambah daftar baru untuk disposisi dengan ketentuan daftar
			yang telah ditambahkan tidak dapat dihapus kecuali daftar terakhir masih
			dapat diedit ulang dengan menggunakan form Update di bawahnya.</p>
		<p>Batas jumlah daftar disposisi yang AKTIF hanya 16 entri. Untuk menambahkan
			daftar lain, silakan NONAKTIF-kan terlebih dahulu daftar nama yang tidak lagi digunakan.</p>
		

		<h4>Submenu: Daftar Petunjuk</h4>
		<p>Silakan tambahkan daftar petunjuk pada menu ini. Harap diperhatikan bahwa
			daftar petunjuk yang telah diinput tidak dapat dihapus, kecuali untuk daftar
			terakhir masih dapat diedit ulang. Harap diperhatikan juga urutannya karena
			tidak disediakan untuk mengedit urutan daftar petunjuk.</p>

		<h4>Submenu: Daftar User Account</h4>
		<p>Dalam hal perubahan username, hanya diperkenankan menggunakan kombinasi
			huruf dan angka saja, serta nama user yang belum digunakan. Dalam hal
			penggunaan password, hanya diperkenankan menggunakan password dengan
			jumlah karakter minimal 5. Untuk fullname, pengguna dapat menggunakannya
			sebagai identitas. Tipe user akan menentukan otoritas user dalam menggunakan
			menu Settings. Untuk menu lainnya tidak ada pembatasan.
		</p>
		<p>Password yang tersimpan dalam database sudah di-salt dan di-hash. Untuk
			proses hashing-nya sendiri menggunakan algoritma bcrypt.
		</p>
		
		<h4>Submenu: Daftar Konfigurasi Agenda Surat</h4>
		<p>Konfigurasi Agenda Surat meliputi settingan identitas (untuk keperluan
			pencetakan Lembar Disposisi, dsb.) dan behaviour penggunaan
			aplikasi. Pastikan data yang diisikan pada menu ini sesuai dengan kebutuhan
			penggunaan. Pastikan pula penggunaan Tahun pada konfigurasi ini sudah sesuai
			dan selalu diperbarui sesuai kebutuhan.
		</p>

		<h4>Submenu: Data Liberation</h4>
		<p>Menu Data Liberation memungkinkan pengguna untuk mendownload seluruh data
			Surat Masuk ataupun Surat Keluar dengan format CSV. Fitur ini ditujukan untuk
			memudahkan pengguna dalam melakukan pengolahan database surat masuk atau surat
			keluar yang telah direkam dan migrasi data ke aplikasi lain.
		</p>

	</div>
	@else
	<div class="row">
		<h4>Overview</h4>
		<p>Menu Settings dapat digunakan untuk reset profile user seperti
			perubahan username, perubahan full name, atau perubahan password.
		</p>
		<p>Dalam hal perubahan username, hanya diperkenankan menggunakan kombinasi
			huruf dan angka saja, serta nama user yang belum digunakan. Dalam hal
			penggunaan password, hanya diperkenankan menggunakan password dengan
			jumlah karakter minimal 5. Untuk fullname, pengguna dapat menggunakannya
			sebagai identitas.
		</p>
		<p>Password yang tersimpan dalam database sudah di-salt dan di-hash. Untuk
			proses hashing-nya sendiri menggunakan algoritma bcrypt.
		</p>
	</div>
	@endif
</div>

@endsection