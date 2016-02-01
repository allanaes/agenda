@section('display_form')
	<div class="row">
		<div class="bordered">
			{{ Form::open('suratmasuk/update', 'PUT', array('class'=>'form')) }}
				{{ Form::token() }}
				{{ Form::hidden('id', $suratmasuk->id) }}
				<table class="maxwidth">
					<tr>
						<td class="field span3_5">
							{{ Form::label('tgl_diterima', '* Tanggal Diterima:') }} 
						</td>
						<td>

							{{ Form::text('tgl_diterima', $suratmasuk->tgl_diterima, array('class'=>'span1_5 calendar')) }}
							<span class="help-inline">contoh: {{ date('d/m/Y') }}</span>
						</td>						
					</tr>

					<tr>
						<td class="field">
							@if (Konfigurasi::find(9)->config_value != 1)
								{{ Form::label('nomor_agenda_seksi', '* Nomor Agenda Seksi:') }}
							@else
								{{ Form::label('nomor_agenda_seksi', '* Nomor Urut:') }}
							@endif
						</td>
						<td>
							{{ Form::text('nomor_agenda_seksi', $suratmasuk->nomor_agenda_seksi, array('class'=>'input-small', 'disabled'=>'')) }}
						</td>
					</tr>

					@if (Konfigurasi::find(9)->config_value != 1)
					<tr>
						<td class="field">
							{{ Form::label('nomor_agenda_sekre', '* Nomor Agenda Sekre:') }} 
						</td>
						<td>
							{{ Form::text('nomor_agenda_sekre', $suratmasuk->nomor_agenda_sekre, array('class'=>'span4')) }}
						</td>
					</tr>
					@else
						<tr>
							<td class="field">
								{{ Form::label('nomor_agenda_sekre', '* Nomor Agenda Sekre:') }} 
							</td>
							<td>
								{{ Form::text('nomor_agenda_seksi', $suratmasuk->nomor_agenda_sekre, array('class'=>'span3', 'disabled'=>'')) }}
							</td>
						</tr>
					@endif

					<tr>
						<td class="field">
							{{ Form::label('nomor_surat', '* Nomor Surat:') }} 
						</td>
						<td>
							{{ Form::text('nomor_surat', $suratmasuk->nomor_surat, array('class'=>'span4')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('tgl_surat', '* Tanggal Surat:') }} 
						</td>
						<td>
							{{ Form::text('tgl_surat', $suratmasuk->tgl_surat, array('class'=>'span1_5 calendar')) }}
							<span>contoh: {{ date('d/m/Y') }}</span>
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('pengirim', '* Pengirim:') }} 
						</td>
						<td>
							{{ Form::text('pengirim', $suratmasuk->pengirim, array('class'=>'span6')) }}
						</td>
					</tr>

					<tr><td class="field">
						{{ Form::label('hal', '* Hal:') }} 
						</td><td>
							{{ Form::text('hal', $suratmasuk->hal, array('class'=>'span6')) }}
						</td>
					</tr>

					<tr>
						<td colspan="2"><hr></td>
					</tr>
					<tr>

					<tr>
						<td class="field vtop">
								{{ Form::label('disposisi', 'Disposisi:') }}		
						</td>
						<td>
							@foreach($suratmasuk->daftar_disposisi as $row)
								@if($row->aktif)
								<label>
									@if (in_array($row->id, $suratmasuk->disposisi))
										<input type="checkbox" checked="true" id="disposisi" name="disposisi[]" value='{{ $row->id }}'>
									  {{ e($row->nama) }}
									@else
										<input type="checkbox" id="disposisi" name="disposisi[]" value='{{ $row->id }}'>
										{{ e($row->nama) }}
									@endif
								</label><br />
								@endif
							@endforeach
							{{ Form::label('lain_lain', 'Lain-lain:')}}
							{{ Form::text('lain_lain', $suratmasuk->lain_lain, array('class'=>'span4')) }}
						</td>
					</tr>

						<td class="field vtop">
								{{ Form::label('sifat', 'Sifat:') }}	
						</td>
						<td>
							@foreach($suratmasuk->daftar_sifat as $key => $value)
								<label>
									@if (in_array($key, $suratmasuk->sifat))
										<input type="checkbox" checked="true" id="sifat" name="sifat[]" value='{{ $key }}'>
									  {{ e($value) }}
									@else
										<input type="checkbox" id="sifat" name="sifat[]" value='{{ $key }}'>
										{{ e($value) }}
									@endif
								</label>
							@endforeach
						</td>
					</tr>
					<tr>
						<td class="field vtop">
								{{ Form::label('petunjuk', 'Petunjuk:') }}	
						</td>
						<td>
							@foreach($suratmasuk->daftar_petunjuk as $row)
								<label>
									@if (in_array($row->id, $suratmasuk->petunjuk))
										<input type="checkbox" checked="true" id="petunjuk" name="petunjuk[]" value='{{ $row->id }}'>
									  {{ e($row->petunjuk) }}
									@else
										<input type="checkbox" id="petunjuk" name="petunjuk[]" value='{{ $row->id }}'>
										{{ e($row->petunjuk) }}
									@endif
								</label><br />
							@endforeach
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('copy', 'Copy Sebanyak:') }}					
						</td>
						<td>
							{{ Form::text('copy', $suratmasuk->copy, array('class'=>'input-small')) }}

							{{ Form::label('catatan', 'Catatan:') }} 
							{{ Form::text('catatan', $suratmasuk->catatan, array('class'=>'span6')) }}					
						</td>
					</tr>

				<tr>
					<td class="field">
					</td>
					<td class="form-action">
						{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Update Surat Masuk', array('type'=>'submit'))) }}
						{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt', 'type'=>'reset'))) }}
						<span class="divider">|</span>
						<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratmasuk', ' Batal', $suratmasuk->id) }}
					</td>
				</tr>

				</table>
			{{ Form::close() }}
		</div>
	</div>
@endsection