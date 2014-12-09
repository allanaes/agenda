@section('display_table_suratmasuk')
	<h2>Daftar surat masuk yang terakhir diinput:</h2>
	<div class="row morevspace">
		<table class="displaytable">
			<thead>
				<tr>
					<th>#</th>
					<th class="span4">Nomor Surat</th>
					<th class="span2">Tanggal Surat</th>
					<th>Pengirim</th>
					<th>Hal</th>
					@if (User::is_user_allowed())
						<th class="span1_5">Ket.</th>
					@else
						<th class="span1">Ket.</th>
					@endif
				</tr>
			</thead>
			<tbody>
			<?php $j = 0; ?>
			<?php $db_surat_masuk = ($pagination_surat_masuk_locked) ? $suratmasuks : $suratmasuks->results; ?>
			@foreach($db_surat_masuk as $suratmasuk)				
				@if($j % 2 == 0)
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
						@if (User::is_user_allowed())
							<span class="divider">|</span>
							{{ HTML::link_to_route('disposisi_suratmasuk', 'Print', array($suratmasuk->id)) }}
						@endif
					</td>
				</tr>
			@endforeach

			@if (empty($db_surat_masuk))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk surat masuk...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection