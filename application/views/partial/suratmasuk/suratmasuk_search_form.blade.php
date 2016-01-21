@section('display_form')
	<div class="row">
		<div class="bordered">
			{{ Form::open('suratmasuk/search', 'GET', array('class'=>'form')) }}
				<table class="maxwidth">
					<tr><td class="field">
						{{ Form::label('id_start', 'ID:') }} 
						</td><td>
							{{ Form::text('id_start', $suratmasuks->input['id_start'], array('class'=>'input-small')) }}
							<span>s.d.</span>
							{{ Form::text('id_end', $suratmasuks->input['id_end'], array('class'=>'input-small')) }}
						</td>
					</tr>

					<tr>
						<td class="field span3_5">
							{{ Form::label('tgl_diterima', 'Tanggal Diterima:') }} 
						</td>
						<td>
							{{ Form::text('tgl_diterima', $suratmasuks->input['tgl_diterima'], array('class'=>'span1_5 calendar')) }}
						</td>						
					</tr>

					<tr>
						<td class="field">
							@if (Konfigurasi::find(9)->config_value != 1)
								{{ Form::label('nomor_agenda_seksi', 'Nomor Agenda Seksi:') }}
							@else
								{{ Form::label('nomor_agenda_seksi', 'Nomor Agenda:') }}
							@endif
						</td>
						<td>
							{{ Form::text('nomor_agenda_seksi', $suratmasuks->input['nomor_agenda_seksi'], array('class'=>'input-small')) }}
						</td>
					</tr>

					@if (Konfigurasi::find(9)->config_value != 1)
						<tr>
							<td class="field">
								{{ Form::label('nomor_agenda_sekre', 'Nomor Agenda Sekre:') }} 
							</td>
							<td>
								{{ Form::text('nomor_agenda_sekre', $suratmasuks->input['nomor_agenda_sekre'], array('class'=>'span4')) }}
							</td>
						</tr>
					@else
						{{ Form::hidden('nomor_agenda_sekre', '') }}
					@endif

					<tr>
						<td class="field">
							{{ Form::label('nomor_surat', 'Nomor Surat:') }} 
						</td>
						<td>
							{{ Form::text('nomor_surat', $suratmasuks->input['nomor_surat'], array('class'=>'span4')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('tgl_surat', 'Tanggal Surat:') }} 
						</td>
						<td>
							{{ Form::text('tgl_surat', $suratmasuks->input['tgl_surat'], array('class'=>'span1_5 calendar')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('pengirim', 'Pengirim:') }} 
						</td>
						<td>
							{{ Form::text('pengirim', $suratmasuks->input['pengirim'], array('class'=>'span6')) }}
						</td>
					</tr>

					<tr><td class="field">
						{{ Form::label('hal', 'Hal:') }} 
						</td><td>
							{{ Form::text('hal', $suratmasuks->input['hal'], array('class'=>'span6')) }}
						</td>
					</tr>

					<tr>
						<td class="field vtop">
								{{ Form::label('disposisi', 'Disposisi:') }}		
						</td>
						<td>
							<?php
								$disposisi = array('' => '-SEMUA-');
								foreach($suratmasuks->daftar_disposisi as $daftar) {
									$disposisi += array($daftar->id => $daftar->nama);
								}
							?>
							{{ Form::select('disposisi', $disposisi, $suratmasuks->input['disposisi'], array('class'=>'margin-bottom')) }}		
						</td>
					</tr>
					<tr>				
						<td class="field">
							{{ Form::label('sort_order', 'Sort order:') }}		
						</td>
						<td>
							{{ Form::select('sort_order', array('asc'=>'Ascending', 'desc'=>'Descending'), $suratmasuks->input['sort_order']) }}
						</td>
					</tr>
					<tr><td class="field">
						{{ Form::label('limit', 'Limit:') }} 
						</td><td>
							{{ Form::text('limit', $suratmasuks->input['limit'], array('class'=>'input-small')) }}
							<span>[?] batas jumlah baris yang akan ditampilkan.</span>
						</td>
					</tr>					

					<tr>
						<td class="field">
						</td>
						<td class="form-action">
							{{ HTML::decode(Form::button('<i class="icon-search icon-white"></i> Cari', array('type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt', 'type'=>'reset'))) }}
						</td>
					</tr>
				</table>
			{{ Form::close() }}
		</div>
	</div>
@endsection