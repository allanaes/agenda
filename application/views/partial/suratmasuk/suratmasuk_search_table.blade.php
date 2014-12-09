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
			<thead>
				<tr>
					<th class="right">ID</th>
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
			@foreach($suratmasuks->results as $suratmasuk)				
				@if($j % 2 == 0)
				<tr class="tr-alt">
				@else
				<tr>				
				@endif
					<?php $j++ ?>
					<td class="idfield">{{ e($suratmasuk->id) }}</td>
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

			@if (empty($suratmasuks->results))
				 <tr>
				 	<td colspan="5"><em>tidak ditemukan record untuk jenis surat tersebut...</em><td>
				 </tr>
			@endif		
			</tbody>
		</table>
		</div>
@endsection