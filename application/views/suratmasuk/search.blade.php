@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Cari / Lihat Surat Masuk</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	@include('partial.suratmasuk.suratmasuk_search_form')
	@yield('display_form')

	@include('partial.suratmasuk.suratmasuk_search_table')
	@yield('display_table')
	
@endsection