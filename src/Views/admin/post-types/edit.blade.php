@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Post Types</li>
		    <li class="active">Edit</li>
		</ul>

		<h1 class="h1">Edit Post Type</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Post Type</h3>
			</div>
			<div class="panel-body">
				{!! Form::model($postType, ['route' => ['admin.post-types.update', $postType->id]]) !!}
					@include('admin.post-types._form')
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@stop