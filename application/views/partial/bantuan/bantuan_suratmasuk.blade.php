@section('bantuan_suratmasuk')
<div class="span7 push-bottom">
	<div class="row">
		<h3>Pencarian Surat Masuk</h3>
		<p>Selain digunakan untuk mencari record surat masuk, menu ini juga dapat
			digunakan untuk membuat lembar tanda terima dari hasil pencarian daftar
			surat masuk yang didapat. Untuk mendapatkan daftar surat secara lengkap, pengguna
			dengan tipe 'admin' dapat mendownload file .CSV record surat masuk yang
			ada dalam database.
		</p>
		<p>Untuk pembuatan lembar tanda terima, dapat dilakukan dengan melakukan
			pencarian record tertentu atau dengan menentukan range ID surat masuk dalam
			database. Perlu dibedakan antara 'ID' dengan 'Nomor Agenda Seksi', meskipun
			pada awal penggunakan dua field bernilai sama, 'Nomor Agenda Seksi' akan
			dimulai ulang pada saat pergantian konfigurasi tahun, sementara 'ID' akan
			terus incremental.  			
		</p>
	</div>
</div>


@endsection