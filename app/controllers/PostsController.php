<?php
/**
 * Created by PhpStorm.
 * User: mendieta
 * Date: 4/16/17
 * Time: 11:06 AM
 */

namespace App\Controllers;

use App\Models\Post;

class PostsController
{
    function index()
    {
        $posts = Post::all();
        view('home.index', compact('posts'));
    }

    function post($vars)
    {
        $post = Post::find($vars["id"]);
        view('posts.post', compact('post'));
    }
}