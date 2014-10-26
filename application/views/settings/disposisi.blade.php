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
			<li class="active">
				{{ HTML::link('#', 'Daftar Disposisi') }}
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
			<li>
				{{ HTML::link_to_route('settings_liberation', 'Data Liberation') }}
			</li>
	  </ul>
	</div>

	<div class="row">
		@include('partial.settings.settings_disposisi')
		@yield('settings_disposisi')
	</div>
@endsection