@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Pengawasan Surat</h1>
	</div>

	<h4><i class="icon-tags"></i>&nbsp;<span class="muted">Jumlah: </span> {{ Suratmasukpengawasan::count() }}</h4>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratmasukpengawasan.suratmasuk_pengawasan_table')
	@yield('suratmasuk_pengawasan_table')

@endsection