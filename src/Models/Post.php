<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\MediaLibrary\MediaLibraryModel\MediaLibraryModelInterface;
use Spatie\MediaLibrary\MediaLibraryModel\MediaLibraryModelTrait;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;

class Post extends Model implements MediaLibraryModelInterface, TranslatableContract {

	use MediaLibraryModelTrait, Translatable;

	protected $table = 'post';
	protected $fillable = ['title', 'excerpt', 'description', 'slug', 'published_at', 'youtube_url', 'category_id', 'post_type_id'];
	protected $translatedAttributes = ['title', 'excerpt', 'description'];
	protected $translator = 'App\Models\PostTranslation';
	//for ComponentPost input filter
	protected $except = ['_token', 'title', 'slug', 'description', 'excerpt', 'published_at', 'image', 'youtube_url' ,  'category_id', 'post_type_id', 'remove_image', 'meta_title', 'locale', 'meta_description', 'meta_keywords', 'facebook_title', 'facebook_description', 'twitter_title', 'twitter_description'];

	
	/**********************
	 * ELOQUANT RELATIONS *
	 **********************/
	
	public function category()
	{
		return $this->belongsTo('App\Models\Category');
	}

	public function postType()
	{
		return $this->belongsTo('App\Models\PostType');
	}


	/**
	 * Morphing to Seo Model
	 * @return type
	 */
	public function seo()
	{
	    return $this->morphOne('App\Models\Seo', 'seoable');
	}


	/**
	 * ComponentPage Relation
	 * @return type
	 */
	public function componentPosts()
	{
		return $this->hasMany('App\Models\ComponentPost');
	}


	/******************
	 * DATE FUNCTIONS *
	 ******************/
	
	/**
	 * published_at mutator: parse the date before saving the model 
	 * @param type $date 
	 * @return type
	 */
	public function setPublishedAtAttribute($date)
	{
		$this->attributes['published_at'] = Carbon::parse($date);
	}


	/**
	 * returns a friendly date format for pusblished_at attrubute
	 * @return type
	 */
	public function getHumanPublishedAt()
    {
        return Carbon::parse($this->published_at)->diffForHumans();
    }
    
    /**
     * Return the media collection name
     * @return type
     */
    public function getMediaCollectionName()
    {
    	return "collection-".$this->id;
    }
   

    /*****************
	 * MEDIA LINRARY *
	 *****************/
    /**
     * Image profiles: list of resized images post uploading
     * @return type
     */
	public function getImageProfileProperties()
	{
	    return [
	    	//front end thumbs
	        'featured' 		  => ['w'=>670, 'h'=>382],
	        'thumb-large'     => ['w'=>570, 'h'=>325],
	        'thumb-medium'    => ['w'=>270, 'h'=>192],
	        'thumb-small'     => ['w'=>170, 'h'=>120],
	        //social media sharing thumbs
	        'facebook' => ['w'=>128, 'h'=>128],
	        'twitter'  => ['w'=>128, 'h'=>128],
	        //backend
	        'thumb-xs' => ['w'=>60, 'h'=>60]
	    ];
	}    


	/**
	 * Returns an array of Component ids with their values repsectively.
	 * Done in PostController@edit. 
	 * @param type $input 
	 * @return type
	 */
	public function retrieveComponentIds($input)
	{
		//get the components ids from inputs and update their values
		$componentIds = array_except($input, $this->except);
		$array = [];

		if(is_array($componentIds) && count($componentIds))
		{
			foreach($componentIds as $key => $val)
			{
				$id = (int)str_replace("cp_", "", $key);
			 	(is_array($val))?$value = implode(",", $val):$value=$val; //in case of checkbox type, implode the array to string
			 	$array[$id] = ['value' => $value];
			}
		}

		return $array;
	}

}
