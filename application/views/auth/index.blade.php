@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Login Aplikasi Agenda Surat</h1>
	</div>

	<div class="login-form span6">
		@if(Session::has('error'))
			<div class='row'>
				<div class="alert alert-error">
					<strong>Error!</strong>	
					{{ Session::get('error') }}			
				</div>
			</div>
		@endif

		@include('layouts.alert_msg')
		@yield('alert_msg')

		@include('partial.auth.login_form')
		@yield('display_form')
	</div>
@endsection