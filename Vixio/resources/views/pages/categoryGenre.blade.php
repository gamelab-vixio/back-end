@extends('layout')

@section('title', 'Category | Genre')

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
	               <strong>Create New Genre</strong>
	            </div>
		         <form action="{{ route('addGenre') }}" method="post">
		         	{{ csrf_field() }}
		            <div class="card-body card-block">
		               <div class="form-group" style="width: 50%;">
		                  <label class=" form-control-label">Genre</label>
	                     <div class="input-group">
	                        <input class="form-control" name="genre">
	                     </div>
	                     <small class="form-text text-muted">ex. Comedy</small>
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
										<th class="text-center">No.</th>
										<th class="text-center">Genre</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $genre)
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$genre['genre']}}</td>
										<td class="text-center" style="width: 20%;">
											@if($loop->iteration == 1)
												-
											@else
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$loop->iteration}}">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$loop->iteration}}">Delete</button>
											@endif
										</td>
									</tr>
									<!-- Edit Modal -->
									<div class="modal fade" id="editModal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
					              		<div class="modal-dialog modal-lg" role="document">
					                  		<form action="{{ route('editGenre', ['id' => $genre['id']]) }}" method="post">
					                  			{{ csrf_field() }}
						                  		<div class="modal-content">
						                     		<div class="modal-header">
							                        	<h5 class="modal-title" id="mediumModalLabel">Edit Genre</h5>
						                          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                              		<span aria-hidden="true">&times;</span>
						                          		</button>
						                     		</div>
						                     		<div class="modal-body">
						                        		<div class="card-body card-block text-center">
										               		<div class="form-group"">
										                  		<label class="form-control-label">Genre</label>
									                     		<div class="input-group">
									                     		   	<input class="form-control text-center" name="genre" value="{{$genre['genre']}}">
									                     		</div>
									                     		<small class="form-text text-muted">ex. Fiction</small>
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
					          		<!-- Delete Modal -->
					          		<div class="modal fade" id="deleteModal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
					               		<div class="modal-dialog modal-sm" role="document">
						               		<form action="{{ route('deleteGenre', ['id' => $genre['id']]) }}" method="post">
						               			{{ csrf_field() }}
						                  		<div class="modal-content">
						                     		<div class="modal-header">
						                        		<h5 class="modal-title" id="smallmodalLabel">Delete Confirmation</h5>
					                        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                           			<span aria-hidden="true">&times;</span>
						                        		</button>
						                     		</div>
					                     			<div class="modal-body">
						                        		<p class="text-center" style="color: #000; margin-bottom: 0;">Are you sure to delete this genre? Deleting this genre will change category type that use this genre to Uncategory</p>
						                     		</div>
						                     		<div class="modal-footer">
						                        		<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
						                        		<button type="submit" class="btn btn-danger">Confirm</button>
						                     		</div>
						                  		</div>
						               		</form>
					               		</div>
					            	</div>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
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