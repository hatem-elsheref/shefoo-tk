<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    const ROOT_PATH = 'backend.blog.post';
    const NO_CATEGORIES = 'Category.create';
    const NO_TAGS = 'Tag.create';
    const WITH_TRASHED = 1;
    const WITHOUT_TRASHED = 2;
    const ONLY_TRASHED = 3;

    public function __construct(){
        $this->middleware('authorized:read_post')->only(['index']);
        $this->middleware('authorized:create_post')->only(['create','store']);
        $this->middleware('authorized:update_post')->only(['edit','update','status']);
        $this->middleware('authorized:delete_post')->only(['destroy','restore','forceDelete']);
    }

    private function saveImage(Request $request){

        if ($request->hasFile('image') && !empty($request->file('image'))){
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageNewName = date('y-m-d-',time()).$this->slug($request->title).'.'.$imageExtension;
            $imagePath = mainPath(_BLOG.'/'.$imageNewName);
            Image::make($request->file('image'))->resize(900,500,function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path($imagePath),100);
            return $imagePath;
        }
        return false;
    }

    private function getDataFromRequest(Request $request,Post $post=null){
        $data = $request->except('image','tags','meta','category');
        $data['slug'] = Carbon::now()->format('Y-m-d-') . $this->slug($request->title);
        $data['meta'] = ($request->has('meta') && !empty($request->meta)) ? serialize($request->meta) : (is_null($post) ? null : $post->meta);
        $data['category_id'] = $request->category;
        $data['admin_id'] = auth()->guard(ADMIN_GUARD)->id();

        $savedImage = $this->saveImage($request);
        $data['image'] =  $savedImage ? $savedImage :  (is_null($post) ? mainPath(DEFAULT_IMAGE) : $post->image);

        return $data;
    }

    private function checkCategoryAndTag(){

        $categories = Category::all(['id','name']);
        $tags = Tag::all(['id','name']);

        if ($categories->count() == 0){
            self::Info("Please Add At Least One Category First .. ");
            return self::NO_CATEGORIES;
        }




        if ($tags->count() == 0){
            self::Info("Please Add At Least One Tag First .. ");
            return self::NO_TAGS;
        }

        return ['tags' => $tags,'categories' => $categories];
    }

    private function search($type,Request $request){
        $posts = Post::withoutTrashed();

        switch ($type){
            case self::WITHOUT_TRASHED:
                $posts = Post::withoutTrashed();
                break;
            case self::WITH_TRASHED:
                $posts = Post::withTrashed();
                break;
            case self::ONLY_TRASHED:
                $posts = Post::onlyTrashed();
                break;
            default:
                $posts = Post::withoutTrashed();
        }


        return $posts->with(['category'])->withCount('tags')->where(function ($query1) use ($request){
            return $query1->when(!empty($request->search),function ($query2) use ($request){
                return $query2->where('title','like','%'.$request->search.'%')
                    ->orWhere('content','like','%'.$request->search.'%')
                    ->orWhere('status','like','%'.$request->search.'%')
                    ->orWhere('admin_id',$request->search)
                    ->orWhere('category_id',$request->search)
                    ->orWhere('views',$request->search)
                    ->orWhere('comments',$request->search);
            });
        });
    }

    public function index(Request $request)
    {
        $posts = $this->search(self::WITHOUT_TRASHED,$request)->paginate(PAGINATION)->withQueryString();
        return view($this->view('index'))->with('posts',$posts);
    }

    public function create(){
        $data = $this->checkCategoryAndTag();
        return  is_array($data) ? view($this->view('create'),$data) : redirect()->route($data);
    }

    public function store(PostRequest $request)
    {
        $data = $this->getDataFromRequest($request);

        $post = Post::create($data);

        self::Success();

        $post ? $post->tags()->attach($request->tags) : self::Fail();

        return redirect()->route('Post.index');
    }

    public function edit($id){
        $post = Post::withTrashed()->findOrFail($id);
        $data = $this->checkCategoryAndTag();
        return  is_array($data) ? view($this->view('edit'),$data)->with('post',$post) : redirect()->route($data);
    }

    public function update(PostRequest $request, $id)
    {

        $post = Post::withTrashed()->findOrFail($id);

        $data = $this->getDataFromRequest($request,$post);

        self::Success();

        $post->update($data) ? $post->tags()->sync($request->tags) : self::Fail();

        return redirect()->route('Post.index');
    }

    public function status($id){
        $post = Post::withTrashed()->findOrFail($id);
        $post->status = ($post->status == 'published') ? 'drafted' : 'published';
        $post->save();
        self::Success("Status Changed Successfully");
//        return redirect()->route('Post.index');
        return redirect()->back();
    }

    public function destroy($id){

        $post = Post::withTrashed()->findOrFail($id);

        try {
            $post->delete() ? self::Success() : self::Fail();
        } catch (\Exception $e) {
            self::Fail();
        }

        return redirect()->route('Post.index');
    }

    public function trashed(Request $request){

        $posts = $this->search(self::ONLY_TRASHED,$request)->paginate(PAGINATION)->withQueryString();
        return view($this->view('trashed'))->with('posts',$posts);

    }

    public function restore($id){
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore() ? self::Success() : self::Fail();
        return redirect()->route('Post.trashed');
    }

    public function forceDelete($id){
        $post = Post::onlyTrashed()->findOrFail($id);
        try {
            removeFile($post->image);
            $post->forceDelete() ? self::Success() : self::Fail();
        }catch (\Exception $e){self::Fail();}
        return redirect()->route('Post.trashed');
    }
/**
 * Share In Telegram
 * Share In Facebook
 * START PROJECTS MODULE
 * START IN FRONT END
 * LIKE AND RATE SYSTEM
 * VIEWS SYSTEM
 * REACT SYSTEM
 * FB PLUGINS
 * SOCIAL SHARE
 * RSS
 * SOCIAL AUTHENTICATION
 * GITHUB
 * SUPPORT WRITE SNIPPETS OF CODE
 * https://api.telegram.org/bot1594551933:AAEFmO8FuCruqfVD2ve-BmJaavSseNY-e5Q/getUpdates
 * https://api.telegram.org/bot1594551933:AAEFmO8FuCruqfVD2ve-BmJaavSseNY-e5Q/sendMessage?chat_id=@for_noob&text=hi
 */


}
