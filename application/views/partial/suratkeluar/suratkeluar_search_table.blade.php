@section('display_table')
	<h2>Daftar surat keluar:</h2>
	
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
			<thead>
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
			</thead>
			<tbody>
			@foreach($suratkeluars->results as $suratkeluar)
				<?php
					$nomor_surat = $suratkeluar->jenis_surat .
								   '<span class="text-red">' . $suratkeluar->nomor_urut . '</span>' .
								   $suratkeluar->kode_surat .
								   $suratkeluar->tahun;
				?>
				<tr>
					<td>{{ $nomor_surat }}</td>
					<td>{{ e($suratkeluar->tgl_surat) }}</td>
					<td>{{ e($suratkeluar->tujuan) }}</td>
					<td>{{ e($suratkeluar->hal) }}</td>
					<td>{{ e($suratkeluar->pengirim) }}</td>
					<td>{{ HTML::link_to_route('suratkeluar', 'Detail', array($suratkeluar->id)) }}
					@if (User::is_user_allowed())
					 	<span class="divider">|</span> 
						{{ HTML::link_to_route('edit_suratkeluar', 'Edit', array($suratkeluar->id)) }}</td>
					@endif
				</tr>
			@endforeach

			@if (empty($suratkeluars->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk kriteria pencarian tersebut...</em><td>
				 </tr>
			@endif			
			</tbody>
		</table>
	</div>
@endsection