@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>{!! ucfirst($postType->title) !!}</li>
		    <li class="active">Configuration</li>
		</ul>

		<h1 class="h1">Post Type Configuration | {!! ucfirst($postType->title) !!}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="alert alert-warning" role="alert">
			@if($type == 'root')
				The root category is not <a href="/admin/categories/roots-post-types">configured</a>
				for the post type {!! $postType->title !!}
			@else
				The root category needs to have at least <a href="/admin/categories">one child</a>
				created.
			@endif
		</div>
	</div>
</div>

@stop