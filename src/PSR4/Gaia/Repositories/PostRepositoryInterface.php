<?php 
	namespace Gaia\Repositories;
	
	interface PostRepositoryInterface
	{
		public function getAll($postTypeId, $limit);
		public function find($id);
		public function create($input);
		public function update($id, $input);
		public function delete($id);
		public function getAllByPostTypeSlug($slug, $limit);
	}
?>