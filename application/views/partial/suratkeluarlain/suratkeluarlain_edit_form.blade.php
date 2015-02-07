@section('suratkeluarlain_edit')

	<div class='row morevspace'>
		<?php
			$id_surat = $suratkeluarlain->id;

			// placeholder untuk NOMOR SURAT
			$old_nomor_surat = Input::old('nomor_surat');
			$placeholder_nomor_surat = isset($old_nomor_surat) ? $old_tanggal : $suratkeluarlain->nomor_surat;

			// placeholder untuk TANGGAL surat			
			$old_tanggal = Input::old('tanggal');
			$placeholder_tanggal = isset($old_tanggal) ? $old_tanggal : $suratkeluarlain->tgl_surat;		

			// placeholder untuk PENGIRIM surat
			$old_pengirim = Input::old('pengirim');
			$placeholder_pengirim = isset($old_pengirim) ? $old_pengirim : $suratkeluarlain->id_pengirim;	

			// placeholder untuk TUJUAN
			$old_tujuan = Input::old('tujuan');
			$placeholder_tujuan = isset($old_tujuan) ? $old_tujuan : $suratkeluarlain->tujuan;	

			// placeholder untuk HAL surat
			$old_hal = Input::old('hal');
			$placeholder_hal = isset($old_hal) ? $old_hal : $suratkeluarlain->hal;
		?>

		<div class="bordered">
			{{ Form::open('suratkeluarlain/update', 'PUT', array('class'=>'form')) }}
				{{ Form::token() }}
				{{ Form::hidden('id', $id_surat) }}
				<table>
					
					<tr>
						<td class="field">
							{{ Form::label('nomor_surat', '*Nomor Surat:') }}
						</td>
						<td>
							{{ Form::text('nomor_surat', e($placeholder_nomor_surat), array('class'=>'span6')) }}
						</td>
					</tr>
					
					<tr>
						<td class="field">
							{{ Form::label('tanggal', '*Tanggal:') }} 
						</td>
						<td>
							{{ Form::text('tanggal', e($placeholder_tanggal), array('class'=>'span1_5 calendar')) }}
							<span>Format DD/MM/YYYY, contoh: {{ date('d/m/Y') }}</span>
						</td>
					</tr>

					<tr>
						<?php
							$daftar_pengirim = array();
							foreach($suratkeluarlain->daftar_disposisi as $daftar) {
								$daftar_pengirim += array($daftar->id => $daftar->nama);
							}
						?>
						<td class="field">
							{{ Form::label('pengirim', '*Pengirim:') }}		
						</td>
						<td>
							{{ Form::select('pengirim', $daftar_pengirim, $placeholder_pengirim) }}
						</td>
					</tr>
					
					<tr>
						<td class="field">
							{{ Form::label('tujuan', '*Tujuan:') }} 
						</td>
						<td>
							{{ Form::text('tujuan', e($placeholder_tujuan), array('class'=>'span6')) }}
						</td>
					</tr>
						
					<tr>
						<td class="field">
							{{ Form::label('hal', '*Hal:') }} 
						</td>
						<td>
							{{ Form::text('hal', e($placeholder_hal), array('class'=>'span6')) }}
						</td>
					</tr>
					
					<tr>
						<td class="field">
						</td>
						<td class="form-action">
						{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Update Surat Keluar Lain', array('class'=>'btn btn-warning', 'type'=>'submit'))) }}
						{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt', 'type'=>'reset'))) }}
						<span class="divider">|</span>
						<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluarlain', ' Batal', $suratkeluarlain->id) }}
						</td>
					</tr>
				</table>
			{{ Form::close() }}
		</div>
	</div>
@endsection