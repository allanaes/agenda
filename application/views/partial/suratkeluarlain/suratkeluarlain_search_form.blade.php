@section('display_form')
	<div class='bordered'>		
		{{ Form::open('suratkeluarlain/search', 'GET', array('class'=>'form')) }}
		<table>
			<tr>
				<td class="field">
					{{ Form::label('nomor_surat', 'Nomor Surat:') }}
				</td>
				<td>						
						{{ Form::text('nomor_surat', $suratkeluarlains->input['nomor_surat'], array('class'=>'span5')) }}
				</td>
			</tr>
			<tr>
				<td class="field">
						{{ Form::label('tanggal', 'Tanggal:') }} 
				</td>
				<td>
						{{ Form::text('tanggal', $suratkeluarlains->input['tanggal'], array('class'=>'span1_5 calendar')) }}
				</td>
			</tr>
			<tr>
				<?php
					$daftar_pengirim = array('' => '-SEMUA-');
					foreach($suratkeluarlains->daftar_disposisi as $daftar) {
						$daftar_pengirim += array($daftar->id => $daftar->nama);
					}
				?>
				<td class="field">
					{{ Form::label('pengirim', 'Pengirim:') }}		
				</td>
				<td>
					{{ Form::select('pengirim', $daftar_pengirim, $suratkeluarlains->input['pengirim']) }}
				</td>
			</tr>
			<tr>
				<td class="field">
					{{ Form::label('tujuan', 'Tujuan:') }} 
				</td>
				<td>
					{{ Form::text('tujuan', $suratkeluarlains->input['tujuan'], array('class'=>'span5')) }}
				</td>
			</tr>		
			<tr>
				<td class="field">
					{{ Form::label('hal', 'Hal:') }} 
				</td>
				<td>
					{{ Form::text('hal', $suratkeluarlains->input['hal'], array('class'=>'span5')) }}
				</td>
			</tr>
			<tr>				
				<td class="field">
					{{ Form::label('sort_order', 'Sort order:') }}		
				</td>
				<td>
					{{ Form::select('sort_order', array('asc'=>'Ascending', 'desc'=>'Descending'), $suratkeluarlains->input['sort_order']) }}
				</td>
			</tr>
			<tr>
				<td class="field">
					{{ Form::label('limit', 'Limit:') }} 
				</td>
				<td>
					{{ Form::text('limit', $suratkeluarlains->input['limit'], array('class'=>'span1')) }}
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