@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Cari / lihat surat keluar</h1>
	</div>

	@include('partial.suratkeluar.suratkeluar_search_form')
	@yield('display_form')

	@include('partial.suratkeluar.suratkeluar_search_table')
	@yield('display_table')
	
@endsection