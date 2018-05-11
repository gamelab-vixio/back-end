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
							<strong class="card-title">User Ban List</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Name</th>
										<th class="text-center">Email</th>
										<th class="text-center">Reason</th>
										<th class="text-center">Screenshot</th>
										<th class="text-center">Reported</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $report)
									<tr>
										<td class="text-center" style="vertical-align: middle;">
											{{$loop->iteration}}
										</td>
										<td class="text-center" style="vertical-align: middle;">
											{{$report['name']}}
										</td>
										<td class="text-center" style="vertical-align: middle;">
											{{$report['email']}}
										</td>
										<td class="text-center" style="vertical-align: middle;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#showReason{{$loop->iteration}}">Show Reason</button>
										</td>
										<td class="text-center" style="vertical-align: middle;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#imageReason{{$loop->iteration}}">Show Image</button>
										</td>
										<td class="text-center" style="vertical-align: middle;">
											{{$report['reported_user_count']}}
										</td>
										<td class="text-center" style="width: 10%;">
											@if($report['commentable'])
											<form action="{{ route('userBan', ['id' => $report['id']]) }}" method="post">
											@else
											<form action="{{ route('userUnban', ['id' => $report['id']]) }}" method="post">
											@endif
												{{ csrf_field() }}
												@if($report['commentable'])
												<button type="submit" class="btn btn-primary">Ban</button>
												@else
												<button type="submit" class="btn btn-danger">Unban</button>
												@endif
											</form>
										</td>
									</tr>
									<!-- Reason Modal -->
									<div class="modal fade" id="showReason{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
						              	<div class="modal-dialog modal-lg" role="document">
						                  	<form action="#">
							                  	<div class="modal-content">
							                     	<div class="modal-header">
							                          	<h5 class="modal-title" id="mediumModalLabel">Reason(s)</h5>
							                          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                              		<span aria-hidden="true">&times;</span>
							                          	</button>
							                     	</div>
							                     	<div class="modal-body">
							                     		@foreach($report['reportedUser'] as $reason)
							                        	<p>{{$loop->iteration}}. {{$reason['reason']}}</p>
							                        	@endforeach
							                     	</div>

							                     	<div class="modal-footer">
								                    	<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							                     	</div>
						                  		</div>
						                  </form>
						            	</div>
						          	</div>
						          	<!-- Screenshot Modal -->
						          	<div class="modal fade" id="imageReason{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
					               		<div class="modal-dialog modal-sm" role="document">
					                  		<div class="modal-content">
					                     		<div class="modal-header">
					                        		<h5 class="modal-title" id="smallmodalLabel">Screenshot(s)</h5>
					                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                       				<span aria-hidden="true">&times;</span>
					                    			</button>
					                     		</div>
					                     		<div class="modal-body">
					                        		<div class="user-profile">
						                        		@foreach($report['reportedUser'] as $image)
						                        			@if(is_null($image['image_url']))
								                        	<p>{{$loop->iteration}}. -
								                        	</p>
								                        	@else
								                        	<p>{{$loop->iteration}}. <img src="{{ asset($image['image_url']) }}" alt="screenshot{{$loop->iteration}}" style="border: 2px dashed black; padding: 10px;">
								                        	</p>
								                        	@endif
							                        	@endforeach
							                  			
							                  		</div>
					                     		</div>
					                    		<div class="modal-footer">
					                        		<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
					                     		</div>
					                  		</div>
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