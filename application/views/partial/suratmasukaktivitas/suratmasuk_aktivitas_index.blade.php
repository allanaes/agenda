@section('suratmasuk_aktivitas_index')
	<div class="row">
	<h4><i class="icon-file"></i>{{ e($suratmasuk->nomor_surat) }}<span class="divider">&nbsp;//&nbsp;</span><span class="muted"><i class="icon-calendar"></i>{{ e($suratmasuk->tgl_diterima) }}</h4>

	<table class="viewtable">
		<tr><th>Pengirim:</th> <td> {{ e($suratmasuk->pengirim) }}</td></tr>
		<tr><th>Hal:</th> <td> {{ e($suratmasuk->hal) }}</td></tr>
	</table>		
	</div>
@endsection