@section('settings_index')
<div class="row">
	<div class="pull-table">
		<h4>Petunjuk</h4>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Petunjuk</th>
			</thead>
			<tbody>
			@foreach($db_petunjuk as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->petunjuk) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

	<div class="pull-table">
		<h4>Konfigurasi Agenda Surat</h4>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th class="span5">Nama Config</th>
				<th class="span5">Value</th>
			</thead>
			<tbody>
			@foreach($db_konfigurasi as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->config_info) }}</td>
					<td>{{ e($row->config_value) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="pull-table">
		<h4>Jenis Surat</h4>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Jenis Surat</th>
				<th>Status Aktif</th>
			</thead>
			<tbody>
			@foreach($db_jenis_surat as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->jenis_surat) }}</td>
					<td><?php echo ($row->aktif) ? 'AKTIF' : 'NONAKTIF'; ?></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

	<div class="pull-table">
		<h4>Disposisi</h4>
		<table class="borderedtable">
			<thead>
				<th>#</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Status Aktif</th>
			</thead>
			<tbody>
			@foreach($db_disposisi as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ e($row->nama) }}</td>
					<td>{{ e($row->nip) }}</td>
					<td><?php echo ($row->aktif) ? 'AKTIF' : 'NONAKTIF'; ?></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection