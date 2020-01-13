<?php

namespace App\Http\View\Composers;

use App\Post;
use App\Comment;
use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
     
        //вариант1
        View::composer('admin._sidebar', function ($view) {
            $newComentsCount=Comment::where('status', 0)->count();
            $view->with(compact('newComentsCount'));
        });

            //вариант2
        // Using class based composers...
        View::composer(
            'pages._sidebar', 'App\Http\View\Composers\SidebarComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}