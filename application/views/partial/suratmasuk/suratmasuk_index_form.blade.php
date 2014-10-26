@section('display_form')
	<div class="row">
		<div class="bordered">
			{{ Form::open('suratmasuk/create', 'POST', array('class'=>'form')) }}
				{{ Form::token() }}
				<table class="maxwidth">
					<tr>
						<td class="field span3_5">
							{{ Form::label('tgl_diterima', '* Tanggal Diterima:') }} 
						</td>
						<td>
							{{ Form::text('tgl_diterima', Input::old('tgl_diterima'), array('class'=>'span1_5 calendar')) }}
							<span class="help-inline">contoh: {{ date('d/m/Y') }}</span>
						</td>
						{{ render('common.bigdate') }}					
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('nomor_agenda_seksi', '* Nomor Agenda Seksi:') }} 
						</td>
						<td>
							{{ Form::text('nomor_agenda_seksi', $suratmasuks->nomor_agenda_seksi, array('class'=>'input-small', 'disabled'=>'')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('nomor_agenda_sekre', '* Nomor Agenda Sekre:') }} 
						</td>
						<td>
							{{ Form::text('nomor_agenda_sekre', Input::old('nomor_agenda_sekre'), array('class'=>'span4')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('nomor_surat', '* Nomor Surat:') }} 
						</td>
						<td>
							{{ Form::text('nomor_surat', Input::old('nomor_surat'), array('class'=>'span4')) }}
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('tgl_surat', '* Tanggal Surat:') }} 
						</td>
						<td>
							{{ Form::text('tgl_surat', Input::old('tgl_surat'), array('class'=>'span1_5 calendar')) }}
							<span>contoh: {{ date('d/m/Y') }}</span>
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('pengirim', '* Pengirim:') }} 
						</td>
						<td>
							{{ Form::text('pengirim', Input::old('pengirim'), array('class'=>'span6')) }}
						</td>
					</tr>

					<tr><td class="field">
						{{ Form::label('hal', '* Hal:') }} 
						</td><td>
							{{ Form::text('hal', Input::old('hal'), array('class'=>'span6')) }}
						</td>
					</tr>
							
					<tr>
						<td colspan="3"><hr></td>
					</tr>

					<tr>
						<td class="field vtop">
								{{ Form::label('disposisi', 'Disposisi:') }}		
						</td>
						<td>
							@foreach($suratmasuks->daftar_disposisi as $row)
								@if($row->aktif)
								<label>
									<input type="checkbox" id="disposisi" name="disposisi[]" value='{{ $row->id }}'>
										{{ e($row->nama) }}
								</label><br />
								@endif
							@endforeach
							{{ Form::label('lain_lain', 'Lain-lain:')}}
							{{ Form::text('lain_lain', '', array('class'=>'span4')) }}
						</td>
					</tr>

					<tr>
						<td class="field vtop">
								{{ Form::label('sifat', 'Sifat:') }}	
						</td>
						<td>
							@foreach($suratmasuks->daftar_sifat as $key => $value)
							<label>
								<input type="checkbox" name="sifat[]" value="{{ $key }}">
								{{ e($value)}}
							</label>
							@endforeach
						</td>
					</tr>
					<tr>
						<td class="field vtop">
								{{ Form::label('petunjuk', 'Petunjuk:') }}	
						</td>
						<td>
							@foreach($suratmasuks->daftar_petunjuk as $row)
								<label>
									<input type="checkbox" name="petunjuk[]" value='{{ $row->id }}'>
									{{ e($row->petunjuk) }}
								</label><br />
							@endforeach
						</td>
					</tr>

					<tr>
						<td class="field">
							{{ Form::label('copy', 'Copy Sebanyak:') }}					
						</td>
						<td>
							{{ Form::text('copy', '', array('class'=>'input-small')) }}

							{{ Form::label('catatan', 'Catatan:') }} 
							{{ Form::text('catatan', Input::old('catatan'), array('class'=>'span6')) }}					
						</td>
					</tr>

					<tr>
						<td class="field">
						</td>
						<td class="form-action">
							{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit', array('type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt', 'type'=>'reset'))) }}
						</td>
					</tr>

				</table>

			{{ Form::close() }}
		</div>
	</div>
@endsection