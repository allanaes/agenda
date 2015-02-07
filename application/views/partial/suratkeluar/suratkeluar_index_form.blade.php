@section('display_form')
	<div class="row">
		<ul class="breadcrumb">
			<li class="active"><i class="icon-tag"></i> Input Surat Keluar Seksi<span class="divider">//</span></li>
			<li>
				<i class="icon-tags"></i> {{ HTML::link_to_route('suratkeluar_massal', 'Input Surat Keluar Seksi Massal')}}
			</li>
		</ul>
	</div>

	<?php
		/*
		* placeholder teks setiap input field untuk memudahkan input surat yg sama
		* baris Input::old('field') mengambil teks yang sama sebelumnya diinput apabila terjadi error
		* baris Session::get('field') mengambil teks dari SURAT SEBELUMNYA yg berhasil diinput
		*	 (teks dibawa bersama redirect di controller)
		*/

		// placeholder untuk JENIS surat
		$placeholder_jenis = Input::old('jenis');
		if (Session::has('jenis')) {
			$placeholder_jenis = Session::get('jenis');
		}

		// placeholder untuk TANGGAL surat
		$oldinput_tanggal = Input::old('tanggal');
		$placeholder_tanggal = empty($oldinput_tanggal) ? date('d/m/Y') : $oldinput_tanggal;
		if (Session::has('tanggal')) {
			$placeholder_tanggal = Session::get('tanggal');
		}

		// placeholder untuk PENGIRIM surat
		$placeholder_pengirim = Input::old('pengirim');
		if (Session::has('pengirim')) {
			$placeholder_pengirim = Session::get('pengirim');
		}

		// placeholder untuk TUJUAN hanya diset jika 
		$placeholder_tujuan = Input::old('tujuan');
		if (Session::has('tujuan')) {
			$placeholder_tujuan = Session::get('tujuan');
		}

		// placeholder untuk HAL surat
		$placeholder_hal = Input::old('hal');
		if (Session::has('hal')) {
			$placeholder_hal = Session::get('hal');
		}

	?>

	<div class="row">
		<div class="bordered">
			{{ Form::open('suratkeluar/create', 'POST', array('class'=>'form')) }}
				{{ Form::token() }}
				<table class="maxwidth">
					<tr>
						<td class="field">
							<?php
								$daftar_jenis_surat = array();
								foreach ($suratkeluars->daftar_jenis as $daftar) {
									if ($daftar->aktif) {
										$daftar_jenis_surat += array($daftar->id => $daftar->jenis_surat);
									}
								}
							?>
							{{ Form::label('jenis', '*Jenis:') }}
						</td>
						<td>
							{{ Form::select('jenis', $daftar_jenis_surat, $placeholder_jenis) }}
							Kode: {{ Form::text('kode', e($suratkeluars->kode_surat), array('class'=>'disabled','disabled'=>'')) }}
							Tahun: {{ Form::text('tahun', e($suratkeluars->tahun_surat), array('class'=>'disabled input-small', 'disabled'=>'')) }}
						</td>
						{{ render('common.bigdate') }}
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
						<td class="field">
							<?php
								$daftar_pengirim = array();
								foreach($suratkeluars->daftar_disposisi as $daftar) {
									if ($daftar->aktif) {
										$daftar_pengirim += array($daftar->id => $daftar->nama);
									}
								}
							?>
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
							{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit', array('type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
						</td>
					</tr>
				</table>			
			{{ Form::close() }}
		</div>
	</div>
@endsection