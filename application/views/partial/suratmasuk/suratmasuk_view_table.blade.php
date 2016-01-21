@section('suratmasuk_view')
	<div class="row span8">
		@if (User::is_user_allowed())
			<p>
				<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratmasuk', 'Kembali ke Input Surat Masuk', '') }}
				<span class="divider">|</span>
				<i class="icon-edit"></i> {{ HTML::link_to_route('edit_suratmasuk', 'Edit Surat', $suratmasuk->id) }}
				<span class="divider">|</span>
				<i class="icon-print"></i> {{ HTML::link_to_route('disposisi_suratmasuk', 'Print Lembar Disposisi', $suratmasuk->id) }}
				<span class="divider">|</span>
				<i class="icon-flag"></i> {{ HTML::link_to_route('aktivitas_suratmasuk', 'Aktivitas', array($suratmasuk->id)) }}
			</p>
		@endif

		<p>
			<i class="icon-chevron-left"></i>
			<?php
				$current_id = $suratmasuk->id;
				$prev_id = $current_id - 1;
				while (true) {
					if (is_object(Suratmasuk::find($prev_id))) {
						echo HTML::link_to_route('suratmasuk', 'Prev', array($prev_id));
						break;
					} else {
						echo "Prev";
						break;
					}
				}
			?>
			<span class="divider">|</span>
			<?php
				$current_id = $suratmasuk->id;
				$next_id = $current_id + 1;
				while (true) {
					if (is_object(Suratmasuk::find($next_id))) {
						echo HTML::link_to_route('suratmasuk', 'Next', array($next_id));
						break;
					} else {
						echo "Next";
						break;
					}
				}
			?>
			<i class="icon-chevron-right"></i>
		</p>

		<table class="viewtable">
			<tr><th class="span3_5">Tanggal Diterima:</th><td> {{ e($suratmasuk->tgl_diterima) }}</td></tr>
			@if (Konfigurasi::find(9)->config_value != 1)
				<tr><th>Nomor Agenda Seksi:</th><td> {{ e($suratmasuk->nomor_agenda_seksi) }}</td></tr>
				<tr><th>Nomor Agenda Sekre:</th><td> {{ e($suratmasuk->nomor_agenda_sekre) }}</td></tr>
			@else
				<tr><th>Nomor Agenda:</th><td> {{ e($suratmasuk->nomor_agenda_seksi) }}</td></tr>
			@endif
			<tr><th>Nomor Surat:</th><td> {{ e($suratmasuk->nomor_surat) }}</td></tr>
			<tr><th>Tanggal Surat:</th><td> {{ e($suratmasuk->tgl_surat) }}</td></tr>
			<tr><th>Pengirim:</th><td> {{ e($suratmasuk->pengirim) }}</td></tr>
			<tr><th>Hal:</th><td> {{ e($suratmasuk->hal) }}</td></tr>
			<tr><th>Disposisi:</th>
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
			<tr><th>Sifat:</th>
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
			<tr><th>Petunjuk:</th>
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
			<tr><th>Copy:</th><td> {{ e($suratmasuk->copy) }}</td></tr>
			<tr><th>Perekam:</th><td> {{ e($suratmasuk->perekam) }}</td></tr>
			<tr><th>Diupdate:</th><td> {{ e($suratmasuk->diupdate) }}</td></tr>
			<tr><th>Catatan:</th><td> {{ e($suratmasuk->catatan) }}</td></tr>
			<tr><th>Tahun Buku Agenda:</th><td> {{ e($suratmasuk->tahun_buku) }}</td></tr>
			<tr><th>Tanggal Rekam:</th><td> {{ $suratmasuk->created_at }}</td></tr>
			<tr><th>Tanggal Update:</th><td> {{ $suratmasuk->updated_at }}</td></tr>
		</table>
	</div>
@endsection