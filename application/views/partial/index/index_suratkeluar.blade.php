@section('display_table_suratkeluar')
	<h2>Daftar surat keluar seksi yang terakhir diinput:</h2>
	<div class="row morevspace">
		<table class="displaytable">
			<thead>
				<tr>
					<th class="span4">Nomor Surat</th>
					<th class="span1">Tanggal</th>
					<th class="span3">Tujuan</th>
					<th>Hal</th>
					<th>Pengirim</th>
					<th class="span1">Ket.</th>
				</tr>
			</thead>
			<tbody>
			<?php $j = 0; ?>
			<?php $db_surat_keluar = ($pagination_surat_keluar_locked) ? $suratkeluars : $suratkeluars->results; ?>
			@foreach($db_surat_keluar as $suratkeluar)
				<?php
					$nomor_surat = $suratkeluar->jenis_surat .
								   '<span class="text-red">' . $suratkeluar->nomor_urut . '</span>' .
								   $suratkeluar->kode_surat .
								   $suratkeluar->tahun;
				?>
				@if($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>				
				@endif
					<?php $j++ ?>
					<td>{{ $nomor_surat }}</td>
					<td>{{ e($suratkeluar->tgl_surat) }}</td>
					<td>{{ e($suratkeluar->tujuan) }}</td>
					<td>{{ e($suratkeluar->hal) }}</td>
					<td>{{ e($suratkeluar->pengirim) }}</td>
					<td>{{ HTML::link_to_route('suratkeluar', 'Detail', array($suratkeluar->id)) }}</td>
				</tr>
			@endforeach

			@if (empty($db_surat_keluar))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk surat keluar...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection