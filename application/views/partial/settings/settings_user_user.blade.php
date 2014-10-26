@section('settings_user')
	<div class="row span7">
		<h4>Edit Profile User // <span class="muted">{{ Auth::user()->fullname }}</h4>
		<div class="bordered">
			{{ Form::open('settings/user/reset', 'POST', array('class'=>'form')) }}
			{{ Form::hidden('id', Auth::user()->id) }}
			{{ Form::token() }}
				<table>
					<tr>
						<td class="field">{{ Form::label('username', 'Username:')}}</td>
						<td>{{ Form::text('username', Auth::user()->username, array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field">{{ Form::label('fullname', 'Full Name:')}}</td>
						<td>{{ Form::text('fullname', Auth::user()->fullname, array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field">{{ Form::label('password', 'Password:')}}</td>
						<td>{{ Form::password('password', array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field">{{ Form::label('password_confirmation', 'Konfirmasi Password:')}}</td>
						<td>{{ Form::password('password_confirmation', array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field"></td>
						<td>
							{{ HTML::decode(Form::button('<i class="icon-edit icon-white"></i> Update', array('class'=>'green', 'type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
						</td>
				</table>
			{{ Form::close() }}
		</div>
	</div>
@endsection