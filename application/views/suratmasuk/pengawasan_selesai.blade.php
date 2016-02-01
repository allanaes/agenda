@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Pengawasan Surat</h1>
	</div>

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li>
				{{ HTML::link_to_route('pengawasan_suratmasuk', 'Semua Pengawasan') }}
			</li>
			<li>
				{{ HTML::link('#', 'Dalam Proses') }}
			</li>
			<li>
				{{ HTML::link('#', 'Lewat Jatuh Tempo') }}
			</li>
			<li class="active">
				{{ HTML::link('#', 'Selesai') }}
			</li>
	  </ul>
	</div>

	<h4><i class="icon-tags"></i>&nbsp;<span class="muted">Jumlah: </span> {{ $pengawasan_surat_selesai->total }}</h4>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	@include('partial.suratmasukpengawasan.suratmasuk_pengawasan_selesai_table')
	@yield('suratmasuk_pengawasan_selesai_table')

@endsection