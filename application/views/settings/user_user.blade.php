@layout('layouts.default')

@section('content')
	<div class="row">
			<h1>Settings</h1>
	</div>

	@include('layouts.alert_msg')
	@yield('alert_msg')
    
	<div class="row">
		@include('partial.settings.settings_user_user')
		@yield('settings_user')
	</div>
@endsection