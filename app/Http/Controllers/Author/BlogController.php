<?php

namespace App\Http\Controllers\Author;

use App\Cat;
use App\Manuscript;
use App\ManuscriptOrder;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){

        $cats = Cat::all();
        return view('author.blog.create',compact('cats'));
    }


    public function store(Request $request)
    {


        //Validate fields
        $request->validate([

            'title' => 'required',
            'body' => 'required',
            'image' => 'required'
        ]);

        if(auth()->user()->active_subscription()){

            //Insert
            $this->createPost($request);
            Mail::send([], [], function ($message) {
                $message->to('rorisang@helpmyworld.co.za')
                ->subject('New Blog Post')
                // here comes what you want
                ->setBody('<p>You have new blog post for approval</p>', 'text/html'); // for HTML rich messages
            });
            return redirect()->back()->with('message','You have successfully posted a blog. Wait for approval');
        }
        else{
            $posts = Post::whereRaw('created_at >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH
                                    AND created_at < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY AND type = "Blog" AND user_id='.auth()->id())->count();
            if($posts < 1){
                $this->createPost($request);
                Mail::send([], [], function ($message) {
                    $message->to('rorisang@helpmyworld.co.za')
                        ->subject('New Blog Post')
                        // here comes what you want
                        ->setBody('<p>You have new blog post for approval</p>', 'text/html'); // for HTML rich messages
                });
                return redirect()->back()->with('message','You have successfully posted a blog. Wait for approval');
            }
            else{
                return redirect()->back()->with('message','You are not eligible to post a blog');
            }
        }

    }

    public function createPost(Request $request){
        $post = new Post;


        $post->title = $request->input('title');
        $post->type = 'Blog';
        $post->user_id = $request->user_id;

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

        $post->cats()->sync($request->cats, false);
    }


}
