<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model {

	protected $table = "post_types";
	protected $fillable = ['title', 'fields']; 

}
