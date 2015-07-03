<?php namespace Gaia\Repositories; 

use App\Models\Post;

class PostRepository extends DbRepository implements PostRepositoryInterface 
{
	
	protected $limit = 12;
	
	/**
	 * Returns all the posts sorted by published_at
	 * @return PostCollection
	 */
	public function getAll($postTypeId = null)
	{	
		$posts = Posts::latest('published_at');
		
		if($postTypeId)
			return $posts->where('post_type_id', '=', $postTypeId)->paginate($this->limit);

		return $posts->paginate($this->limit);
	}


	/**
	 * Returns one post by id
	 * @param int $id 
	 * @return Post
	 */
	public function find($id)
	{
		return Post::findOrFail($id);
	}


	/**
	 * Create a post object
	 * @param int PostRequest $request 
	 * @return Post
	 */
	public function create($input)
	{
		return Post::create($input);
	}


	/**
	 * Update a post object
	 * @param int $id 
	 * @param type $input 
	 * @return Post
	 */
	public function update($id, $input)
	{
		$post = $this->find($id);
		return $post->update($input); 
	}


	/**
	 * Delete the post object
	 * @param int $id 
	 * @return 
	 */
	public function delete($id)
	{
		$post = $this->find($id);
		$post->delete();
	}
}
?>