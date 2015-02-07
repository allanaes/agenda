@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Cari / lihat surat keluar</h1>
	</div>

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li class="active">
				{{ HTML::link('#', 'Cari Surat Keluar Seksi') }}
			</li>
			<li>
				{{ HTML::link_to_route('search_suratkeluarlain', 'Cari Surat Keluar Lain') }}
			</li>
	  </ul>
	</div>

	@include('partial.suratkeluar.suratkeluar_search_form')
	@yield('display_form')

	@include('partial.suratkeluar.suratkeluar_search_table')
	@yield('display_table')
	
@endsection