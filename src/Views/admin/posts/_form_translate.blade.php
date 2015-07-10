<!-- Panel start -->
<div class="row">
    <div class="col-md-2 col-md-push-10">
        <div class="form-group" style="text-align:right;margin-right:0">
            Translating to: {!! Form::select('locale', $locales, $locale, ['class' => 'form-control toggle-language', 'style' => 'width: auto;display:inline']) !!}
            <input type="hidden" value="{!! route('admin.posts.translate', [$postType->id, $post->id, null]) !!}" id="translate-url" />
        </div>
    </div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">General Info</h3>
	</div>
	<div class="panel-body">

		@include('admin.form-errors')

		<div class="form-group @if($errors->has('title')) has-error @endif">
			{!! Form::label('title', 'Title', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('title', $post->title, ['class' => 'form-control slug-target']) !!}
                {!! Form::hidden('slug', $post->slug) !!}
                {!! Form::hidden('published_at', $post->published_at) !!}
                {!! Form::hidden('category_id', $post->category_id) !!}
            </div>
        </div>

        <div class="form-group @if($errors->has('description')) has-error @endif">
			{!! Form::label('description', 'Description', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::textarea('description', $post->description, ['class' => 'form-control richtexteditor']) !!}
            </div>
        </div>  
	</div>
</div>
<!-- Panel end -->


<!-- Panel start -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Addtional Info</h3>
	</div>
	<div class="panel-body">					
		<div class="form-group">
			{!! Form::label('excerpt', 'Excerpt', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::textarea('excerpt', $post->excerpt, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
	</div>
</div>
<!-- Panel end -->

@include('admin.seo._form')

<div class="row">
    <div class="col-sm-1  col-sm-push-5">
        <a href="{{ route('admin.posts.list', [$postType->id]) }}">
            <button type="button" class="btn btn-default btn-trans btn-full-width" data-toggle="tooltip" data-placement="top" title="Back to list">
                <i class="fa fa-mail-reply"></i> &nbsp; {!! ucfirst($postType->title) !!}
            </button>
        </a>
    </div>
    <div class="col-sm-1 col-sm-push-5">
        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-trans form-control']) !!}
    </div>
</div>