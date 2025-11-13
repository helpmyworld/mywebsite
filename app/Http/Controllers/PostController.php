<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Cat;
use Session;
use Purifier;
use Image;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Session;
use DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function getPost($id){
        $post= Post::findOrFail($id);
        return view('front.post',compact('post'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = Tag::all();
        $cats = Cat::all();
        return view('admin.posts.create', compact('tags', 'cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, array(
            'title' => 'required|max:255',
//            'slug' => 'required|min:3|max:255|unique:posts',
            'body' => 'required',
        ));
        $post = new Post;

        $admin = $request->session()->get('admin');
        $post->title = $request->input('title');
        $post->type = 'Blog';
        $post->approved = true;
//        $post->user_id = Admin()->id();
        $post->admin_id = $admin->id;
//        $post->admin=Admin()->id();

//        $post->slug = $request->input('slug');
        $post->body = Purifier::clean($request->input('body'));


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }

        $post->save();
        $post->tags()->sync($request->tags, false);
        $post->cats()->sync($request->cats, false);
        Session::flash('flash_message', 'Service successfully added!');
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $tags = Tag::all();
        $cats = Cat::all();
        $post = Post::find($id);
        return view('admin.posts.edit', compact('post', 'tags', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::find($id);
        $this->validate($request, array(
            'title' => "required|max:255",
            'slug' => "required|min:3|max:255|unique:posts,slug, $id",
            'body' => "required",
        ));
        $post->title = $request->title;
        $post->slug = $request->slug;
//        $post->body = $request->body;
        $post->body = Purifier::clean($request->input('body'));
        $post->save();


        if (isset($request->tags) || isset($request->categories)) {
            $post->tags()->sync($request->tags);
            $post->cats()->sync($request->cats);
        } else {
            $post->tags()->sync(array());
            $post->cats()->sync(array());
        }
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        $post->tags()->detach();
        $post->delete();
        Session::flash('flash_message', 'Record deleted successfully !');
        return redirect()->back()->with('success', 'Record deleted successfully');
    }

    public function approve(Request $request, $id)
    {
        //
        $post = Post::find($id);
        $post->approved = true;
        $post->save();

        return redirect()->back();

    }

    public function disapprove(Request $request, $id)
    {dd($request->session()->get('admin'));
        //
        $post = Post::find($id);
        $post->approved = false;
        $post->save();

        return redirect()->back();

    }
}
