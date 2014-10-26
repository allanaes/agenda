@layout('layouts.alternate')

@section('content')
	<table class="tableprint">
		<thead>
			<tr>
				<th class="span3">NOMOR SURAT</th>
				<th>TANGGAL</th>
				<th class="span2">TUJUAN</th>
				<th>HAL</th>
				<th>PENGIRIM</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($suratkeluars as $row)
			<?php
				$nomor_surat = $row->jenis_surat .
							   '<span class="text-red">' . $row->nomor_urut . '</span>' .
							   $row->kode_surat .
							   $row->tahun;
			?>
			<tr>
				<td>{{ $nomor_surat }}</td>
				<td class="centered">{{ e($row->tgl_surat) }}</td>
				<td>{{ e($row->tujuan) }}</td>
				<td>{{ e($row->hal) }}</td>
				<td>{{ e($row->pengirim) }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	
@endsection