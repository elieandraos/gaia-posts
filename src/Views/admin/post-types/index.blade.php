@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Post Types</li>
		    <li class="active">Manage</li>
		</ul>

		<h1 class="h1">Manage Post Types</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-7">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Post Types</h3>
			</div>
			<div class="panel-body">
				@if (!count($postTypes))
					<p class="unfortunate">You haven't created any post type yet :(</p>
				@else
					<table class="table table-hover">
					  <thead>
					    <tr>
					      <th>Title</th>
					      <th>Action</th>
					    </tr>
					  </thead>
					  <tbody>
					    @foreach($postTypes as $postType)
							<tr>
								<td>{{ $postType->title }}</td>
								<td>
									@include('admin.post-types._actions', ["postType" => $postType])
								</td>
							</tr>
						@endforeach
					  </tbody>
					</table>
				@endif
			</div>
		</div>
	</div>

	<div class="col-sm-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Add New Post Type</h3>
			</div>
			<div class="panel-body">
				{!! Form::open( ['route' => ['admin.post-types.store']]) !!}
					@include('admin.post-types._form')
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@stop