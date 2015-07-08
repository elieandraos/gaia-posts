<?php 
	namespace Gaia\Repositories;
	
	interface PostTypeRepositoryInterface
	{
		public function getAll();
		public function getBySlug($slug);
		public function find($id);
		public function create($input);
		public function update($id, $input);
		public function delete($id);
		public function renderMenu();
	}
?>