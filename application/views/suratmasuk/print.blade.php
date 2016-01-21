@layout('layouts.alternate')

@section('content')
	<table class="tableprint">
		<thead>
			<tr>
				<th>#</th>
				@if (Konfigurasi::find(9)->config_value != 1)
					<th class="span2">NO. AGENDA SEKRE</th>
				@endif
				<th>NOMOR SURAT</th>
				<th>TANGGAL</th>
				<th>PERIHAL</th>
				<th>DISPOSISI</th>
				<th class="span1">PARAF</th>
			</tr>
		</thead>
		<tbody>

<?php

/**
 * Karena tabel yang dibuat akan memisahkan daftar penerima, maka row dibreak
 * menjadi array yang dapat diolah.
 * Untuk mengetahui hasil arraynya, bisa dilakukan print_r($db);
 */
// array database utama
$db = array();

// array untuk menyimpan record tiap row
$record = array();

// array untuk menyimpan nama disposisi yang dibreakdown dari string menjadi array
$daftar_disposisi = array();

$i = 0;
foreach ($suratmasuks->results as $row) {
	// save record to array
	$record['nomor_agenda_seksi'] = $row->nomor_agenda_seksi;
	$record['nomor_agenda_sekre'] = $row->nomor_agenda_sekre;
	$record['nomor_surat'] = $row->nomor_surat;
	$record['tgl_surat'] = $row->tgl_surat;
	$record['hal'] = $row->hal;
	$record['disposisi'] = explode(', ', (Suratmasuk::disposisi_id_to_name($row->disposisi)));

	// kumpulkan daftar disposisi unik untuk keperluan output html
	$daftar_disposisi = array_unique(array_merge($daftar_disposisi, $record['disposisi']));

	// save record to db
	$db[$i] = $record;
	$i++;
}


/**
 * Sebelum mengoutputkan content, dilakukan dulu penghitungan jumlah baris tiap
 * penerima surat. Jumlah tersebut kemudian digunakan untuk rowspan tabel.
 *     resultnya berupa $baris[x]
 */
foreach ($daftar_disposisi as $disposisi_key => $nama) {
	// initial jumlah baris
	$i = 1;

	foreach ($db as $key => $record) {
		// hitung jumlah baris terlebih dahulu
		if (in_array($nama, $record['disposisi'])) {
			$baris[$disposisi_key] = $i;
			$i++;
		}
	}
}

/**
 * Proses loopingnya sama seperti di atas, hanya saja sekarang sudah bisa
 * mengoutputkan content dengan menggunakan rowspan pada Nama dan Paraf.
 * Angka rowspan ini didapat dari loop di atas.
 */
foreach ($daftar_disposisi as $disposisi_key => $nama) {
	// initial counter baris
	$i = 1;

	foreach ($db as $key => $record) {
		// output content
		if (in_array($nama, $record['disposisi'])) {
			echo '<tr>';
				
			if ($baris[$disposisi_key] == 1) {
				echo '<td class="input-small extrapadding">' . $record['nomor_agenda_seksi'] . '</td>';
			} else {
				echo '<td class="input-small">' . $record['nomor_agenda_seksi'] . '</td>';
			}
			
			if (Konfigurasi::find(10)->config_value != 1) {
				echo '<td>' . $record['nomor_agenda_sekre'] . '</td>';
			}
			echo '<td class="span3_5">' . $record['nomor_surat'] . '</td>';
			echo '<td class="centered">' . $record['tgl_surat'] . '</td>';
			echo '<td>' . $record['hal'] . '</td>';
			
			if ($i == 1) {
				echo '<td rowspan="' . $baris[$disposisi_key] . '">' . $nama . '</td>';
				echo '<td rowspan="' . $baris[$disposisi_key] . '"></td>';
			}
			
			echo '</tr>';
			
			$i++;
		}
	}
}

?>		
		</tbody>
	</table>
@endsection