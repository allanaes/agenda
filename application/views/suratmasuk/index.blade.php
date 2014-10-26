@layout('layouts.default')

@section('content')
	@include('partial.suratmasuk.suratmasuk_index_table')
	@yield('display_table')

	<div class='row'>
		<h1>Input Surat Masuk</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	@include('partial.suratmasuk.suratmasuk_index_form')
	@yield('display_form')
	
@endsection