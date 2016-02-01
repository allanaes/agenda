@section('display_table')
	<h2>Daftar surat masuk:</h2>

	<div class='row'>
		{{ Form::open('suratmasuk/print', 'GET', array('class'=>'pull-right')) }}
		@foreach($suratmasuks->input as $key => $value)
		{{ Form::hidden($key, $value) }}
		@endforeach
		{{ HTML::decode(Form::button('<i class="icon-print icon-white"></i> Print tanda terima...', array('type'=>'submit', 'class'=>'green'))) }}
		{{ Form::close() }}

		@if($suratmasuks->links() != '')
			<div class="pull-left">{{ $suratmasuks->links() }}</div>
		@endif
	</div>

	<div class="row morevspace">
		<table class='displaytable'>
			<tr>
				<th class="right">ID</th>
				@if (Konfigurasi::find(9)->config_value != 1)
					<th>#</th>					
				@else
					<th>#</th>					
					<th class="span2">Nomor Agenda</th>
				@endif
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

			<?php
				$j = 0;
				$prev_date = '';
			?>
			@foreach($suratmasuks->results as $suratmasuk)
				<?php
					// generate row pemisah antar tanggal perekaman
					$date_created = date_create_from_format('Y-m-d', substr($suratmasuk->created_at, 0, 10))->getTimestamp();
					$created = date('d M Y', $date_created);
					if ($created != $prev_date) {
						echo '<tr><td colspan="7"><h6>&nbsp;' . $created .'</h6></td></tr>';
						$prev_date = $created;
					} else {
						$prev_date = $created;
					}
				?>
							
				@if($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>				
				@endif
					<?php $j++ ?>
					<td class="idfield">{{ e($suratmasuk->id) }}</td>
					@if (Konfigurasi::find(9)->config_value != 1)
						<td>{{ e($suratmasuk->nomor_agenda_seksi) }}</td>
					@else
						<td>{{ e($suratmasuk->nomor_agenda_seksi) }}</td>
						<td>{{ e($suratmasuk->nomor_agenda_sekre) }}</td>
					@endif
					<td>{{ e($suratmasuk->nomor_surat) }}</td>
					<td>{{ e($suratmasuk->tgl_surat) }}</td>
					<td>{{ e($suratmasuk->pengirim) }}</td>
					<td>{{ e($suratmasuk->hal) }}</td>					
					<td class="align-right">
						@if (User::is_user_allowed())
						{{ HTML::decode(HTML::link_to_route('aktivitas_suratmasuk', '<i class="icon-flag"></i>', array($suratmasuk->id), array("class"=>"urlbtn", "title"=>"Lihat Aktivitas Surat"))) }}
						@endif
						
						{{ HTML::decode(HTML::link_to_route('suratmasuk', '<i class="icon-info-sign"></i>', array($suratmasuk->id), array("class"=>"urlbtn", "title"=>"Lihat Detail Surat"))) }}
						
						@if (User::is_user_allowed())
						{{ HTML::decode(HTML::link_to_route('disposisi_suratmasuk', '<i class="icon-print"></i>', array($suratmasuk->id), array("class"=>"urlbtn", "title"=>"Cetak Lembar Disposisi"))) }}
						@endif
					</td>
				</tr>
			@endforeach

			@if (empty($suratmasuks->results))
				<tr>
					<td colspan="5"><em>tidak ditemukan record untuk jenis surat tersebut...</em><td>
				</tr>
			@endif
		</table>
		</div>
@endsection