<?php

namespace App\Http\Controllers\Author;

use App\Manuscript;
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

class ManuscriptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $manuscripts = auth()->user()->manuscripts;
        return view('author.manuscript.index',compact('manuscripts'));
    }

    public function create(){
        return view('author.manuscript.create');
    }

    public function store(Request $request){
        //Validate fields
        $request->validate([

            'title' => 'required',
            'file_name' => 'required',
        ]);


        $data = $request->except(['_token','file_name']);
        //Insert
        $manuscript = Manuscript::create($data);

        //Upload
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');

            $fileName = $manuscript->generateRandomName($manuscript->title, $file);
            Storage::disk('public')->put('/manuscript/' . $fileName, file_get_contents($file));

            $manuscript->file_name = $fileName;
            $manuscript->save();

        }

        // Send Confirmation Email to User
        $user_email = auth()->user()->email;
        $messageData = ['email'=>$user_email,'name'=>auth()->user()->name,'title' => $manuscript->title];
        Mail::send('emails.author-manuscript-uploaded',$messageData,function($message) use($user_email){
            $message->to($user_email)->subject('You have successfully uploaded your Manuscript');
        });

        // Send Confirmation Email to admin
        $admin_email = 'rorisang@helpmyworld.co.za';
        $messageData = ['email'=>$admin_email,'name'=>'Admin','title' => $manuscript->title];
        Mail::send('emails.admin-manuscript-uploaded',$messageData,function($message) use($admin_email){
            $message->to($admin_email)
                ->subject('New Manuscript Uploaded')
                ->attach(request()->file('file_name')->getRealPath(), [
                'as' => request()->file('file_name')->getClientOriginalName(),
                'mime' => request()->file('file_name')->getClientMimeType()
            ]);
        });

        return redirect()->route('author.manuscripts.index')->with('message','You have successfully uploaded a Manuscript. We shall get back to you in 14 days');
    }

    public function  show($id){
        $manuscript = Manuscript::findOrFail($id);
        return view('author.manuscript.show',compact('manuscript'));
    }


}
