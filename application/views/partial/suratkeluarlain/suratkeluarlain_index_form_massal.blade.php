@section('display_form')
	<div class="row">
    <ul class="breadcrumb">
	    <li class="active"><i class="icon-tag"></i> {{ HTML::link_to_route('suratkeluarlain', 'Input Surat Keluar Lain')}}<span class="divider">//</span></li>
	    <li>
	    	<i class="icon-download-alt"></i> Input Surat Keluar Lain Massal
	    </li>
    </ul>
  </div>

		<div class="row">
		<div class="bordered">
			{{ Form::open('suratkeluarlain/createmassal', 'POST', array('files'=>true, 'enctype'=>'multipart/form-data', 'class'=>'form')) }}
				{{ Form::token() }}
				<table class="maxwidth">
					<p class="bordered-ok">Contoh format file CSV yang dapat digunakan: <i class="icon-file"></i> {{ HTML::link(URL::to_asset('template/template_import_surat_keluar_lain.csv'), 'Template Import Surat Keluar Lain') }}</p>
					
					<tr><td colspan="2">Import file CSV daftar surat keluar lain:</td></tr>
					<tr><td colspan="2">{{ Form::file('csv_upload') }}</td></tr>
					<tr>
						<td class="form-action">
							{{ HTML::decode(Form::button('<i class="icon-check icon-white"></i> Submit untuk Preview', array('type'=>'submit'))) }}
							{{ HTML::decode(Form::button('<i class="icon-refresh icon-white"></i> Reset', array('class'=>'alt','type'=>'reset'))) }}
						</td>
					</tr>
				</table>			
			{{ Form::close() }}
		</div>
	</div>
@endsection