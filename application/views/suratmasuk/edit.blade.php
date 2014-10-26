@layout('layouts.default')

@section('content')
	<div class='row'>
		<h1>Edit Surat Masuk</h1>
	</div>
	<div class="row">
    <ul class="breadcrumb">
	    <li>
	    	{{ HTML::link_to_route('suratmasuk', 'Surat Masuk') }} <span class="divider">/</span>
	    </li>
	    <li>
	    	{{ HTML::link_to_route('suratmasuk', 'Detail Surat', $suratmasuk->id) }} <span class="divider">/</span>
	    </li>
	    <li class="active">Edit Surat</li>
    </ul>
  </div>

	@include('layouts.alert_msg')
	@yield('alert_msg')

	@include('partial.suratmasuk.suratmasuk_edit_form')
	@yield('display_form')
	
@endsection