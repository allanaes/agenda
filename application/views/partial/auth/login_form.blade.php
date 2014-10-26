@section('display_form')

	<div class="bordered">
		{{ Form::open('login/auth', 'POST', array('class'=>'form')) }}
			{{ Form::token() }}
			<table>

				<tr>
					<td class="field">
						{{ Form::label('username', 'Username:') }}
					</td>
					<td>
						{{ Form::text('username', '', array('class'=>'span4')) }}
					</td>
				</tr>

				<tr>
					<td class="field">
						{{ Form::label('password', 'Password:') }}
					</td>
					<td>
						{{ Form::password('password', array('class'=>'span4')) }}
					</td>
				</tr>

				<tr>
					<td class="field">
					</td>
					<td class="form-action">
						{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit', array('type'=>'submit'))) }}
						{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
					</td>
				</tr>
			</table>			
		{{ Form::close() }}
	</div>
@endsection