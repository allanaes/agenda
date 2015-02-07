@section('display_table')

	<h2>Daftar surat keluar seksi yang akan diimport:</h2>

	<div class="row">
		<p class="bordered-alert">PERHATIAN: Harap cek kembali daftar yang akan diimport.
			Apabila daftar dengan jumlah banyak ini telah terekam, akan merepotkan undo apabila
			daftar yang terekam tidak valid.</p>
	</div>

	<div class="row morevspace">
		<p class="bordered-ok">Jika tidak yakin, silakan: <i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluar', 'Kembali ke Surat Keluar Seksi') }}</p>
	</div>

	<div class="row">
		{{ Form::open('suratkeluar/import', 'POST', array('class'=>'pull-right')) }}
		{{ Form::token() }}
		{{ Form::hidden('csv_file', $csv_file) }}
		{{ Form::hidden('jenis', $input['jenis']) }}
		{{ Form::hidden('hal', $input['hal']) }}
		{{ Form::hidden('tanggal', $input['tanggal']) }}
		{{ Form::hidden('pengirim', $input['pengirim']) }}
		{{ HTML::decode(Form::button('<i class="icon-download-alt icon-white"></i> Lakukan Import Surat!', array('class'=>'btn-danger', 'type'=>'submit'))) }}
		{{ Form::close() }}
	</div>

	<div class="row morevspace">
		<hr>
		<table class='displaytable'>
			<thead>
				<tr>
					<th class="span4">Nomor Surat</th>
					<th class="span1">Tanggal</th>
					<th class="span3">Tujuan</th>
					<th>Hal</th>
					<th>Pengirim</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$nomor_surat = Jenissurat::find($input['jenis'])->jenis_surat . 'XXX' . Konfigurasi::find(3)->config_value . Konfigurasi::find(4)->config_value;
			?>
			@foreach($csv_rows as $suratkeluar)
				<tr>
					<td>{{ $nomor_surat }}</td>
					<td>{{ $input['tanggal'] }}</td>
					<td>{{ e($suratkeluar[0]) }}</td>
					<td>{{ $input['hal'] }}</td>
					<td>{{ Disposisi::find($input['pengirim'])->nama }}</td>
				</tr>
			@endforeach

			@if (empty($csv_rows))
				 <tr>
				 	<td colspan="5"><em>Warning: file kosong....</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection