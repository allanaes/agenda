@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Input Surat Keluar</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	@include('partial.suratkeluar.suratkeluar_index_form_massal')
	@yield('display_form')

	@include('partial.suratkeluar.suratkeluar_index_table')
	@yield('display_table')

@endsection