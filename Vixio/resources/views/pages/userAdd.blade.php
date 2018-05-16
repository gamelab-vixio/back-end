@extends('layout')

@section('title', 'User | Add')

@section('stylesheet')
	<!-- Quill Text Editor Theme included stylesheets -->
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

	<div class="animated fadeIn">
	 	<div class="row">
	     	<div class="col-xs-12 col-sm-12">
	         <div class="card">
	            <div class="card-header">
	               <strong>Add New Admin</strong>
	            </div>
		         
		         <form action="{{ route('addAdmin') }}" method="post">
		         	{{ csrf_field() }}
		            <div class="card-body card-block">

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Name</label>
	                     <div class="input-group">
	                        <input type="text" name="name" class="form-control" required>
	                     </div>
	                     <small class="form-text text-muted">ex. Tony Stark</small>
		               </div>

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Email</label>
	                     <div class="input-group">
	                        <input type="email" name="email" class="form-control" required>
	                     </div>
	                     <small class="form-text text-muted">ex. Tony@stark.com</small>
		               </div>

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Password</label>
	                     <div class="input-group">
	                        <input type="password" id="password" name="password" class="form-control" required>
	                     </div>
	                     <small class="form-text text-muted">ex. Password123456</small>
		               </div>

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Confirm Password</label>
	                     <div class="input-group">
	                        <input type="password" id="confirm_password" name="password_confirmation" class="form-control" required>
	                     </div>
	                     <small class="form-text text-muted">ex. ConfirmPassword123456</small>
		               </div>

		               <button type="submit" class="btn btn-primary">Submit</button>
		                 
		            </div>
		         </form>

	         </div>
	     	</div>
	   </div>
	</div>

@endsection

@section('script')

	@if(Session::has('message'))
	<script>
		alert("{{Session::get('message')}}");
	</script>
	@elseif($errors->any())
	<script>
		@foreach ($errors->all() as $error)
		alert("{{$error}}");
    	@endforeach
	</script>
	@endif

	<script>
		var password = document.getElementById("password")
		  , confirm_password = document.getElementById("confirm_password");

		function validatePassword(){
		  	if(password.value != confirm_password.value)
		  	{
		   	confirm_password.setCustomValidity("Passwords Don't Match");
		  	} 
		  	else
		  	{
		   	confirm_password.setCustomValidity('');
		  	}
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
	</script>
	
@endsection