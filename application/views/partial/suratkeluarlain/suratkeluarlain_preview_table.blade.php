@section('display_table')

	<h2>Daftar surat keluar lain yang akan diimport:</h2>

	<div class="row">
		<p class="bordered-alert">PERHATIAN: Harap cek kembali daftar yang akan diimport.
			Apabila daftar dengan jumlah banyak ini telah terekam, akan merepotkan penghapusan apabila
			daftar yang terekam tidak valid.</p>
	</div>

	<div class="row morevspace">
		<p class="bordered-ok">Jika tidak yakin, silakan: <i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluarlain', 'Kembali ke Surat Keluar Lain') }}</p>
	</div>

	<div class="row">
		{{ Form::open('suratkeluarlain/import', 'POST', array('class'=>'pull-right')) }}
		{{ Form::token() }}
		{{ Form::hidden('csv_file', $csv_file) }}
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
			@foreach($csv_rows as $suratkeluarlain)
				<tr>
					<td>{{ e($suratkeluarlain[0]) }}</td>
					<td>{{ e($suratkeluarlain[1]) }}</td>
					<td>{{ e($suratkeluarlain[2]) }}</td>
					<td>{{ e($suratkeluarlain[3]) }}</td>
					<td>{{ e($suratkeluarlain[4]) }}</td>
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