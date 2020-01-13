<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $posts=Post::all();
        return view('admin.posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags=Tag::all();
        $categories=Category::all();
        return view('admin.posts.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'title'=>'required',
            'content'=>'required',
            'date'=>'required',
            'image'=>'nullable|image'
            ]);
        $post=Post::add($request->all());
        $post->uploadImage($request->file('image'));
        // dd($request);
        $post->setCategory($request->get('category'));
        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post= Post::find($id);
        $tags=Tag::all();
        $categories=Category::all();
        return view('admin.posts.edit', compact('post', 'tags', 'categories'));
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
        // dd($request);
        $this->validate($request, [
            'title'=>'required',
            'content'=>'required',
            'date'=>'required',
            'image'=>'nullable|image'
            ]);
        $post=Post::find($id);
        $post->edit($request->all());
        $post->uploadImage($request->file('image'));
        // dd($request);
        $post->setCategory($request->get('category'));
        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);
        $post->remove();
        return Redirect::back()->with('message','Operation Successful !');
    }
}
