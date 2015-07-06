@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>{!! ucfirst($postType->title) !!}</li>
		    <li class="active">Translate</li>
		</ul>

		<h1 class="h1">Translate {!! ucfirst($postType->title) !!}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		{!! Form::model( $post, ['route' => ['admin.posts.translate-store', $postType->id, $post->id, $locale], 'class' => 'form-horizontal', 'role' => 'form']) !!}
			@include('admin.posts._form_translate', ['locale' => $locale, 'post' => $post, 'postType' => $postType])
		{!! Form::close() !!}
	</div>
</div>

@stop