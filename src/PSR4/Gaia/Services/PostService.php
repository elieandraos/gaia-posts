<?php namespace Gaia\Services;

class PostService
{
	
	/**
	 * Handles the image upload for the post
	 * @param type $post 
	 * @return type
	 */
	public function uploadImage($post, $uploaded_image)
	{
		$post->removeMediaCollection($post->getMediaCollectionName());
		
		$file = $uploaded_image;
		$tempDirectory = storage_path('temp');
		$fileName = $file->getClientOriginalName();
		$file->move($tempDirectory, $fileName);
		$collectionName = $post->getMediaCollectionName();
		$post->addMedia($tempDirectory . '/' . $fileName, $collectionName);
	}
	/**
	 * Removes the news image
	 * @param type $post 
	 * @return type
	 */
	public function removeImage($post)
	{
		$post->removeMediaCollection($post->getMediaCollectionName());
	}
}
?>