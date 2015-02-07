@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Edit Surat Keluar Seksi: {{ $suratkeluar->nomor_surat }}</h1>
	</div>		

	<div class="row">
    <ul class="breadcrumb">
	    <li>
	    	{{ HTML::link_to_route('suratkeluar', 'Surat Keluar Seksi')}} <span class="divider">/</span>
	    </li>
	    <li>
	    	{{ HTML::link_to_route('suratkeluar', 'Detail Surat', $suratkeluar->id)}} <span class="divider">/</span>
	    </li>
	    <li class="active">Edit Surat</li>
    </ul>
  </div>
	{{ render('common.msg_error') }}

	@include('partial.suratkeluar.suratkeluar_edit_form')
	@yield('suratkeluar_edit')

@endsection