@section('suratkeluarlain_view')
	<div class="row span7">

		@if (User::is_user_allowed())
			<p>
				<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluarlain', 'Kembali ke Input Surat Keluar Lain', '') }}
				<span class="divider">|</span>
				<i class="icon-edit"></i> {{ HTML::link_to_route('edit_suratkeluarlain', 'Edit Surat', $suratkeluarlain->id) }}
			</p>
		@endif
			<table class="viewtable">
				<tr><th class="span3_5">Nomor Surat:</th><td> {{ $suratkeluarlain->nomor_surat }}</td>
				<tr><th>Tanggal:</th><td> {{ e($suratkeluarlain->tgl_surat) }}</td>
				<tr><th>Tujuan:</th><td> {{ e($suratkeluarlain->tujuan) }}</td>
				<tr><th>Hal:</th><td> {{ e($suratkeluarlain->hal) }}</td>
				<tr><th>Pengirim:</th><td> {{ e($suratkeluarlain->pengirim) }}</td>
				<tr><th>Perekam:</th><td> {{ e($suratkeluarlain->perekam) }}</td>
				<tr><th>Tanggal Rekam:</th><td> {{ $suratkeluarlain->created_at }}</td>
				<tr><th>Tanggal Update:</th><td> {{ $suratkeluarlain->updated_at }}</td>
			</table>
	</div>

	<div class="row vspace">
		<hr>
		{{ Form::open('suratkeluarlain/delete', 'DELETE', array('class'=>'pull-right')) }}
		{{ Form::token() }}
		{{ Form::hidden('id', $suratkeluarlain->id) }}
		{{ HTML::decode(Form::button('<i class="icon-trash icon-white"></i> Hapus Record Surat Ini !!', array('class'=>'btn-danger', 'type'=>'submit'))) }}
		{{ Form::close() }}
	</div>
@endsection