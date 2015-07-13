<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;
use Spatie\MediaLibrary\MediaLibraryModel\MediaLibraryModelInterface;
use Spatie\MediaLibrary\MediaLibraryModel\MediaLibraryModelTrait;


class ComponentPost extends Model implements MediaLibraryModelInterface, TranslatableContract {

	use Translatable, MediaLibraryModelTrait;

	protected $table = 'component_post';
	protected $fillable = ['component_id', 'post_id', 'value', 'params'];
	protected $translatedAttributes = ['value', 'params'];
	protected $translator = 'App\Models\ComponentPostTranslation';
	public $timestamps = false;

	/**
	 * Component Relation
	 * @return type
	 */
	public function component()
	{
		return $this->belongsTo('App\Models\Component');
	}

	/**
	 * Page Relation
	 * @return type
	 */
	public function post()
	{
		return $this->belongsTo('App\Models\Post');
	}


	 /**
     * Return the media collection name
     * @return type
     */
    public function getMediaCollectionName()
    {
    	return "collection-".$this->id;
    }


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

}
