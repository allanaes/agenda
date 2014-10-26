@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Detail Surat: {{ $suratkeluar->nomor_surat }}</h1>
	</div>
	<div class="row">
    <ul class="breadcrumb">
		<li>
			@if (User::is_user_allowed())
				{{ HTML::link_to_route('suratkeluar', 'Surat Keluar')}} <span class="divider">/</span>
			@else
				{{ HTML::link_to_route('search_suratkeluar', 'Pencarian Surat Keluar')}} <span class="divider">/</span>
			@endif
		</li>
	    <li class="active">Detail Surat</li>
    </ul>
  </div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratkeluar.suratkeluar_view_table')
	@yield('suratkeluar_view')

@endsection