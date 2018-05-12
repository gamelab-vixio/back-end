@extends('layout')

@section('title', 'Documentation | Content')

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
	               <strong>Create New Documentation Subtitle</strong>
	            </div>
		         
		         <form action="{{ route('createContent') }}" method="post">
		         	{{ csrf_field() }}
		            <div class="card-body card-block">

						<div class="form-group">
                       		<label for="select" class=" form-control-label">Subitle</label>
                        	<select name="subtitleID" class="form-control" style="width: 50%;">
                        		@foreach($data['subtitle']  as $subtitle)
								<option value="{{$subtitle['id']}}">{{$subtitle['subtitle']}}</option>
								@endforeach
                        	</select>
                     	</div>
							
		               	<div class="form-group" style="width: 50%;">
		                	<label class="form-control-label">Header</label>
                     		<div class="input-group">
	                        	<input class="form-control" name="header">
	                     	</div>
	                     	<small class="form-text text-muted">ex. Installation</small>
		               </div>
							
		               <div class="form-group">
			               	<label class="form-control-label">Content</label>
			               	<textarea name="content" style="width: 100%; height: 250px"></textarea>
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
										<th class="text-center">No.</th>
										<th class="text-center">Title</th>
										<th class="text-center">Subtitle</th>
										<th class="text-center">Header</th>
										<th class="text-center">Content</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data['content'] as $content)
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$content['subtitle']['title']['title']}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$content['subtitle']['subtitle']}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$content['header']}}</td>
										<td class="text-center" style="vertical-align: middle;"><?php echo $content['content']; ?></td>
										<td class="text-center" style="width: 20%;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$loop->iteration}}">Edit</button>
											<button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$loop->iteration}}">Delete</button>
										</td>
									</tr>
					          		<!-- Delete Modal -->
									<div class="modal fade" id="deleteModal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
					               		<div class="modal-dialog modal-sm" role="document">
						               		<form action="{{ route('deleteDocs', ['tid' => $content['subtitle']['title_id'], 'sid' => $content['subtitle_id'], 'hid' => $content['id']]) }}" method="post">
						               			{{ csrf_field() }}
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
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
	     	</div>
	   </div>
	</div>

	@foreach($data['content'] as $content)
	<!-- Edit Modal -->
	<div class="modal fade" id="editModal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document">
      		<form action="{{ route('editDocs', ['tid' => $content['subtitle']['title_id'], 'sid' => $content['subtitle_id'], 'hid' => $content['id']]) }}" method="post">
      			{{ csrf_field() }}
          		<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Edit Subtitle</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						<div class="card-body card-block">
 							<div class="form-group">
    							<label for="select" class=" form-control-label">Title</label>
    							<select name="subtitleID" class="form-control">
	                        		@foreach($data['subtitle']  as $subtitle)
		                        		@if($subtitle['id'] == $content['subtitle_id'])
		                        		<option value="{{$subtitle['id']}}" selected>
										{{$subtitle['subtitle']}}</option>
		                        		@else
										<option value="{{$subtitle['id']}}">
										{{$subtitle['subtitle']}}</option>
										@endif
									@endforeach
	                        	</select>
 							</div>

			               	<div class="form-group">
		                		<label class="form-control-label">Header</label>
                     			<div class="input-group">
	                        		<input class="form-control" name="header" value="{{$content['header']}}">
	                     		</div>
	                     		<small class="form-text text-muted">ex. Installation</small>
			               </div>

			               	<div class="form-group">
			               		<label class=" form-control-label">Content</label>
			               		<textarea name="content" style="max-width:100%; width: 736px; height: 250px">{{$content['content']}}</textarea>
			               		<small class="form-text text-muted">ex. New Content of the blog goes here</small>
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
	@endforeach

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

	<script src="{{asset('vixio-cms/assets/js/richTextEditor.js')}}" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','subscript','superscript','strikeThrough','removeformat','indent','outdent','hr','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat']}));</script>

@endsection