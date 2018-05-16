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
@endsection

@section('content')

	<div class="content mt-3">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">{{$data['data-table']}}</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Title</th>
										<th class="text-center">Content</th>
										<th class="text-center">Image</th>
										<th class="text-center">Status</th>
										<th class="text-center">Last Update</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data['blog'] as $post)
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$loop->iteration}}</td>
										<td class="text-center" style="vertical-align: middle;">{{$post['title']}}</td>
										<td class="text-center" style="vertical-align: middle;"><?php echo $post['content']; ?></td>
										<td class="text-center" style="vertical-align: middle;">
										@if(!is_null($post['image_url']))
											<button class="btn btn-primary" data-toggle="modal" data-target="#showBlogImage{{$post['id']}}">Show Image</button>
										@else
											-
										@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">
										@if($post['status'])
										published
										@else 
										'Unpublish'
										@endif
										</td>
										<td class="text-center" style="vertical-align: middle;">{{$post['updated_at']}}</td>
										<td class="text-center" style="vertical-align: middle;">
											<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal{{$post['id']}}">Edit</button>
											<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{$post['id']}}">Delete</button>
										</td>
									</tr>

									<!-- Modal Picture -->
									<div class="modal fade" id="showBlogImage{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
						               <div class="modal-dialog modal-sm" role="document">
						                  <div class="modal-content">
						                     <div class="modal-header">
						                        <h5 class="modal-title" id="smallmodalLabel">Story Image</h5>
						                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                           <span aria-hidden="true">&times;</span>
						                        </button>
						                     </div>
						                     <div class="modal-body">
						                        <div class="user-profile">
								                  	<img src='{{ asset($post["image_url"]) }}' alt="blog Image" style="border: 2px dashed black; padding: 10px;">
								                  </div>
						                     </div>
						                     <div class="modal-footer">
						                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
						                     </div>
						                  </div>
						               </div>
						            </div>

						            <!-- Modal Delete-->
		          					<div class="modal fade" id="deleteModal{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
						           		<div class="modal-dialog modal-sm" role="document">
							               	<form action="{{ route('deletePost', ['id' => $post['id']]) }}" method="post">
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
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@foreach($data['blog'] as $post)
	<!-- Modal Edit -->
		<div class="modal fade" id="editModal{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
          	<div class="modal-dialog modal-lg" role="document">
              <form action="{{ route('updatePost', ['id' => $post['id']]) }}" method="post" enctype="multipart/form-data">
              	{{ csrf_field() }}
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
			                        <input class="form-control" name="title" value="{{ $post['title'] }}">
			                     </div>
			                     <small class="form-text text-muted">ex. How To Create Better Story</small>
				               </div>

				               <div class="form-group">
				               	<label class=" form-control-label">Content</label>
				               	<textarea name="content" style="max-width:100%; width: 736px; height: 250px">{{$post['content']}}</textarea>
				               	<small class="form-text text-muted">ex. Content of the blog goes here</small>
				               </div>

				               <div class="form-group">
				                  	<label class="form-control-label">Status</label>
			                    	<div class="input-group">
			                        <label class="radio-inline">
			                        	@if($post['status'])
										<input type="radio" name="status" value="1" style="margin-right: 3px;" checked>
										@else
										<input type="radio" name="status" value="0" style="margin-right: 3px;">
										@endif
										Publish
									</label>
								   	<label class="radio-inline" style="margin-left: 15px;"">
								   		@if($post['status'])
										<input type="radio" name="status" value="1" style="margin-right: 3px;">
										@else
										<input type="radio" name="status" value="0" style="margin-right: 3px;" checked>
										@endif
								   		Unpublish
								   	</label>
			                     </div>
			                     <small class="form-text text-muted">ex. Select blog status</small>
				               </div>

				               <div class="form-group">
				               	<label class="form-control-label">Current Thumbnail image</label>
				                  <div class="current-thumbnail-image">
				                  @if(is_null($post['image_url']))
				                  	<img src="{{ asset('/image/default-blog.png') }}" alt="blog" style="border: 2px dashed black; padding: 10px;">
				                  	@else
				                  	<img src='{{ asset($post["image_url"]) }}' alt="blog" style="border: 2px dashed black; padding: 10px;">
				                  	@endif
				                  </div>
				               </div>

				                <div class="form-group" style="width: 50%;">
				                  	<label class="form-control-label">Thumbnail image</label>
			                     	<div class="input-group">
			                       		<input type="file" class="form-control" name="photo" accept="image/x-png,image/jpeg" value="" />
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
	@endforeach

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

	<script src="{{asset('vixio-cms/assets/js/richTextEditor.js')}}" type="text/javascript"></script>
	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','subscript','superscript','strikeThrough','removeformat','indent','outdent','hr','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat']}));</script>

@endsection