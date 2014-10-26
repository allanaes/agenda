@section('settings_user')
	<div class="row span7">
		<h4>Daftar User Account</h4>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Username</th>
				<th>Fullname</th>
				<th>Tipe</th>
				<th>Ket.</th>
			</thead>
			<tbody>
			@foreach($db_user as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->username) }}</td>
					<td>{{ e($row->fullname) }}</td>
					<?php $row_tipe = array_keys($daftar_tipe, $row->tipe); ?>
					<td>{{ $row_tipe[0] }}</td>
					<td>{{ HTML::link_to_route('settings_user_edit', 'Edit', $row->id) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<h4>Tambah User Baru</h4>
		<div class="bordered">
			{{ Form::open('settings/user/add', 'POST', array('class'=>'form')) }}
			{{ Form::token() }}
				<table>
					<tr>
						<td class="field">{{ Form::label('username', 'Username:')}}</td>
						<td>{{ Form::text('username', '', array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field">{{ Form::label('fullname', 'Full Name:')}}</td>
						<td>{{ Form::text('fullname', '', array('class'=>'span4')) }}</td>
					</tr>
					<tr>
						<td class="field">{{ Form::label('tipe', 'Tipe:')}}</td>
						<td>{{ Form::select('tipe', $reversed_daftar_tipe) }}</td>
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
							{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit', array('type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
						</td>
				</table>
			{{ Form::close() }}
		</div>

		<h4>Edit Profile User // <span class="muted">{{ Auth::user()->fullname }}</span></h4>
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
						<td class="field">{{ Form::label('tipe', 'Tipe:')}}</td>
						<td>{{ Form::select('tipe', $reversed_daftar_tipe, Auth::user()->tipe) }}</td>
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