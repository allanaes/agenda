@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Pengawasan Surat</h1>
	</div>

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li class="active">
				{{ HTML::link('#', 'Semua Pengawasan') }}
			</li>
			<li>
				{{ HTML::link('#', 'Dalam Proses') }}
			</li>
			<li>
				{{ HTML::link('#', 'Lewat Jatuh Tempo') }}
			</li>
			<li>
				{{ HTML::link_to_route('pengawasan_suratmasuk_selesai', 'Selesai') }}
			</li>
	  </ul>
	</div>

	<h4><i class="icon-tags"></i>&nbsp;<span class="muted">Jumlah: </span> {{ $pengawasan_surat->total }}</h4>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratmasukpengawasan.suratmasuk_pengawasan_table')
	@yield('suratmasuk_pengawasan_table')

@endsection