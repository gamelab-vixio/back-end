@extends('layout')

@section('title', 'Blog | Create')

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
	               <strong>Create Blog</strong>
	            </div>
		         
		         <form action="#">
		            <div class="card-body card-block">

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Title</label>
	                     <div class="input-group">
	                        <input class="form-control">
	                     </div>
	                     <small class="form-text text-muted">ex. How To Create Better Story</small>
		               </div>

		               <div class="form-group">
		                  <label class=" form-control-label">Content</label>
                        <div id="editor" style="height: 250px"></div>
	                     <small class="form-text text-muted">ex. Content of the blog goes here</small>
		               </div>

		               <div class="form-group">
		                  <label class=" form-control-label">Status</label>
	                     <div class="input-group">
	                        <label class="radio-inline">
								      <input type="radio" name="optRadio" value="publish" style="margin-right: 3px;">Publish
								   </label>
								   <label class="radio-inline" style="margin-left: 15px;"">
								   	<input type="radio" name="optRadio" value="unpublish" style="margin-right: 3px;">Unpublish
								   </label>
	                     </div>
	                     <small class="form-text text-muted">ex. Select blog status</small>
		               </div>

		               <div class="form-group" style="width: 50%;">
		                  <label class="form-control-label">Thumbnail image</label>
	                     <div class="input-group">
	                        <input type="file" class="form-control" name="blogImage" accept="image/x-png,image/gif,image/jpeg" />
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
	<!-- Main Quill Text Editor Library -->
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
	
	<!-- Initialize Quill editor -->
	<script>
		var toolbarOptions = [
			['bold', 'italic', 'underline', 'strike'],        // toggled buttons
			// ['blockquote', 'code-block'],
			
			['link'],														// link only

			// ['link', 'image'], 											// link and image
			// [{ 'header': 1 }, { 'header': 2 }],               // custom button values
			[{ 'list': 'ordered'}, { 'list': 'bullet' }],
			[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
			[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
			[{ 'direction': 'rtl' }],                         // text direction

			// [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
			[{ 'header': [1, 2, 3, 4, 5, 6, false] }],

			[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
			[{ 'font': [] }],
			[{ 'align': [] }],

			// ['clean']                                         // remove formatting button
		];

		var quill = new Quill('#editor', {
			modules: { 
				toolbar: toolbarOptions 
			},
			theme: 'snow'
		});

		quill.format('color', 'black');
	</script>
@endsection