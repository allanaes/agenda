@section('suratkeluar_view')
	<div class="row span7">

		@if (User::is_user_allowed())
			<p>
				<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluar', 'Kembali ke Input Surat Keluar', '') }}
				<span class="divider">|</span>
				<i class="icon-edit"></i> {{ HTML::link_to_route('edit_suratkeluar', 'Edit Surat', $suratkeluar->id) }}
			</p>
		@endif
			<table class="borderedtable">
				<tr><td class="span2">Nomor Surat:</td><td> {{ $suratkeluar->nomor_surat_alt }}</td>
				<tr><td>Tanggal:</td><td> {{ e($suratkeluar->tgl_surat) }}</td>
				<tr><td>Tujuan:</td><td> {{ e($suratkeluar->tujuan) }}</td>
				<tr><td>Hal:</td><td> {{ e($suratkeluar->hal) }}</td>
				<tr><td>Pengirim:</td><td> {{ e($suratkeluar->pengirim) }}</td>
				<tr><td>Perekam:</td><td> {{ e($suratkeluar->perekam) }}</td>
				<tr><td>Tanggal Rekam:</td><td> {{ $suratkeluar->created_at }}</td>
				<tr><td>Tanggal Update:</td><td> {{ $suratkeluar->updated_at }}</td>
			</table>
	</div>
@endsection