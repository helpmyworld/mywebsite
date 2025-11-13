<?php

namespace App\Http\Controllers\Author;

use App\Manuscript;
use App\Post;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Session; 
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('frontlogin');
    }

    public function index(){

        $manuscripts = Manuscript::where('user_id',auth()->id())->orderBy('id','desc')->take(5)->get();
        return view('author.dashboard',compact('manuscripts'));
    }

    public function viewUsers(){
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }
}
