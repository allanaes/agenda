@layout('layouts.default')

@section('content')
	<div class='row'>
			<h1>Detail Surat: #{{ $suratmasuk->id }}</h1>
	</div>
	<div class="row">
		<ul class="breadcrumb">
			<li>
				@if (User::is_user_allowed())
					{{ HTML::link_to_route('suratmasuk', 'Surat Masuk')}} <span class="divider">/</span>
				@else
					{{ HTML::link_to_route('search_suratmasuk', 'Pencarian Surat Masuk')}} <span class="divider">/</span>
				@endif
			</li>
			<li class="active">Detail Surat</li>
		</ul>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
	
	@include('partial.suratmasuk.suratmasuk_view_table')
	@yield('suratmasuk_view')

@endsection