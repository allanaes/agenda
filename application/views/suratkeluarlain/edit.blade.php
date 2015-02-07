@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Edit Surat Keluar Lain: {{ $suratkeluarlain->nomor_surat }}</h1>
	</div>		

	<div class="row">
    <ul class="breadcrumb">
	    <li>
	    	{{ HTML::link_to_route('suratkeluarlain', 'Surat Keluar Lain')}} <span class="divider">/</span>
	    </li>
	    <li>
	    	{{ HTML::link_to_route('suratkeluarlain', 'Detail Surat', $suratkeluarlain->id)}} <span class="divider">/</span>
	    </li>
	    <li class="active">Edit Surat</li>
    </ul>
  </div>
	{{ render('common.msg_error') }}

	@include('partial.suratkeluarlain.suratkeluarlain_edit_form')
	@yield('suratkeluarlain_edit')

@endsection