<?php namespace Gaia\Posts;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//Repositories
use Gaia\Repositories\PostTypeRepositoryInterface;
use Gaia\Repositories\TemplateRepositoryInterface;
//Facades
use Auth;
use Redirect;
use App;
use Input;
use Flash;
use View;
//Models 
use App\Models\Permission;

class PostTypeController extends Controller {


	public function __construct(PostTypeRepositoryInterface $postTypeRepositoryInterface, TemplateRepositoryInterface $templateRepos)
	{
		$this->postTypeRepos = $postTypeRepositoryInterface;
		$this->templateRepos = $templateRepos;

		$this->authUser = Auth::user();

		//check permissions
		if(!$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');

		//share the post type submenu to the layout
		View::share('postTypesSubmenu', $this->postTypeRepos->renderMenu());
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$postTypes = $this->postTypeRepos->getAll();
		$templates = $this->templateRepos->getAll('post')->lists('title', 'id');
		return view('admin.post-types.index', [ 'postTypes' => $postTypes, 'templates' => $templates]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['slug'] = str_slug($input['title']);
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
		$templates = $this->templateRepos->getAll('post')->lists('title', 'id');
		return view('admin.post-types.edit', ['postType' => $postType, 'templates' => $templates] );
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
		$perm = Permission::firstOrCreate([
			'name' => 'manage-'.$postType->slug,
			'display_name' => 'Manage '.$postType->title,
			'description' => 'Ability to add/edit/delete/translate '.$postType->title
		]);

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


	/**
	 * Check if the root category is set for the post type, and if it have descendants
	 * @return type
	 */
	public function checkCategoryConfiguration($id, $type)
	{
		$postType = $this->postTypeRepos->find($id);
		return view('admin.post-types.configuration', ['postType' => $postType, 'type' => $type]);
	}

}
