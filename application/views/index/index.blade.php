@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Beranda</h1>
	</div>

	@include('partial.index.index_suratmasuk')
	@yield('display_table_suratmasuk')

	@include('partial.index.index_suratkeluar')
	@yield('display_table_suratkeluar')

@endsection