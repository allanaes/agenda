@section('settings_konfigurasi')
	<div class="row span7">
		<h4>Konfigurasi Agenda Surat</h4>
		<div class="bordered">
			{{ Form::open('settings/konfigurasi/update', 'PUT', array('class'=>'form formblock')) }}
			{{ Form::token() }}
			@foreach($db_konfigurasi as $row)
				{{ Form::label($row->config_name, e($row->config_info) . ':') }}
				{{ Form::text($row->config_name, e($row->config_value), array('class'=>'span5')) }}
			@endforeach
			<p>
				{{ HTML::decode(Form::button('<i class="icon-edit icon-white"></i> Update', array('type'=>'submit', 'class'=>'btn-danger'))) }}
			</p>
			{{ Form::close() }}
		</div>
	</div>
@endsection