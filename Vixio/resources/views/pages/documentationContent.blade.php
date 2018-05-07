@extends('layout')

@section('title', 'Documentation | Subtitle')

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

	<div class="animated fadeIn">
	 	<div class="row">
	     	<div class="col-xs-12 col-sm-12">
	         <div class="card">
	            <div class="card-header">
	               <strong>Create New Documentation Subtitle</strong>
	            </div>
		         
		         <form action="#">
		            <div class="card-body card-block">
		            	{{-- Title --}}
                     <div class="form-group">
                        <label for="select" class=" form-control-label">Title</label>
                        <select name="select" id="select" class="form-control" style="width: 50%;">
									<option value="0">Please select</option>
									<option value="1">Option #1</option>
									<option value="2">Option #2</option>
									<option value="3">Option #3</option>
                        </select>
                     </div>

							{{-- Subtitle --}}
							<div class="form-group">
                        <label for="select" class=" form-control-label">Subitle</label>
                        <select name="select" id="select" class="form-control" style="width: 50%;">
									<option value="0">Please select</option>
									<option value="1">Option #1</option>
									<option value="2">Option #2</option>
									<option value="3">Option #3</option>
                        </select>
                     </div>
							
							{{-- Header --}}
		               <div class="form-group" style="width: 50%;">
		                  <label class="form-control-label">Header</label>
	                     <div class="input-group">
	                        <input class="form-control">
	                     </div>
	                     <small class="form-text text-muted">ex. Installation</small>
		               </div>
							
							{{-- Content --}}
		               <div class="form-group" style="width: 50%;">
		                  <label class="form-control-label">Content</label>
	                     <div id="editor1" style="height: 250px"></div>
	                     <small class="form-text text-muted">ex. Documentation content goes here</small>
		               </div>

		               <button type="submit" class="btn btn-primary">Submit</button>
		                 
		            </div>
		         </form>

	         </div>

	         <div class="card">
						<div class="card-header">
							<strong class="card-title">Data Table</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">Title</th>
										<th class="text-center">Subtitle</th>
										<th class="text-center">Header</th>
										<th class="text-center">Content</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title</td>
										<td class="text-center" style="vertical-align: middle;">Test Subtitle</td>
										<td class="text-center" style="vertical-align: middle;">Test Header</td>
										<td class="text-center" style="vertical-align: middle;">Test Content</td>
										<td class="text-center" style="width: 20%;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title 2</td>
										<td class="text-center" style="vertical-align: middle;">Test Subtitle 2</td>
										<td class="text-center" style="vertical-align: middle;">Test Header 2</td>
										<td class="text-center" style="vertical-align: middle;">Test Content 2</td>
										<td class="text-center" style="width: 20%">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title 3</td>
										<td class="text-center" style="vertical-align: middle;">Test Subtitle 3</td>
										<td class="text-center" style="vertical-align: middle;">Test Header 3</td>
										<td class="text-center" style="vertical-align: middle;">Test Content 3</td>
										<td class="text-center" style="width: 20%">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
	                          	<h5 class="modal-title" id="mediumModalLabel">Edit</h5>
	                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                              <span aria-hidden="true">&times;</span>
	                          	</button>
	                     </div>
	                     <div class="modal-body">
	                        <div class="card-body card-block">
										{{-- New Title --}}
			                     <div class="form-group">
			                        <label for="select" class=" form-control-label">Title</label>
			                        <select name="select" id="select" class="form-control">
												<option value="0">Please select</option>
												<option value="1">Option #1</option>
												<option value="2">Option #2</option>
												<option value="3">Option #3</option>
			                        </select>
			                     </div>
										

	                        	{{-- New Subtitle --}}
	                        	<div class="form-group">
			                        <label for="select" class=" form-control-label">Subtitle</label>
			                        <select name="select" id="select" class="form-control">
												<option value="0">Please select</option>
												<option value="1">Option #1</option>
												<option value="2">Option #2</option>
												<option value="3">Option #3</option>
			                        </select>
			                     </div>

			                     {{-- New Header --}}
					               <div class="form-group"">
					                  <label class="form-control-label">New Header</label>
				                     <div class="input-group">
				                        <input class="form-control" value="Current Header">
				                     </div>
				                     <small class="form-text text-muted">ex. Installation</small>
					               </div>

					               {{-- New Content --}}
					               <div class="form-group"">
					                  <label class="form-control-label">New Content</label>
				                     <div id="editor2" style="height: 250px"></div>
				                     <small class="form-text text-muted">ex. New documentation content goes here</small>
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
	                        	Are you sure to delete this row?
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

		var quill = new Quill('#editor1', {
			modules: { 
				toolbar: toolbarOptions 
			},
			theme: 'snow'
		});
		
		quill.format('color', 'black');

		var quill = new Quill('#editor2', {
			modules: { 
				toolbar: toolbarOptions 
			},
			theme: 'snow'
		});

		quill.format('color', 'black');
	</script>
@endsection