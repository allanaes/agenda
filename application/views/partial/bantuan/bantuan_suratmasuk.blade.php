@section('bantuan_suratmasuk')
<div class="span7 push-bottom">
	<div class="row">
		<h3>Input Surat Masuk</h3>
		<h4>Workflow</h4>
		<p>Workflow atau alur kerja penggunaan Input Surat Masuk dapat bervariasi sesuai dengan
			kebiasaan masing-masing Seksi dengan tetap mengedepankan tertib administrasi. Beberapa
			gambaran workflow berikut bisa menjadi tambahan informasi bagi pengguna aplikasi ini.
		</p>
		<p><strong>#1. Quick and Dirty</strong></p>
		<blockquote>
			<p>Workflow berikut dipakai dengan mengedepankan kecepatan administrasi Surat Masuk:<br>
				1. Input Surat Masuk hanya field yang diharuskan (tanda *), field opsional seperti
				Disposisi, Sifat, Petunjuk, Copy, dan Catatan tidak perlu diisi.<br>
				2. Print Lembar Disposisi.<br>
				3. Atasan mendisposisikan Surat Masuk (Disposisi, Sifat, Petunjuk, Copy, dan Catatan pada
				Lembar Disposisi diisi tulis tangan oleh atasan).<br>
				4. Surat Masuk didistribusikan sesuai diposisi menggunakan buku ekspedisi (manual).
			</p>
			<p><strong>Kelebihan:</strong> cepat pengadministrasiannya.</p>
			<p><strong>Kekurangan:</strong> informasi disposisi, sifat, petunjuk, serta catatan tidak terekam dan fitur
				Print Tanda Terima tidak dimanfaatkan.</p>
		</blockquote>

		<p><strong>#2. Quick and Clean</strong></p>
		<blockquote>
			<p>Workflow berikut dipakai dengan tambahan langkah pada #1 Quick and Dirty:<br>
				1. Input Surat Masuk hanya field yang diharuskan (tanda *), field opsional seperti
				Disposisi, Sifat, Petunjuk, Copy, dan Catatan tidak perlu diisi.<br>
				2. Print Lembar Disposisi.<br>
				3. Atasan mendisposisikan Surat Masuk (Disposisi, Sifat, Petunjuk, Copy, dan Catatan pada
				Lembar Disposisi diisi tulis tangan oleh atasan).<br>
				4. Pelaksana mengedit Surat Masuk sesuai diposisi dari atasan (minimal diupdate
				field Disposisi-nya).<br>
				5. Print Tanda Terima menggunakan aplikasi ini dengan query yang paling mudah (misal mulai dari ID x).<br>
				6. Surat Masuk didistribusikan sesuai disposisi menggunakan Lembar Tanda Terima.<br>
				7. Lembar Tanda Terima diarsipkan pada ordner khusus.
			</p>
			<p><strong>Kelebihan:</strong> lumayan cepat pengadministrasiannya.</p>
			<p><strong>Kekurangan:</strong> tambahan pekerjaan untuk mengupdate/edit entry Surat Masuk.</p>
		</blockquote>

		<p><strong>#3. Clean</strong></p>
		<blockquote>
			<p>Workflow berikut dipakai karena menginginkan setiap informasi tersimpan dengan baik:<br>
				1. Input Surat Masuk field yang diharuskan (tanda *) oleh Pelaksana (atau Atasan bila perlu).<br>
				2. Field opsional seperti Disposisi, Sifat, Petunjuk, Copy, dan Catatan diisi oleh Atasan dengan
				menggunakan fungsi Edit Surat.<br>
				3. Pelaksana mencetak Lembar Disposisi.<br>
				4. Atasan memaraf pada Lembar Disposisi.<br>
				5. Pelaksana mendistribusikan Surat Masuk dengan menggunakan Tanda Terima aplikasi ini.<br>
				6. Lembar Tanda Terima diarsipkan pada ordner khusus.
			</p>
			<p><strong>Kelebihan:</strong> informasi disposisi terekam pada aplikasi.</p>
			<p><strong>Kekurangan:</strong> melibatkan atasan dalam pengadministrasian/penggunaan aplikasi ini.</p>
		</blockquote>

		<h4>Tips</h4>
		<p><strong>#1. Mempercepat pencetakan lembar disposisi.</strong></p>
		<p>Setting browser agar selalu mendownload file PDF (Save File). Contoh pada Firefox: Menu > Options >
			Applications > (search) PDF > (pilih) Save File.</p>
		<p>File PDF Lembar Disposisi yang tersimpan dapat dicetak sekaligus menggunakan aplikasi tambahan yang bisa
			meng-combine PDF. Menggunakan fungsi Print pada klik kanan Windows kadang membuat file dicetak tidak berurutan.</p>
		<p><strong>#2. Menggunakan AutoComplete.</strong></p>
		<p>Setting browser agar mengaktifkan fitur AutoComplete. Tidak tersedia pada browser Opera 12 ke bawah.</p>

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