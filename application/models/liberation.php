<?php

class Liberation extends Eloquent {
	
	/**
	 * Mengquery database suratmasuk dan mengoutputkannya ke file CSV.
	 */
	public static function liberation_suratmasuk() {
		// output headers so that the file is downloaded rather than displayed
		$filename = 'data_suratmasuk_' . date('Y') . '_' . date('m') . '_' . date('d') .
			'_' . date('H') . date('i') . date('s');

		header('Content-Type: text/csv; charset=utf-8');
		header("Content-disposition: attachment; filename=$filename.csv");
		

		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// fetch data surat masuk
		$db = Suratmasuk::get();
		
		// output the column headings
		$headings = array(
			'id',
			'nomor_agenda_seksi',
			'tgl_diterima',
			'nomor_agenda_sekre',
			'nomor_surat',
			'tgl_surat',
			'pengirim',
			'hal',
			'disposisi',
			'lain_lain',
			'sifat',
			'petunjuk',
			'copy',
			'catatan',
			'created_at',
			'updated_at'
		);

		// output dulu headingnya
		fputcsv($output, $headings, ';');
		
		/**
		 * catatan: kolom petunjuk tidak diconvert ke stringnya
		 */
		 
		// loop over the rows, outputting them
		foreach($db as $record) {
			// convert id ke stringnya
			// 1. Convert Disposisi
			$nama_disposisi = Suratmasuk::disposisi_id_to_name($record->disposisi);			
			
			// 2. Convert Sifat, daftar sifat sudah bertipe array
			$daftar_sifat = Suratmasuk::daftar_sifat();
			$array_sifat = explode(',', $record->sifat);

			foreach($array_sifat as $key => $value) {
				if (strlen($array_sifat[$key])){
					$array_sifat[$key] = $daftar_sifat[$value];					
				} else {
					// empty array
					$array_sifat = array();
				}
			}

			$sifat = implode(', ', $array_sifat);
			 
			
			// save record ke array
			$row = array(
				$record->id,
				$record->nomor_agenda_seksi,
				$record->tgl_diterima,
				$record->nomor_agenda_sekre,
				$record->nomor_surat,
				$record->tgl_surat,
				$record->pengirim,
				$record->hal,
				$nama_disposisi,
				$record->lain_lain,
				$sifat,
				$record->petunjuk,
				$record->copy,
				$record->catatan,
				$record->created_at,
				$record->updated_at
			);

			// output row per surat
			fputcsv($output, $row, ';');
		}
	}
	
	/**
	 * Mengquery database suratkeluar dan mengoutputkannya ke file CSV.
	 */
	public static function liberation_suratkeluar() {
		// output headers so that the file is downloaded rather than displayed
		$filename = 'data_suratkeluar_' . date('Y') . '_' . date('m') . '_' . date('d') .
			'_' . date('H') . date('i') . date('s');

		header('Content-Type: text/csv; charset=utf-8');
		header("Content-disposition: attachment; filename=$filename.csv");
		

		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// fetch data surat masuk
		$db = Suratkeluar::get();
		
		// output the column headings
		$headings = array(
			'id',
			'jenis_surat',
			'nomor_urut',
			'kode_surat',
			'tahun',
			'tgl_surat',
			'tujuan',
			'hal',
			'pengirim',
			'perekam',
			'created_at',
			'updated_at'
		);

		// output dulu headingnya
		fputcsv($output, $headings, ';');

		// loop over the rows, outputting them
		foreach($db as $record) {
			$row = array(
				$record->id,
				$record->jenis_surat,
				$record->nomor_urut,
				$record->kode_surat,
				$record->tahun,
				$record->tgl_surat,
				$record->tujuan,
				$record->hal,
				$record->pengirim,
				$record->perekam,
				$record->created_at,
				$record->updated_at				
			);

			// output row per surat
			fputcsv($output, $row, ';');
		}
	}
}