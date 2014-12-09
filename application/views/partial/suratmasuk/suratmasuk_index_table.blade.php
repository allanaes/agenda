@section('display_table')
	<h2>Daftar surat masuk yang terakhir diinput:</h2>

	@if($suratmasuks->links() != '')
	<div class="row vspace">			
		{{ $suratmasuks->links() }}
	</div>
	@endif

	<div class='row'>
		<table class='displaytable'>
			<thead>
				<tr>
					<th>#</th>
					<th class="span4">Nomor Surat</th>
					<th class="span2">Tanggal Surat</th>
					<th>Pengirim</th>
					<th>Hal</th>
					<th class="span1_5">Ket.</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 1; // variabel initial untuk highlight row saat ada item baru diinput
			 	$j = 0; ?>
			@foreach($suratmasuks->results as $suratmasuk)				
				@if(($i == 1) && (Session::has('message')) )
				<tr class="alert">
				<?php $i++; // delete availability untuk highlight item baru jika sudah digunakan ?>
				@elseif($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>				
				@endif				
					<?php $j++ ?>
					<td>{{ e($suratmasuk->nomor_agenda_seksi) }}</td>
					<td>{{ e($suratmasuk->nomor_surat) }}</td>
					<td>{{ e($suratmasuk->tgl_surat) }}</td>
					<td>{{ e($suratmasuk->pengirim) }}</td>
					<td>{{ e($suratmasuk->hal) }}</td>
					<td>{{ HTML::link_to_route('suratmasuk', 'Detail', array($suratmasuk->id)) }}
						<span class="divider">|</span>
						{{ HTML::link_to_route('disposisi_suratmasuk', 'Print', array($suratmasuk->id)) }}
					</td>
				</tr>
			@endforeach

			@if (empty($suratmasuks->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk surat masuk...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection