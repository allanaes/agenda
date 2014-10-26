@section('display_form')
	<div class='bordered'>		
		{{ Form::open('suratkeluar/search', 'GET', array('class'=>'form')) }}
		<table>
			<tr>
				<td class="field">
					<?php
						$daftar_jenis_surat = array('' => '-SEMUA-');
						foreach ($suratkeluars->daftar_jenis as $daftar) {
							$daftar_jenis_surat += array($daftar->id => $daftar->jenis_surat);
						}
					?>
					{{ Form::label('jenis', 'Jenis:') }}
				</td>
				<td>
						{{ Form::select('jenis', $daftar_jenis_surat, $suratkeluars->input['jenis']) }}
						Nomor urut: {{ Form::text('nomor', $suratkeluars->input['nomor'], array('class'=>'input-small')) }}
						Kode: {{ Form::text('kode', $suratkeluars->input['kode'], array('class'=>'span3')) }}
						Tahun: {{ Form::text('tahun', $suratkeluars->input['tahun'], array('class'=>'span1')) }}
				</td>
			</tr>
			<tr>
				<td class="field">
						{{ Form::label('tanggal', 'Tanggal:') }} 
				</td>
				<td>
						{{ Form::text('tanggal', $suratkeluars->input['tanggal'], array('class'=>'span1_5 calendar')) }}
				</td>
			</tr>
			<tr>
				<?php
					$daftar_pengirim = array('' => '-SEMUA-');
					foreach($suratkeluars->daftar_disposisi as $daftar) {
						$daftar_pengirim += array($daftar->id => $daftar->nama);
					}
				?>
				<td class="field">
					{{ Form::label('pengirim', 'Pengirim:') }}		
				</td>
				<td>
					{{ Form::select('pengirim', $daftar_pengirim, $suratkeluars->input['pengirim']) }}
				</td>
			</tr>
			<tr>
				<td class="field">
					{{ Form::label('tujuan', 'Tujuan:') }} 
				</td>
				<td>
					{{ Form::text('tujuan', $suratkeluars->input['tujuan'], array('class'=>'span5')) }}
				</td>
			</tr>		
			<tr>
				<td class="field">
					{{ Form::label('hal', 'Hal:') }} 
				</td>
				<td>
					{{ Form::text('hal', $suratkeluars->input['hal'], array('class'=>'span5')) }}
				</td>
			</tr>
			<tr>				
				<td class="field">
					{{ Form::label('sort_order', 'Sort order:') }}		
				</td>
				<td>
					{{ Form::select('sort_order', array('asc'=>'Ascending', 'desc'=>'Descending'), $suratkeluars->input['sort_order']) }}
				</td>
			</tr>
			<tr>
				<td class="field">
					{{ Form::label('limit', 'Limit:') }} 
				</td>
				<td>
					{{ Form::text('limit', $suratkeluars->input['limit'], array('class'=>'span1')) }}
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
@endsection