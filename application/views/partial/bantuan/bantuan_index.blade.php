@section('bantuan_index')
<div class="span7 push-bottom">
	<div class="row">
		<h3>Overview</h3>
		<p>Selamat datang di halaman Bantuan Aplikasi Agenda Surat. Dokumen ini
		ditujukan sebagai pengenalan singkat dalam penggunaan aplikasi ini. 
		</p>

		<h3>Untuk siapa aplikasi ini?</h3>
		<p>Aplikasi ini dibuat sesuai dengan keperluan administrasi surat masuk-surat
		keluar pada Seksi di Kantor Pelayanan Pajak. Akan tetapi, dengan sedikit atau
		beberapa penyesuaian baik dari segi penggunaan ataupun modifikasi kode aplikasi ini
		sendiri, bukan tidak mungkin dapat digunakan di instansi lain.
		</p>

		<h3>Fitur</h3>
		<p>Fitur utama aplikasi ini adalah untuk mengadministrasikan surat masuk dan
		surat keluar. Namun, selain itu ditambahkan pula fitur pelengkap lainnya untuk
		memudahkan pengguna dalam pengadministrasiannya, seperti:
		<ul>
			<li>Pencarian Surat Masuk</li>
			<li>Pencarian Surat Keluar</li>
			<li>Pencetakan Lembar Disposisi</li>
			<li>Pencetakan Tanda Terima Surat Masuk</li>
			<li>Pencetakan Daftar Surat Keluar</li>
			<li>Penarikan Data (Download Data) Surat Masuk ke dalam Format .CSV</li>
			<li>Penarikan Data (Download Data) Surat Keluar ke dalam Format .CSV</li>
			<li>User Authentication dalam Penggunaan Aplikasi</li>
			<li>Multi User</li>
			<li>Guest mode untuk pencarian daftar Surat Masuk atau Surat Keluar.</li>
		</ul>
		</p>

		<h3>Catatan</h3>
		<p>Aplikasi ini didesain sefleksibel mungkin agar dapat digunakan di berbagai
			seksi (atau instansi). Akan tetapi, fleksibilitas aplikasi ini terbatas
			pada instansi sejenis. Akibatnya, seksi atau instansi lain mungkin saja tidak dapat
			merasakan manfaat dari aplikasi ini.
		</p>
		<p>Aplikasi ini juga didesain sekompatibel mungkin dengan berbagai browser
			dan sistem operasi. Tidak menutup kemungkinan, layout menjadi broken pada
			browser yang kurang mensupport aplikasi ini.
		</p>
		<p>Dalam hal keamaanan data, aplikasi ini menggunakan <em>user authentication</em> dalam
			penggunaannya. Untuk keamanan ekstra, pengguna diperkenankan melakukan modifikasi
			kode sumber dan diharapkan melakukan konfigurasi sesuai kebutuhan.</p>

		<h3>Kebutuhan Sistem</h3>
		<p><strong>Kebutuhan Sistem minimal untuk Pengguna:</strong><br />
			Browser: Internet Explorer 7, Mozilla Firefox 3.6.x, Opera, Chrome, atau
			browser lain yang kompatibel.<br />
			PDF Reader: Adobe Reader 6, atau reader lain yang kompatibel.<br />
			Resolusi Monitor: 1024x768 piksel.<br />
		</p>
		<p><strong>Kebutuhan Sistem minimal untuk Server:</strong><br />
			Apache: versi 2.2.x dengan <strong>mod_rewrite enabled</strong> (rewrite_module)<br />
			PHP: versi 5.3.x<br />
			MySQL: versi 5.5.x<br />
		</p>

		<h3>Lisensi Penggunaan</h3>
		<p>Aplikasi ini bebas disebarkan, digunakan, dan dimodifikasi sesuai kebutuhan. Akan tetapi,
			<strong>tidak diperkenankan</strong> mengkomersilkan baik secara langsung ataupun modified
			atas kode sumber aplikasi ini.<br>
		</p>

		<pre>
/**
 * Agenda Surat
 *
 * @author      <808320277>
 * @version     {{ Konfigurasi::versi() }} 
 * @link        http://twitter.com/allanaes
 * @lastupdated {{ substr(Konfigurasi::versi(), 6, 8) }} 
 *
 */
		</pre>

	</div>
</div>

@endsection