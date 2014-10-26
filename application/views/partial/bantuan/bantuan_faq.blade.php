@section('bantuan_faq')
<div class="span7 push-bottom">
	<div class="row">
		<h3>Tanya Jawab Seputar Kendala Penggunaan Aplikasi</h3>
		<h4>Tentang Pencetakan Lembar Disposisi</h4>
		<p><strong>#1. Mengapa saat pertama kali akan mencetak lembar disposisi, Adobe Reader
			sangat lama membuka file PDF-nya?</strong></p>
		<blockquote>
			<p>Hal ini biasa terjadi saat browser baru dibuka dan belum digunakan untuk
				membuka file PDF. Oleh karena PDF reader dalam browser seperti Adobe Reader
				ini merupakan sebuah aplikasi tersendiri, maka saat pertama kali browser membuka
				file PDF, saat ini pula plugin Adobe Reader mulai diload ke dalam browser.
				Sehingga, akan terasa kurang responsif dan lama saat membuka file PDF. Berbeda
				setelahnya yang lebih cepat atau instan saat membuka file PDF berikutnya.
			</p>
		</blockquote>

		<p><strong>#2. Mengapa saat menggunakan PDF reader built-in pada Mozilla Firefox,
			tanda ceklis pada Lembar Disposisi berubah menjadi angka 4?</strong></p>
		<blockquote>
			<p>Mozilla Firefox mulai dari versi 19 sudah memiliki fitur built-in PDF reader/viewer.
				Akan tetapi, pada versi 19, text encoding-nya masih belum sempurna.
				Tanda ceklis pada Lembar Disposisi menggunakan font ZapfDingbats, yang mana
				tanda ceklis tebal pada font ini adalah angka 4 pada font lain.
			</p>
		</blockquote>

		<p><strong>#3. Terkait pertanyaan nomor #2 di atas, bagaimana solusinya?</strong></p>
		<blockquote>
			<p>Untuk saat ini lebih baik menggunakan plugin PDF reader seperti Adobe Reader atau
				Foxit Reader, cara mengaktifkannya:
				<ol>
					<li>Buka menu Options (Tools > Options)</li>
					<li>Pada tab Applications, dari daftar 'Content Type' cari 'Adobe Acrobat Document'
						atau 'Portable Document Format'</li>
					<li>Kemudian, ubah Actions-nya menjadi 'Use Adobe Acrobat in Firefox' (atau PDF
						Reader lain yang terintegrasi&ndash;dengan keterangan 'in Firefox'&ndash;bukan
						'Preview in Firefox')</li>
					<li>Normalnya, Firefox menjadi kurang responsif saat pertama kali meload plugin PDF reader. Trik
						agar tidak terlalu lama menunggu, silakan Back lalu buka kembali link PDF-nya
						(print lembar disposisi).</li>
				</ol>
				<strong>tambahan:</strong>
				<ol>
					<li>Biasanya, pada Firefox akan ada peringatan apabila menggunakan plugin PDF
						reader versi "jadul". Untuk tetap dapat menggunakannya, silakan pilih activate saja baik
						sementara atau permanen. Dapat juga dengan mengupdate plugin PDF reader ke versi
						lebih baru agar tidak lagi muncul warning.</li>
				</ol>
			</p>
		</blockquote>

		<p><strong>#4. Bagimana dengan PDF reader built-in yang ada pada browser Chrome?</strong></p>
		<blockquote>
			<p>Text encoding pada Chrome tidak ada masalah, tetapi apabila hasil
				pencetakannya dirasa kurang rapi, disarankan menggunakan PDF reader lain.
			</p>
		</blockquote>

		<p><strong>#5. Mengapa saat mengakses kembali URL file PDF Lembar Disposisi
			yang telah dibuat, saya mendapatkan error file tidak ditemukan?</strong></p>
		<blockquote>
			<p>PDF Lembar Disposisi digenerate dan disimpan terlebih dahulu dalam file lokal
				pada server sebelum akhirnya dibuka oleh browser. Oleh karena file PDF yang
				digenerate ini semakin menumpuk, maka dilakukan penghapusan terhadap file-file
				PDF tersebut. Proses penghapusannya sendiri dilakukan saat pengguna mengakses menu
				Input Surat Masuk dan saat Logout.
			</p>
		</blockquote>

		<p><strong>#6. Mengapa Lembar Disposisi dibuat menggunakan PDF, tidak langsung
			saja sebagai halaman web (HTML) sehingga mudah untuk dibuka dan dicetak?</strong></p>
		<blockquote>
			<p>Lembar Disposisi menggunakan PDF dengan tujuan konsistensi layout, berbeda
				dengan format HTML yang bergantung pada browser, ketersediaan font, dan settingan lainnya.
				Dengan menggunakan PDF, layout yang dihasilkan lebih fix dan penggunaan garis lebih tipis (tebal 0.01mm).
			</p>
		</blockquote>

		<p><strong>#7. Kalau diperhatikan, pada Lembar Disposisi, margin kiri dan margin kanan tidak
			sama lebarnya, benarkah?</strong></p>
		<blockquote>
			<p>Ya benar, margin kiri hanya 0.5cm sedangkan pada margin kanannya 1cm. Desainnya sengaja demikian
				dan memang dimaksudkan agar pengguna dapat lebih fokus ke konten pada bagian sebelah kiri dokumen. :)
			</p>
		</blockquote>

		<p><strong>#8. Lembar Disposisi menggunakan kertas A4, apakah bisa menggunakan
			kertas ukuran lain?</strong></p>
		<blockquote>
			<p>Saat melakukan pencetakan, ukuran kertas dapat diatur sesuai kebutuhan.
				Akan tetapi, PDF Lembar Disposisi yang digenerate tetap berukuran A4.
				Misalnya, lembar disposisi akan menggunakan kertas A5 (terlalu kecil, tidak
				direkomendasikan :), maka saat dialog printing, set output ke kertas A5 (pada menu
				Properties) dan nonaktifkan opsi "Auto-Center" (pada bagian Print-Handling) agar
				dokumen tetap rapih saat diprint dan margin atas tidak terbuang.
			</p>
		</blockquote>

		<p><strong>#9. [Tips] Batch print Lembar Disposisi: Apakah bisa dilakukan pencetakan Lembar Disposisi secara
			massal, misal untuk Surat Masuk nomor X sampai Y?</strong></p>
		<blockquote>
			<p>Singkatnya: bisa, tetapi butuh trik simpel untuk melakukannya. Saat ini memang belum disediakan otomatisasi
				pencetakan massal Lembar Disposisi, coba cara (manual) simpel berikut untuk melakukannya:
				<ol>
					<li>Gunakan browser Firefox (browser lain menyesuaikan).</li>
					<li>Set dulu Action Firefox untuk membuka file PDF ke <strong>Save File</strong>, agar sekali klik file
						PDF-nya langsung terdownload: <code>Menu -> Options -> Content -> search "pdf" -> ubah Action ke "Save File" -> OK</code>.</li>
					<li>Buka menu "Cari / print daftar surat masuk" di aplikasi Agenda Surat, query daftar surat masuk untuk mempercepat. Tetap gunakan fungsi Print, bedanya file PDF Lembar Disposisi akan didownload langsung oleh Firefox, tidak ditampilkan di browser atau PDF reader.</li>
					<li>Kemudian buka folder Download tempat semua file tersebut terdownload (Ctrl+J jika tidak hapal di mana tersimpannya).</li>
					<li>Di dalam folder Download tersebut banyak tersimpan PDF Lembar Disposisi yg tergenerate dan terdownload, pilih semua file
						kemudian klik kanan pilih Print.</li>
					<li>Biasanya untuk Windows 7, menu Print tidak akan muncul jika file terpilih lebih dari 15. Pilih dulu 15 file sekali print, kemudian lanjutkan untuk file-file berikutnya. Setting juga printer default agar hasil cetakan tepat sesuai keinginan.</li>
				</ol>
			</p>
		</blockquote>
		
		<h4>Tentang Surat Keluar</h4>		
		<p><strong>#9. Mengapa Kode Surat dan Tahun Surat pada Input Surat Keluar tidak bisa diedit dan khusus untuk Kode Surat mengapa hanya satu jenis saja?</strong></p>
		<blockquote>
			<p>Pertama, untuk Tahun Surat dalam form Input Surat Masuk memang tidak dapat diedit secara manual, tetapi dapat diubah dalam menu Settings (hanya Admin).
			</p>
			<p>Kedua, untuk Kode Surat saat ini hanya dibatasi menggunakan satu kode saja. Apabila multi Kode Surat ini dirasa sangat perlu, akan diusahakan update terhadap kode sumber untuk menambahkan fitur tersebut.
			</p>
		</blockquote>
		
		<p><strong>#10. Bagaimana untuk penomoran Surat Keluar dengan contoh surat nomor "S-002.BB/WPJ.22/KP.1408/2013"?</strong></p>
		<blockquote>
			<p>Pertama, untuk kode suratnya tetap menggunakan "/WPJ.22/KP.1408/". Sementara untuk jenis suratnya menggunakan "S.BB-". Sehingga pada aplikasi akan tercatat sebagai: "S.BB-2/WPJ.22/KP.1408/2013". Hal ini seharusnya tidak akan menjadi masalah karena pengguna tahu bahwa nomor surat "S.BB-2/WPJ.22/KP.1408/2013" sebenarnya dimaksudkan untuk "S-002.BB/WPJ.22/KP.1408/2013".
			</p>
			<p>Kedua, untuk penomoran surat dengan "leading zero", tidak disertakan fitur tersebut dalam aplikasi ini karena tidak semua Seksi membutuhkannya. Oleh karena itu, penambahan "leading zero" pada nomor surat hanya dilakukan pada nomor surat itu sendiri, tidak disertakan dalam fitur aplikasi ini.
			</p>
		</blockquote>
		
		<p><strong>#11. Saat mencetak Tanda Terima atau Daftar Surat Keluar, header tabel tidak
			memiliki border atas dan pada bagian bawah tabel ada border atau baris yang terpotong,
			bagaimana solusinya?</strong></p>
		<blockquote>
			<p>Apabila menggunakan browser Internet Explorer versi 7, ya permasalahan tersebut
				akan muncul. Solusi termudah adalah dengan menggunakan browser lain, seperti Internet Explorer yang
				lebih baru atau menggunakan Mozilla Firefox. Border atas pada header tabel saat print
				preview di Mozilla Firefox memang tidak nampak untuk halaman 2 dan seterusnya, tetapi
				saat diprint, border tersebut akan muncul.
			</p>
		</blockquote>
	</div>
</div>

@endsection