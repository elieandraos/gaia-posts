<?php namespace Gaia\Repositories; 

use App\Models\Post;
use Gaia\Repositories\PostTypeRepositoryInterface;

class PostRepository extends DbRepository implements PostRepositoryInterface 
{
	
	protected $limit = 15, $postTypeRepos;


	public function __construct(PostTypeRepositoryInterface $postTypeRepos)
	{
		$this->postTypeRepos = $postTypeRepos;
	}


	/**
	 * Returns all the posts sorted by published_at
	 * @return PostCollection
	 */
	public function getAll($postTypeId = null, $limit = null)
	{	
		$posts = Post::latest('published_at');
		
		if(!$limit)
			$limit = $this->limit;

		if($postTypeId)
			return $posts->where('post_type_id', '=', $postTypeId)->paginate($limit);

		return $posts->paginate($limit);
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


	/**
	 * Returns all the posts sorted by published_at
	 * @return PostCollection
	 */
	public function getAllByPostTypeSlug($slug, $limit = null)
	{	
		
		if(!$slug) return null;
		if(!$limit) $limit = $this->limit;

		$postType = $this->postTypeRepos->getBySlug($slug);

		return $this->getAll($postType->id, $limit);
		
	}
}
?>