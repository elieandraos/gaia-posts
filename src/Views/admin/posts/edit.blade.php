@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>{!! ucfirst($postType->title) !!}</li>
		    <li class="active">Edit</li>
		</ul>

		<h1 class="h1">Edit {!! ucfirst($postType->title) !!}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		{!! Form::model( $post, ['route' => ['admin.posts.update',$postType->id, $post->id], 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
				@include('admin.posts._form')
		{!! Form::close() !!}
	</div>
</div>

@stop