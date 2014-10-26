@layout('layouts.default')

@section('content')
	<div class="row">
			<h1>Halaman Bantuan</h1>
	</div>

	<div class="row">
		<ul class="nav-tabs">
			<li class="active">
				{{ HTML::link('#', 'Beranda') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_suratmasuk', 'Surat Masuk') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_suratkeluar', 'Surat Keluar') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_settings', 'Settings') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_faq', 'Tanya Jawab') }}
			</li>
	  </ul>
	</div>

	@include('partial.bantuan.bantuan_index')
	@yield('bantuan_index')

@endsection