@extends('layout')

@section('title', 'Story | List')

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
							<strong class="card-title">Story List</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Title</th>
										<th class="text-center">Description</th>
										<th class="text-center">Story Image</th>
										<th class="text-center">Played</th>
										<th class="text-center">Publish</th>
										<th class="text-center">Active</th>
										<th class="text-center">Author</th>
										<th class="text-center">Release Year</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $story)
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$story['title']}}</td>
										<td class="text-center" style="vertical-align: middle;">
											@if(is_null($story['description']))
											-
											@else
											<button class="btn btn-primary" data-toggle="modal" data-target="#showDescription{{$loop->iteration}}">Show Description</button>
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
											@if(is_null($story['image_url']))
											-
											@else
											<button class="btn btn-primary" data-toggle="modal" data-target="#showStoryImage{{$loop->iteration}}">Show Image</button>
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
											@if(!$story['played'])
											0
											@elseif($story['played'] == 1)
											{{$story['played']}} time
											@else
											{{$story['played']}} times
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
											@if(!$story['publish'])
											No
											@else
											Yes
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
											@if(!$story['active'])
											No
											@else
											Yes
											@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">{{$story['user']['name']}}</td>
										<td class="text-center" style="width: 10%;">
											@if(is_null($story['year_of_release']))
											-
											@else
											{{$story['year_of_release']}}
											@endif
										</td>
									</tr>

									<!-- Description Modal -->
									<div class="modal fade" id="showDescription{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
					              		<div class="modal-dialog modal-lg" role="document">
					                  		<form action="#">
						                 		<div class="modal-content">
						                     		<div class="modal-header">
						                          		<h5 class="modal-title" id="mediumModalLabel">Story Description</h5>
						                          		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                              		<span aria-hidden="true">&times;</span>
						                          		</button>
						                     		</div>
					                     			<div class="modal-body">
						                        		<p>{{$story->description}}</p>
						                     		</div>
						                     		<div class="modal-footer">
						                        		<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
						                     		</div>
						                  		</div>
					                  		</form>
					            		</div>
					          		</div>
					          		<!-- Image Modal -->
					          		<div class="modal fade" id="showStoryImage{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
					               		<div class="modal-dialog modal-sm" role="document">
						               		<form action="#">
						                  		<div class="modal-content">
						                     		<div class="modal-header">
						                        		<h5 class="modal-title" id="smallmodalLabel">Story Image</h5>
					                        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                           			<span aria-hidden="true">&times;</span>
						                        		</button>
						                     		</div>
						                     		<div class="modal-body">
						                        		<div class="user-profile">
								                  			<img src="{{ asset($story['image_url']) }}" alt="Story Display Picture" style="border: 2px dashed black; padding: 10px;">
								                  		</div>
						                     		</div>
						                     		<div class="modal-footer">
						                        		<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
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