@section('settings_disposisi')
	<div class="row span7">
		<h4>Daftar Disposisi</h4>
		<div class='row'>
			<div class="alert alert-info">
				<strong>Perhatian!</strong> Maksimum daftar disposisi AKTIF terbatas hanya 16 entri agar dalam pembuatan lembar disposisi, layout tidak broken. Untuk nama dengan status Nonaktif, akan dihilangkan pada saat penginputan surat baru dan pembuatan lembar disposisi.
			</div>
		</div>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Status Aktif</th>
			</thead>
			<tbody>
			@foreach($db_disposisi as $row)
				<?php
					if ($row->aktif) {
						echo '<tr>';
					} else {
						echo '<tr class="muted">';
					}
				?>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->nama) }}</td>
					<td>{{ e($row->nip) }}</td>
					<td><?php echo ($row->aktif) ? 'AKTIF' : 'NONAKTIF'; ?><span class="divider">|</span>{{ HTML::link_to_route('settings_disposisi_toggle', 'Ubah', $row->id) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<div class="bordered">
			{{ Form::open('settings/disposisi/add', 'POST', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('nama', 'Nama:')}}
			{{ Form::text('nama', '', array('class'=>'span3', 'placeholder'=>'NAMA')) }}
			{{ Form::label('nip', 'NIP:')}}
			{{ Form::text('nip', '', array('class'=>'span2', 'placeholder'=>'NIP')) }}
			{{ HTML::decode(Form::button('<i class="icon-plus icon-white"></i> Tambah', array('type'=>'submit'))) }}
			{{ Form::close() }}
		</div>

		<p><span class="text-red">Undo?</span> Silakan input ulang (<em>replace</em>) di sini apabila terjadi kesalahan saat menambahkan: <em>{{ e($last_added_disposisi) }}</em></p>

		<div class="bordered">
			{{ Form::open('settings/disposisi/update', 'PUT', array('class'=>'form')) }}
			{{ Form::token() }}
			{{ Form::label('nama', 'Nama:')}}
			{{ Form::text('nama', '', array('class'=>'span3', 'placeholder'=>'NAMA')) }}
			{{ Form::label('nip', 'NIP:')}}
			{{ Form::text('nip', '', array('class'=>'span2', 'placeholder'=>'NIP')) }}
			{{ HTML::decode(Form::button('<i class="icon-edit icon-white"></i> Update', array('type'=>'submit', 'class'=>'green'))) }}
			{{ Form::close() }}
		</div>
	</div>
@endsection