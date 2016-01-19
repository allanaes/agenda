@section('display_table')
	<h2>Daftar surat keluar seksi:</h2>
	
	<div class='row'>
		{{ Form::open('suratkeluar/print', 'GET', array('class'=>'pull-right')) }}
		@foreach($suratkeluars->input as $key => $value)
		{{ Form::hidden($key, $value) }}
		@endforeach
		{{ HTML::decode(Form::button('<i class="icon-print icon-white"></i> Print daftar surat...', array('type'=>'submit', 'class'=>'green'))) }}
		{{ Form::close() }}	

		@if($suratkeluars->links() != '')
			<div class="pull-left">{{ $suratkeluars->links() }}</div>
		@endif
	</div>

	<div class="row morevspace">
		<table class='displaytable'>
			<tr>
				<th class="span4">Nomor Surat</th>
				<th class="span1">Tanggal</th>
				<th class="span3">Tujuan</th>
				<th>Hal</th>
				<th>Pengirim</th>
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
			@foreach($suratkeluars->results as $suratkeluar)
				<?php
					$nomor_surat = $suratkeluar->jenis_surat .
								   '<span class="text-red">' . $suratkeluar->nomor_urut . '</span>' .
								   $suratkeluar->kode_surat .
								   $suratkeluar->tahun;
				?>

				<?php
					// generate row pemisah antar tanggal perekaman
					$date_created = date_create_from_format('Y-m-d', substr($suratkeluar->created_at, 0, 10))->getTimestamp();
					$created = date('d M Y', $date_created);
					if ($created != $prev_date) {
						echo '<tr> <td colspan="7"><h6>&nbsp;' . $created .'</h6></td></tr>';
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
					<td>{{ $nomor_surat }}</td>
					<td>{{ e($suratkeluar->tgl_surat) }}</td>
					<td>{{ e($suratkeluar->tujuan) }}</td>
					<td>{{ e($suratkeluar->hal) }}</td>
					<td>{{ e($suratkeluar->pengirim) }}</td>
					<td class="align-right">
						{{ HTML::decode(HTML::link_to_route('suratkeluar', '<i class="icon-info-sign"></i>', array($suratkeluar->id), array("class"=>"urlbtn", "title"=>"Lihat Detail Surat"))) }}

						@if (User::is_user_allowed())
							{{ HTML::decode(HTML::link_to_route('edit_suratkeluar', '<i class="icon-edit"></i>', array($suratkeluar->id), array("class"=>"urlbtn", "title"=>"Edit Surat"))) }}
						@endif
					</td>
				</tr>
			@endforeach

			@if (empty($suratkeluars->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk kriteria pencarian tersebut...</em><td>
				 </tr>
			@endif
		</table>
	</div>
@endsection