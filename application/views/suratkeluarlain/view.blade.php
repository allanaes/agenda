@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Detail Surat: {{ $suratkeluarlain->nomor_surat }}</h1>
	</div>
	<div class="row">
    <ul class="breadcrumb">
		<li>
			@if (User::is_user_allowed())
				{{ HTML::link_to_route('suratkeluarlain', 'Surat Keluar Lain')}} <span class="divider">/</span>
			@else
				{{ HTML::link_to_route('search_suratkeluarlain', 'Pencarian Surat Keluar Lain')}} <span class="divider">/</span>
			@endif
		</li>
	    <li class="active">Detail Surat</li>
    </ul>
  </div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratkeluarlain.suratkeluarlain_view_table')
	@yield('suratkeluarlain_view')

@endsection