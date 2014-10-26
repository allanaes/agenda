@if($errors->has())
<div class='row'>
	<div class="alert alert-error">
		<strong>Error!</strong>
		@foreach($errors->all() as $error)
			{{ $error }}
		@endforeach
	</div>
</div>
@endif