@if(Session::has('warning'))
<div class='row'>
	<div class="alert">
		<strong>Warning!</strong> {{ Session::get('warning') }}
	</div>
</div>
@endif