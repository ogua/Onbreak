          
@if (session()->has('success'))
<div class="alert alert-dismissible alert-success">
	<button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-success"></i> Success!</h4>
	{{ session('success') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i>Warning!</h4>
	{{ session('error') }}
</div>
@endif