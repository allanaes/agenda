@section('suratmasuk_aktivitas_index')
	<div class="row">

	<p>
		<i class="icon-circle-arrow-left"></i> 
		{{ HTML::link_to_route('suratmasuk', 'Ke Detail Surat Masuk', array($suratmasuk->id)) }}
	</p>

	<p>
		<i class="icon-chevron-left"></i>
		<?php
			$current_id = $suratmasuk->id;
			$prev_id = $current_id - 1;
			while (true) {
				if (is_object(Suratmasuk::find($prev_id))) {
					echo HTML::link_to_route('aktivitas_suratmasuk', 'Prev', array($prev_id));
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
					echo HTML::link_to_route('aktivitas_suratmasuk', 'Next', array($next_id));
					break;
				} else {
					echo "Next";
					break;
				}
			}
		?>
		<i class="icon-chevron-right"></i>
	</p>

	<h4><i class="icon-file"></i>{{ e($suratmasuk->nomor_surat) }}<span class="divider">&nbsp;//&nbsp;</span><span class="muted"><i class="icon-calendar"></i>{{ e($suratmasuk->tgl_diterima) }}</h4>

	<table class="viewtable">
		<tr><th>Pengirim:</th> <td> {{ e($suratmasuk->pengirim) }}</td></tr>
		<tr><th>Hal:</th> <td> {{ e($suratmasuk->hal) }}</td></tr>
	</table>		
	</div>
@endsection