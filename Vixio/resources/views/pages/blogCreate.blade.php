@extends('layout')

@section('title', 'Blog | Create')

@section('stylesheet')

@endsection

@section('content')

	<div class="animated fadeIn">
	 	<div class="row">
	     	<div class="col-xs-12 col-sm-12">
	         <div class="card">
	            <div class="card-header">
	               <strong>Create Blog</strong>
	            </div>
		         
		         <form method="post" action="{{ route('createPost') }}" id="createBlog" enctype='multipart/form-data'>
		         {{ csrf_field() }}
		            <div class="card-body card-block">

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Title</label>
	                     <div class="input-group">
	                        <input class="form-control" name="title" />
	                     </div>
	                     <small class="form-text text-muted">ex. How To Create Better Story</small>
		               </div>
							
		               <div class="form-group">
		               	<label class=" form-control-label">Content</label>
		               	<textarea name="content" style="width: 100%; height: 250px"></textarea>
		               	<small class="form-text text-muted">ex. Content of the blog goes here</small>
		               </div>

		               <div class="form-group">
		                  <label class=" form-control-label">Status</label>
	                     <div class="input-group">
	                        <label class="radio-inline">
								      <input type="radio" name="status" value="1" style="margin-right: 3px;">Publish
								   </label>
								   <label class="radio-inline" style="margin-left: 15px;"">
								   	<input type="radio" name="status" value="0" style="margin-right: 3px;">Unpublish
								   </label>
	                     </div>
	                     <small class="form-text text-muted">ex. Select blog status</small>
		               </div>

		               <div class="form-group" style="width: 50%;">
		                  <label class="form-control-label">Thumbnail image</label>
	                     <div class="input-group">
	                        <input type="file" class="form-control" name="photo"/>
	                     </div>
	                     <small class="form-text text-muted">ex. Choose thumbnail image</small>
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

	<script src="{{asset('vixio-cms/assets/js/richTextEditor.js')}}" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','subscript','superscript','strikeThrough','removeformat','indent','outdent','hr','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat']}));</script>
						
@endsection