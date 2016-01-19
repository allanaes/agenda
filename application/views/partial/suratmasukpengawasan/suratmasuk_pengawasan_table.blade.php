@section('suratmasuk_pengawasan_table')
	<div class="row">	
		<h2>Daftar Pengawasan Surat</h2>

		@if($pengawasan_surat->links() != '')
			<div class="pull-left">{{ $pengawasan_surat->links() }}</div>
		@endif

		<table class="displaytable">
			<tr>
				<th>#</th>
				<th>Surat Masuk</th>
				<th>PIC</th>
				<th>Aktivitas</th>
				<th>Proses</th>
				<th>Ket.</th>
			</tr>

			<?php
				$j = 0;
			?>
			@foreach ($data_pengawasan as $row)
				@if($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>
				@endif
					<?php $j++ ?>
					<td class="align-center">{{ e($row['id']) }}</td>
					<td class="span5">
						<span class="text-red">{{ e($row['pengirim']) }}</span>
						<hr class="narrow-vspace">
						{{ e($row['nomor_surat']) }} <br>
						<span class="muted">Tanggal: </span>{{ e($row['tgl_surat']) }} <br>
						<span class="muted">Hal: </span>{{ e($row['hal']) }}
					</td>
					<td class="align-center"><span class="text-red">{{ e($row['pic']) }}</span></td>
					<td>
						<strong>{{ e($row['aktivitas']) }}</strong>
						<hr class="narrow-vspace">
						<span class="muted">Tanggal Aktivitas: </span>{{ e($row['tgl_aktivitas']) }} <br>
						<span class="muted">Jatuh Tempo: </span><span class="text-red">{{ e($row['tgl_jatuh_tempo']) }}</span>
					</td>
					<td class="align-center">{{ Suratmasukpengawasan::warna_teks($row['proses']) }}</td>
					<td class="align-right">{{ HTML::decode(HTML::link_to_route('aktivitas_suratmasuk', '<i class="icon-flag"></i>', array($row['id_surat_masuk']), array("class"=>"urlbtn", "title"=>"Lihat Aktivitas Surat"))) }}</td>
				</tr>
			@endforeach

			@if ($j == 0)
				 <tr>
				 	<td colspan="5"><em>belum ada aktivitas pengawasan untuk surat ini...</em><td>
				 </tr>
			@endif	

		</table>		
	</div>
@endsection