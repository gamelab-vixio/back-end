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
							<strong class="card-title">{{$data['data-table']}}</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">Title</th>
										<th class="text-center">Content</th>
										<th class="text-center">Image</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($data['blog'] as $i => $post){ ?>
									<tr>
										<td class="text-center" style="vertical-align: middle;">{{$post['title']}}</td>
										<td class="text-center" style="vertical-align: middle;"><?php echo $post['content']; ?></td>
										<td class="text-center" style="vertical-align: middle;">
										<?php if(!is_null($post['image_url'])) { ?>
											<button class="btn btn-primary" data-toggle="modal" data-target="#showBlogImage{{$post['id']}}">Show Image</button>
										<?php } else { ?>
											-
										<?php } ?>
										</td>
										<td class="text-center" style="vertical-align: middle;">
										<?php
										if($post['status']) echo 'published';
										else echo 'Unpublish';
										?>
										</td>
										<td class="text-center" style="vertical-align: middle;">
											<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editModal{{$post['id']}}">Edit</button>
											<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal{{$post['id']}}">Delete</button>
										</td>
									</tr>

									<!-- Modal Picture -->
									<div class="modal fade" id="showBlogImage{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
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
									                  	<img src='{{ asset($post["image_url"]) }}' alt="blog Image" style="border: 2px dashed black; padding: 10px;">
									                  </div>
							                     </div>
							                     <div class="modal-footer">
							                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
							                     </div>
							                  </div>
							               </form>
						               </div>
						            </div>

						            <!-- Modal Edit -->
									<div class="modal fade" id="editModal{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
						              	<div class="modal-dialog modal-lg" role="document">
						                  <form action="{{url('/')}}/blog/updateBlog/{{$post['id']}}" method="post" enctype="multipart/form-data">
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
										                        <input class="form-control" name="title" placeholder="Title" value="{{$post['title']}}">
										                     </div>
										                     <small class="form-text text-muted">ex. How To Create Better Story</small>
											               </div>

											               <div class="form-group">
											               	<label class=" form-control-label">Content</label>
											               	<textarea name="content" style="max-width:100%; width: 736px; height: 250px"><?php echo $post['content']; ?></textarea>
											               	<small class="form-text text-muted">ex. Content of the blog goes here</small>
											               </div>

											               <div class="form-group">
											                  	<label class="form-control-label">Status</label>
										                    	<div class="input-group">
										                        <label class="radio-inline">
										                        	<?php if($post['status']) {?>
																	<input type="radio" name="status" value="1" style="margin-right: 3px;" checked>
																	<?php } else {?>
																	<input type="radio" name="status" value="0" style="margin-right: 3px;">
																	<?php } ?>
																	Publish
																</label>
															   	<label class="radio-inline" style="margin-left: 15px;"">
															   		<?php if($post['status']) {?>
																	<input type="radio" name="status" value="1" style="margin-right: 3px;">
																	<?php } else {?>
																	<input type="radio" name="status" value="0" style="margin-right: 3px;" checked>
																	<?php } ?>
															   		Unpublish
															   	</label>
										                     </div>
										                     <small class="form-text text-muted">ex. Select blog status</small>
											               </div>

											               <div class="form-group">
											               	<label class="form-control-label">Current Thumbnail image</label>
											                  <div class="current-thumbnail-image">
											                  <?php if(is_null($post['image_url'])) { ?>
											                  	<img src="{{ asset('/image/default-blog.png') }}" alt="blog" style="border: 2px dashed black; padding: 10px;">
											                  	<?php }else{ ?>
											                  	<img src='{{ asset($post["image_url"]) }}' alt="blog" style="border: 2px dashed black; padding: 10px;">
											                  	<?php } ?>
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

						          	<!-- Modal Delete-->
		          					<div class="modal fade" id="deleteModal{{$post['id']}}" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
						           		<div class="modal-dialog modal-sm" role="document">
							               	<form action="{{url('/')}}/blog/deleteBlog/{{$post['id']}}" method="get">
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

	{{-- NicEditor --}}
	<script src="{{asset('vixio-cms/assets/js/richTextEditor.js')}}" type="text/javascript"></script>

	<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','subscript','superscript','strikeThrough','removeformat','indent','outdent','hr','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat']}));</script>
	</script>

@endsection