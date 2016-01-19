@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Aktivitas Surat: #{{ $suratmasuk->id }}</h1>
	</div>

	<div class="row">
		<ul class="breadcrumb">
			<li>
				{{ HTML::link_to_route('suratmasuk', 'Surat Masuk')}} <span class="divider">/</span>
			</li>
			<li class="active">Aktivitas Surat Masuk</li>
		</ul>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratmasukaktivitas.suratmasuk_aktivitas_index')
	@yield('suratmasuk_aktivitas_index')

	@include('partial.suratmasukaktivitas.suratmasuk_aktivitas_table')
	@yield('suratmasuk_aktivitas_table')

@endsection