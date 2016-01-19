@section('suratmasuk_aktivitas_table')
	<?php
		/*
		* placeholder teks setiap input field untuk memudahkan input surat yg sama
		* baris Input::old('field') mengambil teks yang sama sebelumnya diinput apabila terjadi error
		* baris Session::get('field') mengambil teks dari SURAT SEBELUMNYA yg berhasil diinput
		*	 (teks dibawa bersama redirect di controller)
		*/

		// placeholder untuk TANGGAL AKTIVITAS 
		$oldinput_tgl_aktivitas = Input::old('tgl_aktivitas');
		$placeholder_tgl_aktivitas = empty($oldinput_tgl_aktivitas) ? date('d/m/Y') : $oldinput_tgl_aktivitas;
		if (Session::has('tgl_aktivitas')) {
			$placeholder_tgl_aktivitas = Session::get('tgl_aktivitas');
		}

		// placeholder untuk JATUH TEMPO 
		$placeholder_tgl_jatuh_tempo = Input::old('tgl_jatuh_tempo');
		if (Session::has('tgl_jatuh_tempo')) {
			$placeholder_tgl_jatuh_tempo = Session::get('tgl_jatuh_tempo');
		}

		// placeholder untuk AKTIVITAS 
		$placeholder_aktivitas = Input::old('aktivitas');
		if (Session::has('aktivitas')) {
			$placeholder_aktivitas = Session::get('aktivitas');
		}

		// placeholder untuk PIC
		$placeholder_pic = Input::old('pic');
		if (Session::has('pic')) {
			$placeholder_pic = Session::get('pic');
		}

		// placeholder untuk PROSES
		$placeholder_proses = Input::old('proses');
		if (Session::has('proses')) {
			$placeholder_proses = Session::get('proses');
		}

	?>


	<div class="row">
		<h2>Aktivitas Pengawasan Surat</h2>

		<table class="displaytable">
			<tr>
				<th>Tanggal</th>
				<th>Aktivitas</th>
				<th>PIC</th>
				<th>Jatuh Tempo</th>
				<th>Proses</th>
			</tr>

			<?php
				$j = 0;
			?>
			@foreach ($aktivitas as $row)
				@if($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>
				@endif
					<?php $j++ ?>
					<td>{{ e($row->tgl_aktivitas) }}</td>
					<td>{{ e($row->aktivitas) }}</td>
					<td>{{ e($row->pic) }}</td>
					<td>{{ e($row->tgl_jatuh_tempo) }}</td>
					<td>{{ e($row->proses) }}</td>
				</tr>
			@endforeach

			@if ($j == 0)
				 <tr>
				 	<td colspan="5"><em>belum ada aktivitas pengawasan untuk surat ini...</em><td>
				 </tr>
			@endif	

			<tr>
				<td colspan="5"><h3>Tambahkan aktivitas:</h3></td>
			<tr>

			{{ Form::open('suratmasuk/' . $suratmasuk->id . '/aktivitas/create', 'POST') }}
				{{ Form::token() }}
				{{ Form::hidden('id_surat_masuk', $suratmasuk->id)}}
				<tr>
					<td>{{ Form::label('tgl_aktivitas', 'Tanggal *') }}</td>
					<td>{{ Form::label('aktivitas', 'Aktivitas *') }}</td>
					<td>{{ Form::label('pic', 'PIC *') }}</td>
					<td>{{ Form::label('tgl_jatuh_tempo', 'Jatuh Tempo') }}</td>
					<td>{{ Form::label('proses', 'Proses *') }}</td>
				</tr>

				<tr>
					<td>{{ Form::text('tgl_aktivitas', $placeholder_tgl_aktivitas, array("class"=>"span1_5 calendar")) }}</td>
					<td>{{ Form::text('aktivitas', $placeholder_aktivitas, array("class"=>"span7")) }}</td>
					<td>{{ Form::text('pic', $placeholder_pic, array("class"=>"span3")) }}</td>
					<td>{{ Form::text('tgl_jatuh_tempo', $placeholder_tgl_jatuh_tempo, array("class"=>"span1_5 calendar")) }}</td>
					<td>{{ Form::select('proses', Suratmasukaktivitas::daftar_proses(), $placeholder_proses, array("class"=>"span2")) }}</td>
				</tr>
				<tr>
					<td colspan="5">{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Tambah', array('type'=>'submit'))) }}</h5></td>
				<tr>
			{{ Form::close() }}
		</table>		
	</div>
@endsection