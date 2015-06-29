<?php namespace Gaia\Repositories;

use App\Models\PostType;

class PostTypeRepository extends DbRepository implements PostTypeRepositoryInterface 
{
	
	protected $limit = 12;

	/**
	 * Returns all the post types sorted by cretaed_at
	 * @return PostTypeCollection
	 */
	public function getAll()
	{	
		return PostType::latest('created_at')->paginate($this->limit);
	}
	

	/**
	 * Returns one post type by id
	 * @param int $id 
	 * @return PostType
	 */
	public function find($id)
	{
		return PostType::findOrFail($id);
	}
	

	/**
	 * Create a post type object
	 * @return PostType
	 */
	public function create($input)
	{
		return PostType::create($input);
	}
	

	/**
	 * Update a post type object
	 * @param int $id 
	 * @param type $input 
	 * @return PostType
	 */
	public function update($id, $input)
	{
		$post_type = $this->find($id);
		return $post_type->update($input); 
	}


	/**
	 * Delete the post type object
	 * @param int $id 
	 * @return 
	 */
	public function delete($id)
	{
		$post_type = $this->find($id);
		$post_type->delete();
	}
}
?>