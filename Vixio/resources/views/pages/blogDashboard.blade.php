@extends('layout')

@section('title', 'Blog | Dashboard')

@section('stylesheet')
	<link rel="stylesheet" href="{{asset('vixio-cms/assets/css/lib/datatable/dataTables.bootstrap.min.css')}}">
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
							<strong class="card-title">Data Table</strong>
						</div>
						<div class="card-body">
							<table id="bootstrap-data-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Title</th>
										<th>Content</th>
										<th>Image</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Test Title</td>
										<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni enim quod eos sunt quis eius consequatur, dolore aut, earum sed atque cumque tempora nostrum. Laborum earum, facilis accusamus repudiandae in.</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Publish</td>
										<td>
											<button class="btn btn-primary btn-block">Edit</button>
											<button class="btn btn-danger btn-block">Delete</button>
										</td>
									</tr>

									<tr>
										<td>Test Title 2</td>
										<td>The quick brown fox jumps over the lazy dog</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Publish</td>
										<td>
											<button class="btn btn-primary btn-block">Edit</button>
											<button class="btn btn-danger btn-block">Delete</button>
										</td>
									</tr>

									<tr>
										<td>Test Title 3</td>
										<td>LALALALALALALAAAAAAAAAAAAAA</td>
										<td>
											<img src="{{ asset('/image/upload/feelsgoodman.jpg') }}" alt="feelsgoodman">
										</td>
										<td>Unpublish</td>
										<td>
											<button class="btn btn-primary btn-block">Edit</button>
											<button class="btn btn-danger btn-block">Delete</button>
										</td>
									</tr>
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