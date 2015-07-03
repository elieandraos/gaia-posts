<a href="{{ route('admin.post-types.edit', $postType->id) }}">
	<button type="button" class="btn btn-info btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Edit Post Type">
		<i class="fa fa-pencil-square-o"></i>
	</button>
</a>

{!! Form::model($postType, ['data-remote' => true, 'data-callback' => 'removeTableRow', 'class' => 'remote-form', 'route' => ['admin.post-types.delete', $postType->id]]) !!}
	<a href="#">
		<button type="button" class="btn btn-danger btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Delete Post Type" 
				onclick="customConfirm( this, 'Are you sure?', 'You will not be able to recover this post type.', 'Deleted!', 'The post type has been deleted.')" >
			<i class="fa fa-trash-o"></i>
		</button>
	</a>
{!! Form::close() !!}