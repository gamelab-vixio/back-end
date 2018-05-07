@extends('layout')

@section('title', 'Blog | Dashboard')

@section('stylesheet')
	<link rel="stylesheet" href="{{asset('vixio-cms/assets/css/lib/datatable/dataTables.bootstrap.min.css')}}">
	<style>
		html{
			overflow-y: scroll !important;
		}

		body{
			padding-right: 0 !important;
		}

		.modal-backdrop.show, .modal-backdrop.fade{
			display: none;
		}
	</style>

	<!-- Quill Text Editor Theme included stylesheets -->
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

	<div class="content mt-3">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-md-12">
					<button class="btn btn-primary">
						<a href="{{ route('blogCreate') }}" style="color: #fff";><i class="fa fa-plus"></i>&nbsp;New Blog</a>
					</button>
					<hr>
					<div class="card">
						<div class="card-header">
							<strong class="card-title">Data Table</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Title</th>
										<th>Content</th>
										<th>Image</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Test Title</td>
										<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni enim quod eos sunt quis eius consequatur, dolore aut, earum sed atque cumque tempora nostrum. Laborum earum, facilis accusamus repudiandae in.</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Publish</td>
										<td>
											<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td>Test Title 2</td>
										<td>The quick brown fox jumps over the lazy dog</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Publish</td>
										<td>
											<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td>Test Title 3</td>
										<td>LALALALALALALAAAAAAAAAAAAAA</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Unpublish</td>
										<td>
											<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
              	<div class="modal-dialog modal-lg" role="document">
                  <form action="#">
	                  <div class="modal-content">
	                     <div class="modal-header">
	                          	<h5 class="modal-title" id="mediumModalLabel">Edit Blog</h5>
	                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                              <span aria-hidden="true">&times;</span>
	                          	</button>
	                     </div>
	                     <div class="modal-body">

	                        <div class="card-body card-block">

					               <div class="form-group" style="width: 50%;">
					                  <label class="form-control-label">Title</label>
				                     <div class="input-group">
				                        <input class="form-control" value="Current Title">
				                     </div>
				                     <small class="form-text text-muted">ex. How To Create Better Story</small>
					               </div>

					               <div class="form-group">
					                  <label class=" form-control-label">Content</label>
			                        <div id="editor" style="height: 250px"></div>
				                     <small class="form-text text-muted">ex. Content of the blog goes here</small>
					               </div>

					               <div class="form-group">
					                  <label class="form-control-label">Status</label>
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

					               <div class="form-group">
					               	<label class="form-control-label">Current Thumbnail image</label>
					                  <div class="current-thumbnail-image">
					                  	<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman" style="border: 2px dashed black; padding: 10px;">
					                  </div>
					               </div>

					               <div class="form-group" style="width: 50%;">
					                  <label class="form-control-label">Thumbnail image</label>
				                     <div class="input-group">
				                        <input type="file" class="form-control" name="blogImage" accept="image/x-png,image/gif,image/jpeg" />
				                     </div>
				                     <small class="form-text text-muted">ex. Choose thumbnail image</small>
					               </div>
					            </div>
	                     </div>

	                     <div class="modal-footer">
	                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	                        <button type="submit" class="btn btn-danger">Confirm</button>
	                     </div>
	                  </div>
                  </form>
            	</div>
          	</div>

				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
               <div class="modal-dialog modal-sm" role="document">
	               <form action="#">
	                  <div class="modal-content">
	                     <div class="modal-header">
	                        <h5 class="modal-title" id="smallmodalLabel">Delete Confirmation</h5>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                           <span aria-hidden="true">&times;</span>
	                        </button>
	                     </div>
	                     <div class="modal-body">
	                        <p class="text-center" style="color: #000; margin-bottom: 0;">
	                        	Are you sure to delete this blog?
	                        </p>
	                     </div>
	                     <div class="modal-footer">
	                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	                        <button type="submit" class="btn btn-danger">Confirm</button>
	                     </div>
	                  </div>
	               </form>
               </div>
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

	<script type="text/javascript">
		$(document).ready(function() {
			$('#bootstrap-data-table-export').DataTable();
		});
	</script>

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