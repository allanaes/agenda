<?php

class Printpdf {

	/**
	 * Generate lembar disposisi menggunakan FPDF.
	 */
	public static function generate_lembar_disposisi($input) {

		$pdf = new Fpdf();
		/**
		 * TODO:
		 * Ubah posisi y dari perhitungan manual menjadi menggunakan GetY SetY
		 */
		$pdf->SetLineWidth(0.01); // 0.01mm

		// specify margin variables, dalam unit milimeter
		$margin_left = 5;
		$margin_top = 10;
		$margin_right = 10;

		$pdf->SetMargins($margin_left, $margin_top, $margin_right);
		$pdf->AddPage();

		$pdf->Image(URL::to_asset('img/logo.png'), $margin_left, $margin_top, 0, 25);

		// specify height variables
		$h1 = 6;
		$h2 = 1.5 * $h1;
		$h3 = 2 * $h1;

		/**
		 * Bagian Header
		 */
		$span1 = 30;
		$span2 = 40;
		$span3 = 50;
		$span4 = 60;

		/* line 1 */
		$pdf->SetFont('Times', 'B', 16);
		$pdf->Cell($span1, $h1, '');
		$pdf->Cell(160, $h1, 'Direktorat Jenderal Pajak', 0, 0, 'C');
		$pdf->Ln();

		/* line 2 */
		$pdf->SetFont('Times', 'B', 12);
		$pdf->Cell($span1, $h1, '');
		$pdf->Cell(160, $h1, strtoupper($input->nama_kpp), 0, 0, 'C');
		$pdf->Ln();

		/* line 3 */
		$pdf->Cell($span1, $h1, '');
		$pdf->Cell(160, $h1, $input->nama_seksi, 0, 0, 'C');

		$line_x1 = $margin_left + $span1; 
		$line_y1 = $margin_top + 3 * $h1;
		$line_x2 = 210 - $margin_right;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();

		/* line 4 */
		$pdf->SetFont('Times', '', 14);
		$pdf->Cell($span1, $h3, '');
		$pdf->Cell(160, $h3, 'LEMBAR DISPOSISI', 0, 0, 'C');

		$line_x1 = $margin_left + $span1 + 10; 
		$line_y1 = $margin_top + 3 * $h1 + $h2;
		$line_x2 = 210 - $margin_right - 10;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();

		/* line 5, blank line */
		$pdf->Cell(210 - $margin_left - $margin_right, $h3, '');
		$pdf->Ln();

		/**
		 * variable font size
		 */
		$font_size = 10;

		/* line 6 */
		// output label left
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Tanggal Diterima:');
		$pdf->SetFont('Arial', '', $font_size);
		
		$pdf->Cell($span4 + 10, $h2, Printpdf::full_tanggal($input->tgl_diterima));

		// divider
		$pdf->Cell(10, $h2, '');

		//output label right
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Nomor Agenda:');
		$pdf->SetFont('Arial', '', $font_size);

		// cek apakah nomor Agenda otomatis akan ikut dicetak?
		$tampilkan_nomor_agenda = Konfigurasi::find(8)->config_value;

		if ($tampilkan_nomor_agenda == 1) {
			$pdf->Cell($span4 + 5 - $margin_right, $h2, $input->nomor_agenda_seksi);
		} else {
			$pdf->Cell($span4 + 5 - $margin_right, $h2, '');			
		}
			

		// border-bottom dibuat secara manual agar posisinya bisa diatur dan tidak
		// dipengaruhi cell height
		// underline content left
		$line_x1 = $margin_left + $span1; 
		$line_y1 = $margin_top + 4 * $h1 + 2 * $h3 + 1;
		$line_x2 = $line_x1 + $span4 + 10;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);

		// underline content right
		$line_x1 = 210 - $margin_right - ($span4 + 5 - $margin_right); 
		$line_y1 = $line_y1;
		$line_x2 = 210 - $margin_right;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();

		/* line 7 */
		// output label left
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Nomor Surat:');
		$pdf->SetFont('Arial', '', $font_size);
		$pdf->Cell($span4 + 10, $h2, $input->nomor_surat);

		// divider
		$pdf->Cell(10, $h2, '');

		// print jika bukan Sekre --------------------------------------------------
		$is_sekre = Konfigurasi::find(9)->config_value;

		if ($is_sekre != 1) {
			// output label right
			$pdf->SetFont('Times', '', $font_size);
			$pdf->Cell($span1, $h2, 'No. Agenda Sekre:');
			$pdf->SetFont('Arial', '', $font_size);
			$pdf->Cell($span4 + 5 - $margin_right, $h2, $input->nomor_agenda_sekre);
		}

		// underline content left
		$line_x1 = $margin_left + $span1; 
		$line_y1 = $line_y1 + $h2;
		$line_x2 = $line_x1 + $span4 + 10;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);

		if ($is_sekre != 1) {
			// underline content right
			$line_x1 = 210 - $margin_right - ($span4 + 5 - $margin_right); 
			$line_y1 = $line_y1;
			$line_x2 = 210 - $margin_right;
			$line_y2 = $line_y1;
			$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		}
		$pdf->Ln();

		/* line 8 */
		// output label left
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Tanggal Surat:');
		$pdf->SetFont('Arial', '', $font_size);
		$pdf->Cell($span4 + 10, $h2, Printpdf::full_tanggal($input->tgl_surat));

		// underline content left
		$line_x1 = $margin_left + $span1; 
		$line_y1 = $line_y1 + $h2;
		$line_x2 = $line_x1 + $span4 + 10;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();

		/* line 9 */
		// output label left
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Nama Pengirim:');
		$pdf->SetFont('Arial', '', $font_size);
		$pdf->Cell(210 - $margin_right - $margin_left - $span1, $h2, strtoupper($input->pengirim));

		// underline content left
		$line_x1 = $margin_left + $span1; 
		$line_y1 = $line_y1 + $h2;
		$line_x2 = 210 - $margin_right;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();

		/* line 10 */
		// output label left
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($span1, $h2, 'Perihal:');
		$pdf->SetFont('Arial', '', $font_size);		
		$pdf->drawTextBox(strtoupper($input->hal), 210 - $margin_right - $margin_left - $span1, $h3 + $h1/2, 'L', 'T', 0, $h1/2);
		// underline content left
		$line_x1 = $margin_left + $span1; 
		$line_y1 = $line_y1 + $h3 + $h1/2 + 1;
		$line_x2 = 210 - $margin_right;
		$line_y2 = $line_y1;
		$pdf->Line($line_x1, $line_y1, $line_x2, $line_y2);
		$pdf->Ln();
		
		/* line 11 */
		$pdf->SetFont('Times', '', $font_size);
		$y = $line_y1 + $h3;
		$pdf->SetY($y);
		$pdf->SetStyle("em","Times","I",0,"0,0,0");
		$pdf->SetStyle("p","Times","N",$font_size,"0,0,0",0);
		$pdf->SetStyle("content","Arial","",0,"0,0,0");
		$pdf->SetStyle("strong","Times","B",0,"0,0,0");
		$pdf->WriteTag(210 - $margin_left - $margin_right, $h1, '<p>PERHATIAN: <em>Dilarang memisahkan sehelai surat pun dari berkas yang telah disusun.</em></p>', 0, 'C');
		
		/**
		 * line 12
		 * print daftar disposisi, daftar sifat, daftar petunjuk
		 */
		// set to correct y position
		$pdf->SetY($y + $h1);	
		
		// create 3 column
		$spacer = 1;
		$box_width = (210 - $margin_left - $margin_right - 2) / 2;
		
		// box_width akan dipakai untuk dua kolom
		$checkbox_width = 8;
		$box_text_width = $box_width - $checkbox_width;
		
		// save y position
		$save_y_position = $pdf->GetY();
		
		// print right box first
		$pdf->Cell($box_width + $spacer, $h1, ''); // padding-left hack :)
		$pdf->SetFont('Times', 'B', $font_size);
		$pdf->Cell($box_width, $h1, 'Ditujukan kepada:', 'LTR');		
		$pdf->Ln();
		/* iterasi */
		foreach($input->daftar_disposisi as $row) {
			if($row->aktif) {				
				// padding-left hack :)
				$pdf->Cell($box_width + $spacer, $h1, '');
							
				// draw checkbox
				Printpdf::draw_checkbox($pdf, in_array($row->id, $input->disposisi), $font_size, $h1, $checkbox_width);
		
				// print daftar nama
				$pdf->SetFont('Times', '', $font_size);
				$pdf->Cell($box_text_width, $h1, $row->nama, 'R');
					
				$pdf->Ln();
			}
		}
		
		// print daftar disposisi lain-lain
		if (!empty($input->lain_lain)) {
			// padding-left
			$pdf->Cell($box_width + $spacer, $h1, '');
			
			// draw checkbox
			Printpdf::draw_checkbox($pdf, true, $font_size, $h1, $checkbox_width);
			
			// print lain-lain
			$pdf->SetFont('Times', '', $font_size);
			$pdf->Cell($box_text_width, $h1, $input->lain_lain, 'R');
			$pdf->Ln();
		}
		
		// bottom space and border
		$pdf->Cell($box_width + $spacer, $h1, '');
		$pdf->Cell($box_width, $h1/2, '', 'RLB');
		$pdf->Ln();
		
		// save y position untuk reset posisi box catatan
		$catatan_box_y_position_1 = $pdf->GetY();
		
		// reset y position, print left box
		$pdf->SetY($save_y_position);
		$pdf->SetFont('Times', 'B', $font_size);
		$pdf->Cell($box_width, $h1, 'Sifat:', 'LTR');
		$pdf->Ln();		
		/* iterasi */
		$pdf->SetFont('Times', '', $font_size);
		foreach($input->daftar_sifat as $key => $value) {
			// draw checkbox
			Printpdf::draw_checkbox($pdf, in_array($key, $input->sifat), $font_size, $h1, $checkbox_width);
			
			// print daftar sifat
			$pdf->SetFont('Times', '', $font_size);
			$pdf->Cell($box_text_width, $h1, $value, 'R');
			$pdf->Cell($spacer, $h1, '', '');
			$pdf->Ln();
		}
		
		// continue print left box
		$pdf->SetFont('Times', 'B', $font_size);
		$pdf->Cell($box_width, $h1, 'Petunjuk:', 'LR');
		$pdf->Ln();		
		/* iterasi */
		$pdf->SetFont('Times', '', $font_size);
		foreach($input->daftar_petunjuk as $row) {
			// draw checkbox
			Printpdf::draw_checkbox($pdf, in_array($row->id, $input->petunjuk), $font_size, $h1, $checkbox_width);
			
			// print daftar petunjuk
			$pdf->SetFont('Times', '', $font_size);
			$pdf->Cell($box_text_width, $h1, $row->petunjuk, 'R');
			$pdf->Cell($spacer, $h1, '', '');
			$pdf->Ln();
		}
		
		// copy
		$dots = '........';
		if ($input->copy > 0) {
			$copy = '  ' . $input->copy . '  ';
			Printpdf::draw_checkbox($pdf, true, $font_size, $h1, $checkbox_width);
		} else {
			$copy = $dots;
			Printpdf::draw_checkbox($pdf, false, $font_size, $h1, $checkbox_width);
		}
		
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell($box_text_width, $h1, 'Perbanyak: ' . $copy . ' kali,  Asli ke: ' . $dots, 'R');
		$pdf->Ln();
		
		// bottom border
		$pdf->Cell($box_width, $h1/2, '', 'RLB');
		$pdf->Ln();
		
		// save y position untuk reset posisi box catatan
		$catatan_box_y_position_2 = $pdf->GetY();
		
		/* line 13 */
		// adjust y position
		
		$y = ($catatan_box_y_position_1 > $catatan_box_y_position_2) ? $catatan_box_y_position_1 : $catatan_box_y_position_2;
		$pdf->SetY($y + 1);
		
		// print box catatan
		$pdf->SetFont('Times', 'U', $font_size);
		$pdf->Cell(0, $h1, 'CATATAN:', 'LTR');
		$pdf->Ln();
		
		// save y position
		$y = $pdf->GetY();
		
		// print text catatan
		$pdf->SetFont('Arial', '', $font_size - 1);
		$pdf->drawTextBox(strtoupper($input->catatan), 210 - $margin_right - $margin_left, 'L', 'T', 1, $h1/2);
		
		// reset position, draw fake border
		$pdf->SetY($y);
		$pdf->Cell(0, $h3, '', 'LBR');
		$pdf->Ln();
		
		/* line 14 */
		// adjust y position
		$y = $pdf->GetY();
		$pdf->SetY($y + 2);
		
		// print field tambahan
		$pdf->SetFont('Times', '', $font_size);
		$pdf->Cell(0, 5, 'PENGELOLAAN PADA SEKSI TERKAIT:');
		$pdf->Ln();
		
		/* line 15 */
		// dua kolom hal yang sama
		$half_width = (210 - $margin_left - $margin_right) / 2;
		$hw = $half_width;
		$padding_right = 20;
		
		$pdf->SetFont('Times', 'B', $font_size);
		$pdf->Cell($half_width, 7, 'Diteruskan ke:');
		$pdf->Cell($half_width, 7, 'Diteruskan ke:');
		$pdf->Ln();
		
		$s1 = '1. Seksi: ';
		$s2 = '2. Diterima Seksi: ';
		$s3 = '3. Selesai diproses: ';
		$dot1 = str_repeat('.', 71);
		$dot2 = str_repeat('.', 56);
		$dot3 = str_repeat('.', 54);
		$w1 = $pdf->GetStringWidth($s1);
		$w2 = $pdf->GetStringWidth($s2);
		$w3 = $pdf->GetStringWidth($s3);
		
		$pdf->SetFont('Times', '', $font_size);
		
		// print text dengan dotted yang right-aligned
		$pdf->Cell($hw - ($hw - $w1) - $padding_right, 4, $s1);
		$pdf->Cell($hw - $w1, 4, $dot1, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Cell($hw - ($hw - $w1) - $padding_right, 4, $s1);
		$pdf->Cell($hw - $w1, 4, $dot1, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Ln();
		
		$pdf->Cell($hw - ($hw - $w2) - $padding_right, 4, $s2);
		$pdf->Cell($hw - $w2, 4, $dot2, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Cell($hw - ($hw - $w2) - $padding_right, 4, $s2);
		$pdf->Cell($hw - $w2, 4, $dot2, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Ln();
		
		$pdf->Cell($hw - ($hw - $w3) - $padding_right, 4, $s3);
		$pdf->Cell($hw - $w3, 4, $dot3, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Cell($hw - ($hw - $w3) - $padding_right, 4, $s3);
		$pdf->Cell($hw - $w3, 4, $dot3, 0, '', 'R');
		$pdf->Cell($padding_right, 4, '');
		$pdf->Ln();	
	
		
		// generate pdf ke folder 'public' subfolder 'pdf'
		$file_name = 'print' . time() . '.pdf';
		$output_path = Printpdf::pdf_folder_path() . $file_name; 
		$pdf->Output($output_path, 'F');

		return $file_name;
	}

	/**
	 * -HELPER-
	 * Mereturn string path ke folder 'pdf'
	 */
	public static function pdf_folder_path() {
		$folder_path = $GLOBALS['laravel_paths']['public'] . '/pdf/';

		return $folder_path;
	}

	/**
	 * -HELPER-
	 * Oleh karena setiap lembar disposisi digenerate dengan nama file berbeda,
	 * akibatnya akan tergenerate banyak file pdf.
	 * Agar tidak membanjiri isi folder, fungsi ini dipakai untuk mengkosongkan
	 * kembali isi folder 'pdf' :)
	 *
	 * Apabila aplikasi digunakan oleh banyak user secara bersamaan, apakah
	 * user X dapat menghapus lembar disposisi yang digenerate user Y?
	 * Ya dapat, karena lembar disposisi yang digenerate disimpan secara lokal
	 * dengan tujuan kompatibilitas antar browser. Oleh karena itu, menyimpan
	 * PDF lembar disposisi pada lokal disk bukanlah tujuan utama.
	 */
	public static function empty_pdf_folder() {
		// get path to pdf folder
		$folder_path = Printpdf::pdf_folder_path();

		// scan directory
		$files = scandir($folder_path);

		// unset current and parent directory
		unset($files[0]); // exclude current folder / .
		unset($files[1]); // exclude parent folder / ..
		unset($files[2]); // exclude git ignore

		// menghapus semua file pdf dalam folder tersebut
		foreach ($files as $key => $fname) {
			$full_path_to_file = Printpdf::pdf_folder_path() . $fname;
			unlink($full_path_to_file);
		}
	}
	
	/**
	 * -HELPER-
	 * Convert format tanggal: 01/02/2013 menjadi 01 FEBRUARI 2013 secara
	 * manual, tanpa setting ulang locale.
	 */
	public static function full_tanggal($tgl) {
		$tgl_timestamp = date_create_from_format('d/m/Y', $tgl)->getTimestamp();
		$hari = date('d', $tgl_timestamp);
		$bulan = date('n', $tgl_timestamp);
		$tahun = date('Y', $tgl_timestamp);
		
		switch ($bulan) {
			case 1:
				$bln = 'JANUARI';
				break;
			case 2:
				$bln = 'FEBRUARI';
				break;
			case 3:
				$bln = 'MARET';
				break;
			case 4:
				$bln = 'APRIL';
				break;
			case 5:
				$bln = 'MEI';
				break;
			case 6:
				$bln = 'JUNI';
				break;
			case 7:
				$bln = 'JULI';
				break;
			case 8:
				$bln = 'AGUSTUS';
				break;
			case 9:
				$bln = 'SEPTEMBER';
				break;
			case 10:
				$bln = 'OKTOBER';
				break;
			case 11:
				$bln = 'NOVEMBER';
				break;
			case 12:
				$bln = 'DESEMBER';
				break;
			default:
				$bln = '';
				break;
		}
		
		$tanggal = $hari . ' ' . $bln . ' ' . $tahun;
		return strtoupper($tanggal);
	}
	
	/**
	 * -HELPER-
	 * Membuat checkbox secara manual.
	 */	
	public static function draw_checkbox($pdf, $checked=false, $font_size=11, $height, $checkbox_width) {
			// prepare untuk drawing rectangle
			$r_width = 4;
			$r_height = $r_width;
			$x_pos = $pdf->GetX() + ((10 - $r_width) / 2) ; // adjust x position
			$y_pos = $pdf->GetY() + 1; // adjust y position
			
			$pdf->Rect($x_pos, $y_pos, $r_width, $r_height);			
			$pdf->SetFont('ZapfDingbats', '', $font_size + 3);
			
			// print check-mark kalau masuk dalam daftar disposisi
			if ($checked) {
				$pdf->Cell($checkbox_width, $height, '4', 'L', '', 'R');
			} else {
				$pdf->Cell($checkbox_width, $height, '', 'L', '', 'R');
			}
	}
}