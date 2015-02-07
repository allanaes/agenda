@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Cari / lihat surat keluar</h1>
	</div>

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li>
				{{ HTML::link_to_route('search_suratkeluar', 'Cari Surat Keluar Seksi') }}
			</li>
			<li class="active">
				{{ HTML::link('#', 'Cari Surat Keluar Lain') }}
			</li>
	  </ul>
	</div>

	@include('partial.suratkeluarlain.suratkeluarlain_search_form')
	@yield('display_form')

	@include('partial.suratkeluarlain.suratkeluarlain_search_table')
	@yield('display_table')
	
@endsection