<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;

class TagController extends Controller
{
    const ROOT_PATH = 'backend.blog.tag';


    public function __construct(){
        $this->middleware('authorized:read_tag')->only(['index','show']);
        $this->middleware('authorized:create_tag')->only(['create','store']);
        $this->middleware('authorized:update_tag')->only(['edit','update']);
        $this->middleware('authorized:delete_tag')->only(['destroy']);
    }

    public function index()
    {
        $tags = Tag::withCount([
            'posts as published_posts' => fn($q) => $q->withTrashed()->where('status','published'),
            'posts as drafted_posts' => fn($q) => $q->withTrashed()->where('status','drafted')])
            ->orderByDesc('created_at')->paginate(PAGINATION);
        return view($this->view('index'))->with('tags',$tags);
    }

    public function create()
    {
        return view($this->view('create'));
    }

    public function store(TagRequest $request){

        $tags = Tag::create(['name' => $request->name,'slug'=>$this->slug($request->name)]);
        $tags ? self::Success() : self::Fail();
        return redirect()->route('Tag.index');
    }


    public function show($id)
    {

        $posts = Post::with('category')->withCount('tags')->whereHas('tags',function ($query) use ($id){
            $query->where('tags.id',$id);
        })->paginate(PAGINATION);

        return view('backend.blog.post.index')->with('posts',$posts);
    }


    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view($this->view('edit'))->with('tag',$tag);
    }


    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update(['name'=>$request->name,'slug'=>$this->slug($request->name)]) ? self::Success() : self::Fail();
        return redirect()->route('Tag.index');
    }



    public function destroy($id)
    {
        $tag = Tag::with('posts')->findOrFail($id);

        $tag->posts()->detach($tag->posts->pluck('id')->toArray());

        $tag->delete() ? self::Success() : self::Fail();

        return redirect()->route('Tag.index');
    }

}


