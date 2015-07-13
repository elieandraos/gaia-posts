<?php namespace Gaia\Posts;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Gaia\Repositories\PostTypeRepositoryInterface;
use Gaia\Repositories\PostRepositoryInterface;
use Gaia\Repositories\TemplateRepositoryInterface;
use Gaia\Posts\PostRequest;
use Gaia\Services\PostService;
//Models
use App\Models\Seo;
use App\Models\Category;
use App\Models\Locale;
//Facades
use Redirect;
use Auth;
use App;
use MediaLibrary;
use Config;
use Flash;
use View;
use Route;

class PostController extends Controller {

	
	protected $postTypeRepos, $postRepos, $templateRepos, $postType, $categories;

	public function __construct(PostTypeRepositoryInterface $postTypeRepos, PostRepositoryInterface $postRepos, TemplateRepositoryInterface $templateRepos, PostService $postService)
	{
		$this->postTypeRepos = $postTypeRepos;
		$this->postRepos = $postRepos;
		$this->templateRepos = $templateRepos;
		$this->postService = $postService;
		$this->authUser = Auth::user();

		if(!$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');

		//get the post type from the url param
		$routeParamters = Route::current()->parameters();
		$postTypeId = $routeParamters['posttypeid'];
		$this->postType = $this->postTypeRepos->find($postTypeId);

		//get the categories, category check convert to route middleware
		$categoryRootId = $this->postType->getConfiguredRootCategory();
		if(!$categoryRootId)
			return Redirect::route('admin.post-types.configuration', [$postTypeId, "root"])->send();
		$root = Category::find($categoryRootId);
		if(!$root->descendants()->count())
			return Redirect::route('admin.post-types.configuration', [$postTypeId, "descendants"])->send();
		$categories = $root->descendants()->get();
		foreach($categories as $category)
			$this->categories[$category->id] = $category->title;

		//localization
		$this->locales = Locale::where('language', '!=', 'en')->lists('language', 'language');
		$this->first_locale = array_first($this->locales, function(){return true;});

		//share the post type submenu to the layout
		View::share('postTypesSubmenu', $this->postTypeRepos->renderMenu());
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($postTypeId)
	{
		//if(!$this->authUser->can('list-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');
		
		$posts = $this->postRepos->getAll($postTypeId);
		return view('admin.posts.index', ["posts" => $posts, "locale" => $this->first_locale, "postType" => $this->postType]);	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($postTypeId)
	{
		//if(!$this->authUser->can('create-edit-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');

		$seo = new Seo; 
		$sections = $this->templateRepos->getSectionsByOrder($this->postType->template_id);
		return view('admin.posts.create', ['seo' => $seo, 'thumbUrl' => null, "categories" => $this->categories, "postType" => $this->postType, 'sections' => $sections]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($postTypeId, PostRequest $request)
	{
		//if(!$this->authUser->can('create-edit-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');

		$input = $request->all();
		//create the post
		$post = $this->postRepos->create($input); 
		//upload the image via service
		if(isset($input['image']))
			$this->postService->uploadImage($post, $input['image']);	
		//add seo polymorphic model
		$seo = new Seo;
		$seo->updateFromInput($input);
		$post->seo()->save($seo);
		Flash::success('Post was created successfully.');
		return Redirect::route('admin.posts.list', [$postTypeId]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($postTypeId, $id)
	{
		//if(!$this->authUser->can('create-edit-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');
		
		$post = $this->postRepos->find($id);

		//get the small preview thumb if image is uploaded
		$mediaItems = MediaLibrary::getCollection($post, $post->getMediaCollectionName(), []);
		(count($mediaItems))?$thumbUrl = $mediaItems[0]->getURL('thumb-xs'):$thumbUrl = null; 

		$sections = $this->templateRepos->getSectionsByOrder($this->postType->template_id);
		return view('admin.posts.edit', ["post" => $post, "seo" => $post->seo, 'thumbUrl' => $thumbUrl, "categories" => $this->categories, "postType" => $this->postType, 'sections' => $sections]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($postTypeId, $id, PostRequest $request)
	{
		//if(!$this->authUser->can('create-edit-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');
		
		$input = $request->all();
		$post = $this->postRepos->find($id);

		//reset the input image
		if(isset($input['remove_image']) && !isset($input['image']))
			$input['image'] = null;
		//remove image if checkbox is ticked
		if(isset($input['remove_image']))
			$this->postService->removeImage($post);
		//update the database object
		$this->postRepos->update($post->id, $input);
		//upload new picture if any 
		if(isset($input['image']))
			$this->postService->uploadImage($post, $input['image']);

		$post->seo->updateFromInput($input);
		Flash::success('Post was updated successfully.');
		return Redirect::route('admin.posts.list', [$postTypeId]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($postTypeId,  $id)
	{
		//if(!$this->authUser->can('delete-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');
		
		$this->postRepos->delete($id);
	}


	/**
	 * Translate the translatable fields 
	 * @param type $post 
	 * @return type
	 */
	public function translate($postTypeId, $id, $locale)
	{
		//if(!$this->authUser->can('translate-news') && !$this->authUser->is('superadmin'))
		//	App::abort(403, 'Access denied');

		App::setLocale($locale);
		$post = $this->postRepos->find($id);
		$seo = $post->seo;

		$sections = $this->templateRepos->getSectionsByOrder($this->postType->template_id);

		return view('admin.posts.translate', ["post" => $post, "sections" => $sections,"seo" => $post->seo, 'locales' => $this->locales, 'locale' => $locale, 'postType' => $this->postType]);
	}


	/**
	 * Save the translated content of the news
	 * @param type $post 
	 * @param type $locale 
	 * @return type
	 */
	public function translateStore(PostRequest $request, $postTypeId, $id, $locale)
	{
		if(!$this->authUser->can('translate-news') && !$this->authUser->is('superadmin'))
			App::abort(403, 'Access denied');

		App::setLocale($locale);
		$post = $this->postRepos->find($id);

		$input = $request->all();
		$this->postRepos->update($post->id, $input);
		$post->seo->updateFromInput($input);
		App::setLocale("en");
		
		Flash::success($this->postType->title.' was translated successfully.');
		return Redirect::route('admin.posts.list', $this->postType->id);
	}

}
