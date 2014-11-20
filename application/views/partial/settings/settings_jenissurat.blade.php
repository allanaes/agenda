@section('settings_jenissurat')
	<div class="row span7">
		<h4>Daftar Jenis Surat</h4>
		<div class='row'>
			<div class="alert alert-error">
				<strong>Penting!</strong> Jenis Surat yang telah diinput lebih dulu tidak dapat lagi diubah. Silakan Undo/Replace apabila ada kesalahan sebelum menambahkan Jenis Surat baru.
			</div>
		</div>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Jenis Surat</th>
				<th>Aktif</th>
			</thead>
			<tbody>
			@foreach($db_jenis_surat as $row)
				<?php
					if ($row->aktif) {
						echo '<tr>';
					} else {
						echo '<tr class="muted">';
					}
				?>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->jenis_surat) }}</td>
					<td><?php echo ($row->aktif) ? 'AKTIF' : 'NONAKTIF'; ?><span class="divider">|</span>{{ HTML::link_to_route('settings_jenissurat_toggle', 'Ubah', $row->id) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<div class="bordered">
			{{ Form::open('settings/jenissurat/add', 'POST', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('jenis_surat', 'Jenis:')}}
			{{ Form::text('jenis_surat', '', array('class'=>'span1', 'placeholder'=>'JENIS-')) }}
			{{ HTML::decode(Form::button('<i class="icon-plus icon-white"></i> Tambah', array('type'=>'submit'))) }}
			{{ Form::close() }}
		</div>

		<p><span class="text-red">Undo?</span> Silakan input ulang (<em>replace</em>) di sini apabila terjadi kesalahan saat menambahkan: <em>{{ e($last_added_jenissurat) }}</em></p>

		<div class="bordered">
			{{ Form::open('settings/jenissurat/update', 'PUT', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('jenis_surat', 'Jenis:')}}
			{{ Form::text('jenis_surat', '', array('class'=>'span1', 'placeholder'=>'JENIS-')) }}
			{{ HTML::decode(Form::button('<i class="icon-edit icon-white"></i> Update', array('type'=>'submit', 'class'=>'green'))) }}
			{{ Form::close() }}
		</div>
	</div>
@endsection