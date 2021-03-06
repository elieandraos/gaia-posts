<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryModules;

class PostType extends Model {

	protected $table = "post_types";
	protected $fillable = ['title', 'slug', 'fields', 'template_id']; 


	/**
	 * Template Relation
	 * @return type
	 */
	public function template()
	{
		return $this->belongsTo('App\Models\Template');
	}


	/**
	 * Returns the root category id configured for the post type
	 * @return type
	 */
	public function getConfiguredRootCategory()
	{
		$obj = CategoryModules::where('post_type_id', '=', $this->id)->first();
		
		if(!$obj)
			return null;

		return $obj->category_id;
	}

}
