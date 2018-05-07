@extends('layout')

@section('title', 'User | Ban')

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
							<strong class="card-title">User Ban</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Name</th>
										<th class="text-center">Email</th>
										<th class="text-center">Reason</th>
										<th class="text-center">Profile Image</th>
										<th class="text-center">Reported</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<form action="#">
											<td class="text-center" style="vertical-align: middle;">
												1
												<input type="hidden" name="row_number[]" value="write_value_here"/>
											</td>
											<td class="text-center" style="vertical-align: middle;">
												Ieuan Kappa 1 2 3
												<input type="hidden" name="user_name[]" value="write_value_here"/>
											</td>
											<td class="text-center" style="vertical-align: middle;">
												ieuanignatius@gmail.com
												<input type="hidden" name="user_email[]" value="write_value_here"/>
											</td>
											<td class="text-center" style="vertical-align: middle;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#showReason">Show Reason</button>
												<input type="hidden" name="user_reason[]" value="write_value_here"/>
											</td>
											<td class="text-center" style="vertical-align: middle;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#showProfileImage">Show Image</button>
											</td>
											<td class="text-center" style="vertical-align: middle;">20 Times</td>
											<td class="text-center" style="width: 10%;">
												{{-- @if(blablabla) --}}
												<button type="submit" class="btn btn-primary">Ban</button>
												{{-- @else --}}
												<button type="submit" class="btn btn-danger">Unban</button>
												{{-- @endif --}}
											</td>
										</form>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="showReason" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
              	<div class="modal-dialog modal-lg" role="document">
                  <form action="#">
	                  <div class="modal-content">
	                     <div class="modal-header">
	                          	<h5 class="modal-title" id="mediumModalLabel">Reason</h5>
	                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                              <span aria-hidden="true">&times;</span>
	                          	</button>
	                     </div>
	                     <div class="modal-body">
	                        <p>Intentional Feeding (Send couriers to enemy base 322 times)</p>
	                     </div>

	                     <div class="modal-footer">
	                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	                     </div>
	                  </div>
                  </form>
            	</div>
          	</div>

				<div class="modal fade" id="showProfileImage" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
               <div class="modal-dialog modal-sm" role="document">
	               <form action="#">
	                  <div class="modal-content">
	                     <div class="modal-header">
	                        <h5 class="modal-title" id="smallmodalLabel">User Profile Image</h5>
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                           <span aria-hidden="true">&times;</span>
	                        </button>
	                     </div>
	                     <div class="modal-body">
	                        <div class="user-profile">
			                  	<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman" style="border: 2px dashed black; padding: 10px;">
			                  </div>
	                     </div>
	                     <div class="modal-footer">
	                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
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