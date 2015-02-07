@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Input Surat Keluar Lain</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	<div class="row navvspace">
		<ul class="nav-tabs">
			<li>
				{{ HTML::link_to_route('suratkeluar', 'Surat Keluar Seksi') }}
			</li>
			<li class="active">
				{{ HTML::link('#', 'Surat Keluar Lain') }}
			</li>
	  </ul>
	</div>

	@include('partial.suratkeluarlain.suratkeluarlain_preview_table')
	@yield('display_table')

@endsection