@if(Session::has('message'))
<div class='row'>
	<div class="alert alert-success">
		<strong>Success!</strong> {{ Session::get('message') }}
	</div>
</div>
@endif