@section('suratkeluar_view')
	<div class="row span7">

		@if (User::is_user_allowed())
			<p>
				<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluar', 'Kembali ke Input Surat Keluar Seksi', '') }}
				<span class="divider">|</span>
				<i class="icon-edit"></i> {{ HTML::link_to_route('edit_suratkeluar', 'Edit Surat', $suratkeluar->id) }}
			</p>
		@endif
			<table class="viewtable">
				<tr><th class="span3_5">Nomor Surat:</th><td> {{ $suratkeluar->nomor_surat_alt }}</td>
				<tr><th>Tanggal:</th><td> {{ e($suratkeluar->tgl_surat) }}</td>
				<tr><th>Tujuan:</th><td> {{ e($suratkeluar->tujuan) }}</td>
				<tr><th>Hal:</th><td> {{ e($suratkeluar->hal) }}</td>
				<tr><th>Pengirim:</th><td> {{ e($suratkeluar->pengirim) }}</td>
				<tr><th>Perekam:</th><td> {{ e($suratkeluar->perekam) }}</td>
				<tr><th>Diupdate:</th><td> {{ e($suratkeluar->diupdate) }}</td>
				<tr><th>Tanggal Rekam:</th><td> {{ $suratkeluar->created_at }}</td>
				<tr><th>Tanggal Update:</th><td> {{ $suratkeluar->updated_at }}</td>
			</table>
	</div>
@endsection