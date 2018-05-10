@extends('layout')

@section('title', 'Blog | Create')

@section('stylesheet')
	<!-- Quill Text Editor Theme included stylesheets -->
	{{-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"> --}}
@endsection

@section('content')

	<div class="animated fadeIn">
	 	<div class="row">
	     	<div class="col-xs-12 col-sm-12">
	         <div class="card">
	            <div class="card-header">
	               <strong>Create Blog</strong>
	            </div>
		         
		         <form method="post" action="{{url('/')}}/blog/createBlog" id="createBlog" enctype='multipart/form-data'>
		         {{ csrf_field() }}
		            <div class="card-body card-block">

		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Title</label>
	                     <div class="input-group">
	                        <input class="form-control" name="title" />
	                     </div>
	                     <small class="form-text text-muted">ex. How To Create Better Story</small>
		               </div>
							
							{{-- Quill Div --}}
		               {{-- <div class="form-group">
		                  <label class=" form-control-label">Content</label>
                        <div id="editor" style="height: 250px"></div>
	                     <small class="form-text text-muted">ex. Content of the blog goes here</small>
		               </div>
		               <textarea name="content" id="content" hidden value=""></textarea> --}}
							
							{{-- NicEditor --}}
		               <div class="form-group">
		               	<label class=" form-control-label">Content</label>
		               	<textarea name="test" id="editor" style="width: 100%; height: 250px"></textarea>
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

	<script src="{{asset('vixio-cms/assets/js/lib/data-table/datatables.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/jszip.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
	<script src="{{asset('vixio-cms/assets/js/lib/data-table/datatables-init.js')}}"></script>
	
	{{-- NicEditor --}}
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script type="text/javascript">
		bkLib.onDomLoaded(function() {
      	new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','subscript','superscript','strikeThrough','removeformat','indent','outdent','hr','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat']}).panelInstance('editor');
      });
	</script>

	<!-- Main Quill Text Editor Library -->
	{{-- <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> --}}
	
	<!-- Initialize Quill editor -->
	{{-- <script>
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
	</script> --}}

	{{-- <script>
	$(document).ready(function(){
	    $('#createBlog').on('submit', function(e){
	        e.preventDefault();
	  		$("textarea#content").val($( ".ql-editor p span" ).text());
	        this.submit();
	    });
	});
	</script> --}}
						
@endsection