@layout('layouts.default')

@section('content')
	<div class="row">
			<h1>Settings</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	<div class="row">
		<ul class="nav nav-tabs">
			<li>
				{{ HTML::link_to_route('settings', 'Index Settings') }}
			</li>
			<li>
				{{ HTML::link_to_route('settings_jenissurat', 'Daftar Jenis Surat') }}
			</li>
			<li>
				{{ HTML::link_to_route('settings_disposisi', 'Daftar Disposisi') }}
			</li>
			<li>
				{{ HTML::link_to_route('settings_petunjuk', 'Daftar Petunjuk') }}
			</li>
			<li>
				{{ HTML::link_to_route('settings_user', 'Daftar User Account') }}
			</li>
			<li>
				{{ HTML::link_to_route('settings_konfigurasi', 'Konfigurasi Agenda Surat') }}
			</li>
			<li class="active">
				{{ HTML::link('#', 'Data Liberation') }}
			</li>
		</ul>
	</div>
	
	<div class="row push-bottom">
		<h4>Download Data Surat Masuk</h4>
		<p class="indented"><i class="icon-download"></i> {{ HTML::link_to_route('settings_liberation_suratmasuk', 'Download .CSV') }}</p>
	</div>
		
	<div class="row">
		<h4>Download Data Surat Keluar Seksi</h4>
		<p class="indented"><i class="icon-download"></i> {{ HTML::link_to_route('settings_liberation_suratkeluar', 'Download .CSV') }}</p>
	</div>

	<div class="row">
		<h4>Download Data Surat Keluar Lain</h4>
		<p class="indented"><i class="icon-download"></i> {{ HTML::link_to_route('settings_liberation_suratkeluarlain', 'Download .CSV') }}</p>
	</div>
@endsection