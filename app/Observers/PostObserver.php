<?php

namespace App\Observers;

use App\Models\Blog\Post;

class PostObserver
{

    public function created(Post $post)
    {
        //
    }


    public function updated(Post $post)
    {
    }


    public function deleted(Post $post)
    {
        //
    }


    public function restored(Post $post)
    {
        //
    }


    public function forceDeleted(Post $post)
    {
        //
    }
}
