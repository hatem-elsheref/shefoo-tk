<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;
use App\Models\Blog\Tag;
use Illuminate\Support\Facades\DB;

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
        return view($this->view('index'))->with('tags',Tag::all());
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
        $tag = Tag::findOrFail($id);
        return view('backend.blog.post.index')->with('posts',$tag->posts);
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
        $tag = Tag::findOrFail($id);

        $this->removeRelationBetweenTagAndPosts($id);

        $tag->delete() ? self::Success() : self::Fail();

        return redirect()->route('Tag.index');
    }

    private function removeRelationBetweenTagAndPosts($tagId){
        DB::table('post_tags')->where('tag_id',$tagId)->delete();
    }
}


