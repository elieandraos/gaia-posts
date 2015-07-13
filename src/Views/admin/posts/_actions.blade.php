
<a href="{{ route('admin.posts.edit', [$postType->id, $post->id]) }}">
	<button type="button" class="btn btn-info btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Edit {!! ucfirst($postType->title) !!}">
		<i class="fa fa-pencil-square-o"></i>
	</button>
</a>

<a href="{{ route('admin.posts.translate', [$postType->id, $post->id, $locale]) }}">
	<button type="button" class="btn btn-info btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Translate {!! ucfirst($postType->title) !!}">
		<i class="fa fa-refresh"></i>
	</button>
</a>

{!! Form::model($post, ['data-remote' => true, 'data-callback' => 'removeTableRow', 'class' => 'remote-form', 'route' => ['admin.posts.delete', $postType->id, $post->id]]) !!}
	<a href="#">
		<button type="button" class="btn btn-danger btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Delete {!! ucfirst($postType->title) !!}" 
				onclick="customConfirm( this, 'Are you sure?', 'You will not be able to recover this {!! ucfirst($postType->title) !!}.', 'Deleted!', 'The {!! ucfirst($postType->title) !!} has been deleted.')" >
			<i class="fa fa-trash-o"></i>
		</button>
	</a>
{!! Form::close() !!}