@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Input Surat Keluar Seksi</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li class="active">
				{{ HTML::link('#', 'Surat Keluar Seksi') }}
			</li>
			<li>
				{{ HTML::link_to_route('suratkeluarlain', 'Surat Keluar Lain') }}
			</li>
	  </ul>
	</div>

	@include('partial.suratkeluar.suratkeluar_preview_table')
	@yield('display_table')

@endsection