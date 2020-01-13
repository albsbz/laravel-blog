<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $posts=Post::paginate(10);
        // $popularPosts=Post::orderBy('views', 'desc')->take(3)->get();
        // $featuredPosts=Post::where('is_featured', '1')->take(3)->get();
        // $recentPosts=Post::orderBy('date', 'desc')->take(4)->get();
        // $categories=Category::all();
        // return view('pages.index', compact('posts', 'popularPosts', 'featuredPosts', 'recentPosts', 'categories'));
        return view('pages.index', compact('posts'));
    }
    public function show($slug){
        $post=Post::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('post'));
    }
    public function tag($slug){
        $tags=Tag::where('slug', $slug)->firstOrFail();
        $posts=$tags->posts()->where('status', 1)->paginate(2);
        // dd($tags);
        return view('pages.list', compact('posts'));
    }
    public function category($slug){
        $categories=Category::where('slug', $slug)->firstOrFail();
        $posts=$categories->posts()->where('status', 1)->paginate(2);
        
        return view('pages.list', compact('posts'));
    }
}
