<?php namespace Gaia\Posts;

use App\Http\Requests\Request;

class PostRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => 'required|min:3',
			'description' => 'required',
			'published_at' => 'required',
			'slug' => 'required',
			'category_id' => 'required|exists:categories,id'
		];
	}

}