<?php 
	namespace Gaia\Repositories;
	
	interface PostRepositoryInterface
	{
		public function getAll($postTypeId);
		public function find($id);
		public function create($input);
		public function update($id, $input);
		public function delete($id);
	}
?>