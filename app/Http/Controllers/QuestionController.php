<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;


class QuestionController extends Controller
{
    public function index()

    {
        $posts=Post::where('type','Question')->where('approved',true)->orderBy('id', 'desc')->paginate(3);
        return view ('question.index', compact('posts'));
    }

    public function show($slug) {

        $post = Post::where('slug', '=', $slug)->first();
        return view('question.show')->withPost($post);
    }
}
