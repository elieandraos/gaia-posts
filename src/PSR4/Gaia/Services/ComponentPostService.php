<?php namespace Gaia\Services;

class ComponentPostService
{
	
	/**
	 * Handles the image upload for the components inside the page
	 * @param type $componentPost 
	 * @return type
	 */
	public function uploadImage($componentPost, $uploaded_image)
	{
		$componentPost->removeMediaCollection($componentPost->getMediaCollectionName());
		
		$file = $uploaded_image;
		$tempDirectory = storage_path('temp');
		$fileName = $file->getClientOriginalName();

		$file->move($tempDirectory, $fileName);
		$collectionName = $componentPost->getMediaCollectionName();

		$componentPost->addMedia($tempDirectory . '/' . $fileName, $collectionName);
	}


	/**
	 * Removes the componentPost image
	 * @param type $componentPost 
	 * @return type
	 */
	public function removeImage($componentPost)
	{
		$componentPost->removeMediaCollection($componentPost->getMediaCollectionName());
	}


}
?>