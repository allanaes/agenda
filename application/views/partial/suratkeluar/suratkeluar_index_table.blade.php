@section('display_table')
	@if(isset($suratkeluars->last_surat))
		<div class="row vspace">
			{{ Form::open('suratkeluar/delete', 'DELETE', array('class'=>'pull-right')) }}
			{{ Form::token() }}
			{{ HTML::decode(Form::button('<i class="icon-trash icon-white"></i> Undo / Batalkan surat nomor: ' . $suratkeluars->last_surat->jenis_surat . $suratkeluars->last_surat->nomor_urut . '...', array('class'=>'btn-danger', 'type'=>'submit'))) }}
			{{ Form::close() }}
		</div>
	@endif

	<h2>Daftar surat keluar yang terakhir diinput:</h2>

	<div class="row">			
		<?php
			$pagination_generated = $suratkeluars->appends(array('filter' => $suratkeluars->filter))->links();
			if ($pagination_generated != '') {
				echo '<div class="pull-left">' . $pagination_generated . '</div>';
			}
		?>

		<div class="pull-right">
			<?php
				$daftar_jenis_surat = array('all'=>'-SEMUA-');
				foreach ($suratkeluars->daftar_jenis as $daftar) {
					$daftar_jenis_surat += array($daftar->id => $daftar->jenis_surat);
				}
			?>
			{{ Form::open('suratkeluar', 'GET') }}
			{{ Form::select('filter', $daftar_jenis_surat, $suratkeluars->filter) }}
			{{ HTML::decode(Form::button('<i class="icon-filter icon-white"></i> Filter', array('type'=>'submit'))) }}
			{{ Form::close() }}
		</div>
	</div>

	<div class="row morevspace">
		<table class='displaytable'>
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
			<?php
				$i = 1; // variabel initial untuk highlight row saat ada item baru diinput
			 	$j = 0;
			 	$prev_date = ''; ?>
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
						echo '<tr> <td colspan="7"><h6> ' . $created .'</h6></td></tr>';
						$prev_date = $created;
					} else {
						$prev_date = $created;
					}
				?>

				@if(($i == 1) && (Session::has('message')) )
				<tr class="tr-alt alert">
				<?php $i++; // delete availability untuk highlight item baru jika sudah digunakan ?>
				@elseif($j % 2 == 0)
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

			@if (empty($suratkeluars->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk jenis surat tersebut...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection