<?php
namespace App\Http\View\Composers;

use App\Post;
use App\Category;
use Illuminate\View\View;

class SidebarComposer
{
 
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }


    public function compose(View $view)
    {
        $popularPosts=Post::orderBy('views', 'desc')->take(3)->get();
        $featuredPosts=Post::where('is_featured', '1')->take(3)->get();
        $recentPosts=Post::orderBy('date', 'desc')->take(4)->get();
        $categories=Category::all();
        $view->with(compact('popularPosts', 'featuredPosts', 'recentPosts', 'categories'));
    }
}