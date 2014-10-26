@section('suratkeluar_edit')
	<div class='row'>
		<?php
			$id_surat = $suratkeluar->id;

			// placeholder untuk TANGGAL surat			
			$old_tanggal = Input::old('tanggal');
			$placeholder_tanggal = isset($old_tanggal) ? $old_tanggal : $suratkeluar->tgl_surat;		

			// placeholder untuk PENGIRIM surat
			$old_pengirim = Input::old('pengirim');
			$placeholder_pengirim = isset($old_pengirim) ? $old_pengirim : $suratkeluar->id_pengirim;	

			// placeholder untuk TUJUAN
			$old_tujuan = Input::old('tujuan');
			$placeholder_tujuan = isset($old_tujuan) ? $old_tujuan : $suratkeluar->tujuan;	

			// placeholder untuk HAL surat
			$old_hal = Input::old('hal');
			$placeholder_hal = isset($old_hal) ? $old_hal : $suratkeluar->hal;
		?>

		<div class="bordered">
			{{ Form::open('suratkeluar/update', 'PUT', array('class'=>'form')) }}
				{{ Form::token() }}
				{{ Form::hidden('id', $id_surat) }}
				<table>
					<tr>
						<?php
							$daftar_jenis_surat = array();
							foreach ($suratkeluar->daftar_jenis as $daftar) {
								$daftar_jenis_surat += array($daftar->id => $daftar->jenis_surat);
							}
						?>
						<td class="field">
							{{ Form::label('jenis', '*Nomor Surat:') }}
						</td>
						<td>
							{{ Form::select('jenis', $daftar_jenis_surat, e($suratkeluar->id_jenis), array('disabled'=>'')) }}
							{{ Form::text('nomor_urut', e($suratkeluar->nomor_urut), array('class'=>'input-small', 'disabled'=>'')) }}
							{{ Form::text('kode', e($suratkeluar->kode_surat), array('disabled'=>'')) }}
							{{ Form::text('tahun', e($suratkeluar->tahun_surat), array('class'=>'input-small', 'disabled'=>'')) }}
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
							foreach($suratkeluar->daftar_disposisi as $daftar) {
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
						{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Update Surat Keluar', array('class'=>'btn btn-warning', 'type'=>'submit'))) }}
						{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt', 'type'=>'reset'))) }}
						<span class="divider">|</span>
						<i class="icon-circle-arrow-left"></i> {{ HTML::link_to_route('suratkeluar', ' Batal', $suratkeluar->id) }}
						</td>
					</tr>
				</table>
			{{ Form::close() }}
		</div>
	</div>
@endsection