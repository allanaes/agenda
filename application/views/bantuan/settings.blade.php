@layout('layouts.default')

@section('content')
	<div class="row">
			<h1>Halaman Bantuan</h1>
	</div>

	<div class="row">
		<ul class="nav-tabs">
			<li>
				{{ HTML::link_to_route('bantuan', 'Beranda') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_suratmasuk', 'Surat Masuk') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_suratkeluar', 'Surat Keluar') }}
			</li>
			<li class="active">
				{{ HTML::link('#', 'Settings') }}
			</li>
			<li>
				{{ HTML::link_to_route('bantuan_faq', 'Tanya Jawab') }}
			</li>
	  </ul>
	</div>

	@include('partial.bantuan.bantuan_settings')
	@yield('bantuan_settings')

@endsection