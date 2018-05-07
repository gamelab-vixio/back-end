@extends('layout')

@section('title', 'Documentation | Title')

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
@endsection

@section('content')

	<div class="animated fadeIn">
	 	<div class="row">
	     	<div class="col-xs-12 col-sm-12">
	         <div class="card">
	            <div class="card-header">
	               <strong>Create New Documentation Title</strong>
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
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title</td>
										<td class="text-center" style="width: 20%;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title 2</td>
										<td class="text-center" style="width: 20%">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
										</td>
									</tr>

									<tr>
										<td class="text-center" style="vertical-align: middle;">Test Title 3</td>
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
	                          	<h5 class="modal-title" id="mediumModalLabel">Edit Title</h5>
	                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                              <span aria-hidden="true">&times;</span>
	                          	</button>
	                     </div>
	                     <div class="modal-body">
	                        <div class="card-body card-block text-center">
					               <div class="form-group"">
					                  <label class="form-control-label">New Title</label>
				                     <div class="input-group">
				                        <input class="form-control text-center" value="Current Title">
				                     </div>
				                     <small class="form-text text-muted">ex. Posting Story</small>
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
	                        	Are you sure to delete this title?
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
@endsection