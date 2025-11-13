<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;


class BlogController extends Controller
{
    public function blog()

    {
        $posts=Post::where('approved',true)->where('type','Blog')->orderBy('id', 'desc')->paginate(3);
        return view ('blog.index', compact('posts'));
    }


        public function getSingle($slug)
    {
        $post = \App\Post::where('slug', $slug)->first();

        // Sidebar data
        $tags = \App\Tag::orderBy('name', 'asc')->get();                 // for Tags
        $cats = \App\Cat::orderBy('name', 'asc')->pluck('name');         // your sidebar expects just names
        $recentPosts = \App\Post::where('approved', true)
                        ->where('type', 'Blog')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();                                         // for RECENT POSTS
        $archives = \App\Post::where('approved', true)
                        ->where('type', 'Blog')
                        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, DATE_FORMAT(created_at, "%M %Y") as month, COUNT(*) as count')
                        ->groupBy('ym','month')
                        ->orderBy('ym','desc')
                        ->get();                                         // for BLOG ARCHIVES

        return view('blog.single', compact('post', 'tags', 'cats', 'recentPosts', 'archives'));
    }



}
