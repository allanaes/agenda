@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Pengawasan Surat: #{{ $suratmasuk->id }}</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratmasukaktivitas.suratmasuk_aktivitas_index')
	@yield('suratmasuk_aktivitas_index')

	@include('partial.suratmasukaktivitas.suratmasuk_aktivitas_table')
	@yield('suratmasuk_aktivitas_table')

@endsection