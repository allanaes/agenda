@section('settings_petunjuk')
	<div class="row span7">
		<h4>Daftar Petunjuk</h4>
		<div class='row'>
			<div class="alert alert-error">
				<strong>Penting!</strong> Petunjuk yang telah diinput lebih dulu tidak dapat lagi diubah. Silakan Undo/Replace apabila ada kesalahan sebelum menambahkan Petunjuk baru.
			</div>
		</div>
		<div class='row'>
			<div class="alert alert-info">
				<strong>Perhatian!</strong> Maksimum daftar petunjuk terbatas hanya 11 entri agar dalam pembuatan lembar disposisi, layout tidak broken.
			</div>
		</div>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Petunjuk</th>
			</thead>
			<tbody>
			@foreach($db_petunjuk as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ $row->petunjuk }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<div class="bordered">
			{{ Form::open('settings/petunjuk/add', 'POST', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('petunjuk', 'Petunjuk:')}}
			{{ Form::text('petunjuk', '', array('class'=>'span4', 'placeholder'=>'Petunjuk pelaksanaan...')) }}
			{{ HTML::decode(Form::button('<i class="icon-plus icon-white"></i> Tambah', array('type'=>'submit'))) }}
			{{ Form::close() }}
		</div>

		<p><span class="text-red">Undo?</span> Silakan input ulang (<em>replace</em>) di sini apabila terjadi kesalahan saat menambahkan: "<em>{{ $last_added_petunjuk }}</em>"</p>

		<div class="bordered">
			{{ Form::open('settings/petunjuk/update', 'PUT', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('petunjuk', 'Petunjuk:')}}
			{{ Form::text('petunjuk', '', array('class'=>'span4', 'placeholder'=>'Petunjuk pelaksanaan...')) }}
			{{ HTML::decode(Form::button('<i class="icon-edit icon-white"></i> Update', array('type'=>'submit', 'class'=>'green'))) }}
			{{ Form::close() }}
		</div>
	</div>
@endsection