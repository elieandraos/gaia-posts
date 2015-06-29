{!! Form::text('title', (isset($postType))?$postType->title:null, [ 'class' => 'form-control', 'placeholder' => 'Enter post type title'] ) !!}
<br/>
{!! Form::submit('Save Post Type', ['class' => 'btn btn-primary btn-trans']) !!}