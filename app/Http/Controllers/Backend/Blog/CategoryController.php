<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Blog\Category;
use App\Models\Blog\Post;

class CategoryController extends Controller
{
    const ROOT_PATH = 'backend.blog.category';

    public function __construct(){
        $this->middleware('authorized:read_category')->only(['index','show']);
        $this->middleware('authorized:create_category')->only(['create','store']);
        $this->middleware('authorized:update_category')->only(['edit','update']);
        $this->middleware('authorized:delete_category')->only(['destroy']);
    }

    public function index(){

        $categories = Category::withCount([
            'posts as published_posts' => fn($q) => $q->withTrashed()->where('status','published'),
            'posts as drafted_posts' => fn($q) => $q->withTrashed()->where('status','drafted')])
            ->orderByDesc('created_at')->paginate(PAGINATION);
        return view($this->view('index'))->with('categories',$categories);

    }

    public function create()
    {
        return view($this->view('create'));
    }

    public function store(CategoryRequest $request){

        $category = Category::create(['name' => $request->name,'slug'=>$this->slug($request->name)]);
        $category ? self::Success() : self::Fail();
        return redirect()->route('Category.index');
    }


    public function show($id)
    {
        $posts = Post::with('category')->withCount('tags')->where('category_id',$id)->paginate(PAGINATION);

        return view('backend.blog.post.index')->with('posts',$posts);
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view($this->view('edit'))->with('category',$category);
    }


    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update(['name'=>$request->name,'slug'=>$this->slug($request->name)]) ? self::Success() : self::Fail();
        return redirect()->route('Category.index');
    }


    public function destroy($id)
    {

        $category = Category::with(['posts' => fn($query) => $query->withTrashed()])->findOrFail($id);

        array_map(fn($post) => removeFile($post['image']),$category->posts->toArray());

        $category->delete() ? self::Success() : self::Fail();

        return redirect()->route('Category.index');

    }
}
