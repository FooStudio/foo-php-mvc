<?php
/**
 * Created by PhpStorm.
 * User: mendieta
 * Date: 4/16/17
 * Time: 8:27 AM
 */

namespace App\Controllers;

use App\Models\Author;
use App\Models\Post;

class HomeController
{

    function index()
    {
        $posts = Post::all();
        $authors = Author::all();
        view('home.index', compact('posts', 'authors'));
    }
}