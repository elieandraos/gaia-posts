{!! Form::text('title', (isset($postType))?$postType->title:null, [ 'class' => 'form-control', 'placeholder' => 'Enter post type title'] ) !!}
<br/>
@if($display_slug)
	{!! Form::text('slug', (isset($postType))?$postType->slug:null, [ 'class' => 'form-control', 'placeholder' => 'Enter post type slug'] ) !!}
	<br/>
@endif


    
<p>
	Post Type Template:
    {!! Form::select(
        'template_id', 
         $templates, 
        isset($postType)?$postType->template_id:null, 
        ['class' => 'form-control', 'id' => 'template_id']
    ) !!} 
</p>   

  


{!! Form::submit('Save Post Type', ['class' => 'btn btn-primary btn-trans']) !!}