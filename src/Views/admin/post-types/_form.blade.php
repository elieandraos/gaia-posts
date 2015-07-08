{!! Form::text('title', (isset($postType))?$postType->title:null, [ 'class' => 'form-control', 'placeholder' => 'Enter post type title'] ) !!}
<br/>
@if($display_slug)
	{!! Form::text('slug', (isset($postType))?$postType->slug:null, [ 'class' => 'form-control', 'placeholder' => 'Enter post type slug'] ) !!}
	<br/>
@endif

{!! Form::submit('Save Post Type', ['class' => 'btn btn-primary btn-trans']) !!}