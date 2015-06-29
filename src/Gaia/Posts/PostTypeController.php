<?php namespace Gaia\Posts;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Gaia\Repositories\PostTypeRepositoryInterface;
use Auth;
use Redirect;
use App;
use Input;
use Flash;

class PostTypeController extends Controller {


	public function __construct(PostTypeRepositoryInterface $postTypeRepositoryInterface)
	{
		$this->postTypeRepos = $postTypeRepositoryInterface;
		$this->authUser = Auth::user();

		if(!$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$postTypes = $this->postTypeRepos->getAll();
		return view('admin.post-types.index', [ 'postTypes' => $postTypes]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$this->postTypeRepos->create($input);

		Flash::success('Post Type was created successfully.');
		return Redirect::route('admin.post-types.list');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$postType = $this->postTypeRepos->find($id);
		return view('admin.post-types.edit', ['postType' => $postType] );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$postType = $this->postTypeRepos->find($id);
		$postType->update($input);
		Flash::success('Post Type was updated successfully.');
		return Redirect::route('admin.post-types.list');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$postType = $this->postTypeRepos->find($id);
		$postType->delete();
	}

}
