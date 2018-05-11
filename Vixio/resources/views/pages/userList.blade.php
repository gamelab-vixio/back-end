@extends('layout')

@section('title', 'User | List')

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
							<strong class="card-title">User List</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Name</th>
										<th class="text-center">Email</th>
										<th class="text-center">Profile Image</th>
										<th class="text-center">Commentable</th>
										<th class="text-center">Join Date</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($data as $i => $user){ ?>
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$i+1}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$user['name']}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$user['email']}}</td>
										<td class="text-center" style="vertical-align: middle;">
											<?php if(is_null($user['image_url'])){ ?>
											-
											<?php } else{ ?>
											<button class="btn btn-primary" data-toggle="modal" data-target="#userProfile{{$i}}">Show Image</button>
											<?php } ?>
										</td>
										<td class="text-center" style="vertical-align: middle;">Yes</td>
										<td class="text-center" style="width: 10%;">20 May 2020</td>
									</tr>
									<div class="modal fade" id="userProfile{{$i}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
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
						                        		<?php if(!is_null($user['image_url'])) { ?>
									                  	<img src='{{ asset($user["image_url"]) }}' alt="blog" style="border: 2px dashed black; padding: 10px;">
									                  	<?php } ?>
						                     		</div>
							                    	<div class="modal-footer">
							                        	<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							                    	</div>
						                  		</div>
						               		</form>
					               		</div>
					        		</div>
								<?php } ?>
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