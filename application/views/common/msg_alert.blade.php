@if(Session::has('alert'))
<div class='row'>
	<div class="alert alert-info">
		<strong>Success!</strong> {{ Session::get('alert') }}
	</div>
</div>
@endif