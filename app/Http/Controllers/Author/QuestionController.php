<?php

namespace App\Http\Controllers\Author;

use App\Manuscript;
use App\ManuscriptOrder;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        return view('author.question.create');
    }


    public function store(Request $request)
    {

        //Validate fields
        $request->validate([

            'title' => 'required',
            'body' => 'required',
        ]);

        if(auth()->user()->active_subscription()){
            $data = $request->except(['_token']);
            $data['type'] = 'Question';
            //Insert
            Post::create($data);
            Mail::send([], [], function ($message) {
                $message->to('rorisang@helpmyworld.co.za')
                    ->subject('New Question Post')
                    // here comes what you want
                    ->setBody('<p>You have new question post for approval</p>', 'text/html'); // for HTML rich messages
            });

            return redirect()->back()->with('message','You have successfully posted a question. Wait for approval');
        }
        else{
            $posts = Post::whereRaw('created_at >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH
                                    AND created_at < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY AND type = "Question" AND user_id='.auth()->id())->count();
            if($posts < 1){
                $data = $request->except(['_token']);
                $data['type'] = 'Question';
                //Insert
                Post::create($data);
                Mail::send([], [], function ($message) {
                    $message->to('rorisang@helpmyworld.co.za')
                        ->subject('New Question Post')
                        // here comes what you want
                        ->setBody('<p>You have new question post for approval</p>', 'text/html'); // for HTML rich messages
                });

                return redirect()->back()->with('message','You have successfully posted a question. Wait for approval');
            }
            else{
                return redirect()->back()->with('message','You are not eligible to ask a question');
            }
        }

    }


}
