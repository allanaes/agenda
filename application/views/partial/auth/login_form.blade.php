@section('display_form')

	<div class="row span7">
		<div class="bordered">
			{{ Form::open('login/auth', 'POST', array('class'=>'form')) }}
				{{ Form::token() }}
				<div class="login-label">
					{{ Form::label('username', 'Username') }}
				</div>
				<div class="login-input">
					{{ Form::text('username', '', array('class'=>'span5')) }}
				</div>
				<div class="login-label">
					{{ Form::label('password', 'Password') }}
				</div>
				<div class="login-input">
					{{ Form::password('password', array('class'=>'span5')) }}
				</div>
				<div class="login-action">
					{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit', array('type'=>'submit'))) }}
					{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
				</div>		
			{{ Form::close() }}
		</div>
	</div>
@endsection