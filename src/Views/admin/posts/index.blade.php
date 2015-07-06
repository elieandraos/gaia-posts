@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>{!! $postType->title !!}</li>
		    <li class="active">List</li>
		</ul>


		<!-- Panel start -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{!! $postType->title !!} List</h3>
			</div>
			<div class="panel-body">
				<!-- News List -->
				<table class="table table-hover">
				  <thead>
				    <tr>
				      <th>Title</th>
				      <th>Category</th>
				      <th>Publish Date</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				  <tbody>
				    @foreach($posts as $post)
						<tr>
							<td>{{ $post->title }}</td>
							<td>{{ $post->category->title }}</td>
							<td>{{ $post->getHumanPublishedAt() }}</td>
							<td>
								@include('admin.posts._actions', ["post" => $post])
							</td>
						</tr>
					@endforeach
				  </tbody>
				</table>

				<div class="centered">
					{!! $posts->render() !!}
				</div>
			</div>
		</div>
		<!-- Panel end -->
	</div>
</div>

@stop