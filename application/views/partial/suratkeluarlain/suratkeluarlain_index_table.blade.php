@section('display_table')

	<h2>Daftar surat keluar lain yang terakhir diinput:</h2>

		<?php
			$pagination_generated = $suratkeluarlains->links();
			if ($pagination_generated != '') {
				echo '<div class="row">';
				echo '<div class="pull-left">' . $pagination_generated . '</div>';
				echo '</div>';
			}
		?>

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
			@foreach($suratkeluarlains->results as $suratkeluarlain)

				<?php
					// generate row pemisah antar tanggal perekaman
					$date_created = date_create_from_format('Y-m-d', substr($suratkeluarlain->created_at, 0, 10))->getTimestamp();
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
					<td>{{ e($suratkeluarlain->nomor_surat) }}</td>
					<td>{{ e($suratkeluarlain->tgl_surat) }}</td>
					<td>{{ e($suratkeluarlain->tujuan) }}</td>
					<td>{{ e($suratkeluarlain->hal) }}</td>
					<td>{{ e($suratkeluarlain->pengirim) }}</td>
					<td>{{ HTML::link_to_route('suratkeluarlain', 'Detail', array($suratkeluarlain->id)) }}</td>
				</tr>
			@endforeach

			@if (empty($suratkeluarlains->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk surat keluar lain...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
	</div>
@endsection