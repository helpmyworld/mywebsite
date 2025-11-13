<?php

namespace App\Http\Controllers\Author;

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

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['showPublicProfile','filter']);
    }


    public function updateProfile(Request $request){

        if($request->isMethod('post')){
            $data = $request->except(['_token','bio']);
            $data['bio'] = nl2br($request->bio);
            /*echo "<pre>"; print_r($data); die;*/

            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error','Please enter your Name to update your account details!');    
            }

            User::where('id',auth()->id())->update($data);
            return redirect()->back()->with('flash_message_success','Your account details has been successfully updated!');
        }

    }

    public function updateProfileImage(Request $request){

        //Upload
        $user = User::findOrFail($request->user_id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            Storage::disk('public')->put('/profile/' . $user->slug, file_get_contents($file));

            $user->profile_image = $user->slug;
            $user->save();
            return redirect()->back()->with('flash_message_success','Your upload is successful!');
        }
        return redirect()->back()->with('flash_message_success','Upload is unsuccessful!');

    }


    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $old_pwd = User::where('id',Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd,$old_pwd->password)){
                // Update password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success',' Password updated successfully!');
            }else{
                return redirect()->back()->with('flash_message_error','Current Password is incorrect!');
            }
        }
    }



    public function editProfile(Request $request){
        $countries = Country::get();
        $user = auth()->user();
        return view('author.profile.edit')->with(compact('countries','user'));
    }

   public function showPublicProfile(Request $request, $slug)
    {
        // Only show live/active authors
        $user = User::where('slug', $slug)
            ->where('type', 'Author')
            ->where('status', 1)
            ->firstOrFail();

        return view('front.profile')->with(compact('user'));
    }

       public function filter(Request $request)
    {
        $query = User::where('type', 'Author')
            ->where('status', 1);

        // Optional name search
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        // ✅ Order featured authors first, then alphabetically
        $authors = $query->orderByDesc('featured_author')
                         ->orderBy('name', 'asc')
                         ->simplePaginate(10);

        return view('front.author-search')->with(compact('authors'));
    }

}
