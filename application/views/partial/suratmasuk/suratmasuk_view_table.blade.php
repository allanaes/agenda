@section('suratmasuk_view')
	<div class="row span7">
		@if (User::is_user_allowed())
			<p>
				<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratmasuk', 'Kembali ke Input Surat Masuk', '') }}
				<span class="divider">|</span>
				<i class="icon-edit"></i> {{ HTML::link_to_route('edit_suratmasuk', 'Edit Surat', $suratmasuk->id) }}
				<span class="divider">|</span>
				<i class="icon-print"></i> {{ HTML::link_to_route('disposisi_suratmasuk', 'Print Lembar Disposisi', $suratmasuk->id) }}
			</p>
		@endif

		<table class="borderedtable">
			<tr><td class="span3_5">Tanggal Diterima:</td><td> {{ e($suratmasuk->tgl_diterima) }}</td>
			<tr><td>Nomor Agenda Seksi:</td><td> {{ e($suratmasuk->nomor_agenda_seksi) }}</td>
			<tr><td>Nomor Agenda Sekre:</td><td> {{ e($suratmasuk->nomor_agenda_sekre) }}</td>
			<tr><td>Nomor Surat:</td><td> {{ e($suratmasuk->nomor_surat) }}</td>
			<tr><td>Tanggal Surat:</td><td> {{ e($suratmasuk->tgl_surat) }}</td>
			<tr><td>Pengirim:</td><td> {{ e($suratmasuk->pengirim) }}</td>
			<tr><td>Hal:</td><td> {{ e($suratmasuk->hal) }}</td>
			<tr><td>Disposisi:</td>
				<td>							
					@foreach ($suratmasuk->daftar_disposisi as $row)
						@if($row->aktif)
							@if (in_array($row->id, $suratmasuk->disposisi))
								<b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($row->nama) }}<br />
							@else
								<b class="checkbox"></b><span class="muted">{{ e($row->nama) }}</span><br />
							@endif
						@endif
					@endforeach

					Lain-lain: {{ e($suratmasuk->lain_lain) }}				
				</td>
			</tr>
			<tr><td>Sifat:</td>
				<td>			
					@foreach ($suratmasuk->daftar_sifat as $key => $value)
						@if (in_array($key, $suratmasuk->sifat))
						  <span class="inline-block"><b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($value) }}</span>
						@else
							<span class="inline-block"><b class="checkbox"></b><span class="muted">{{ e($value) }}</span></span>
						@endif
					@endforeach						
				</td>
			</tr>
			<tr><td>Petunjuk:</td>
				<td>							
					@foreach ($suratmasuk->daftar_petunjuk as $row)
						@if (in_array($row->id, $suratmasuk->petunjuk))
						  <b class="checkbox"><span class="ok">&#x2713;</span></b>{{ e($row->petunjuk) }}<br />
						@else
							<b class="checkbox"></b><span class="muted">{{ e($row->petunjuk) }}</span><br />
						@endif
					@endforeach						
				</td>
			</tr>
			<tr><td>Copy:</td><td> {{ e($suratmasuk->copy) }}</td>
			<tr><td>Catatan:</td><td> {{ e($suratmasuk->catatan) }}</td>
			<tr><td>Tahun Buku Agenda:</td><td> {{ e($suratmasuk->tahun_buku) }}</td>
			<tr><td>Tanggal Rekam:</td><td> {{ $suratmasuk->created_at }}</td>
			<tr><td>Tanggal Update:</td><td> {{ $suratmasuk->updated_at }}</td>
		</table>
	</div>
@endsection