<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use function foo\func;

class PostController extends Controller
{

    const ROOT_PATH = 'backend.blog.post';

    public function __construct(){
        $this->middleware('authorized:read_post')->only(['index']);
        $this->middleware('authorized:create_post')->only(['create','store']);
        $this->middleware('authorized:update_post')->only(['edit','update']);
        $this->middleware('authorized:delete_post')->only(['destroy']);
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

    public function index(Request $request)
    {
        $posts = Post::with('tags','category')->where(function ($query1) use ($request){
            return $query1->when(!empty($request->search),function ($query2) use ($request){
                return $query2->where('title','like','%'.$request->search.'%')
                              ->where('content','like','%'.$request->search.'%')
                              ->where('status','like','%'.$request->search.'%')
                              ->where('admin_id',$request->search)
                              ->where('category_id',$request->search)
                              ->where('views',$request->search)
                              ->where('comments',$request->search);
            });
        })->paginate(PAGINATION);

        return view($this->view('index'))->with('posts',$posts);
    }


    public function create(){

      $categories = Category::get(['id','name']);
      if (count($categories) == 0){
          self::Info("Please Add Category First .. ");
          return redirect()->route('Category.create');
      }

      $tags = Tag::get(['id','name']);

      return view($this->view('create'))->with('tags',$tags)->with('categories',$categories);
    }

    public function store(PostRequest $request)
    {

        $data = $request->except('image','tags','meta','category');
        $data['slug'] = Carbon::now()->format('Y/m/d/') . $this->slug($request->title);
        $data['meta'] = ($request->has('meta') && !empty($request->meta) ) ? serialize($request->meta) : null;
        $data['category_id'] = $request->category;
        $data['admin_id'] = auth()->guard(ADMIN_GUARD)->id();


        $savedImage = $this->saveImage($request);
        $data['image'] =  $savedImage ? $savedImage :  mainPath(_BLOG.'/'.DEFAULT_IMAGE);

        $post = Post::create($data);

        if ($post){
            self::Success();
            $post->tags()->attach($request->tags);
        }else{
            self::Fail();
        }
        return redirect()->route('Post.index');
    }

    public function edit($id){
        $post = Post::withTrashed()->findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
