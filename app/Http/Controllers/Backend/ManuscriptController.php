<?php

namespace App\Http\Controllers\Backend;

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
        $this->middleware('adminlogin');
    }

    public function index(){
        $manuscripts = Manuscript::all();
        return view('admin.manuscript.index',compact('manuscripts'));
    }

    public function create(){
        return view('admin.manuscript.create');
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
        Mail::send('emails.admin-manuscript-uploaded',$messageData,function($message) use($user_email){
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

        return redirect()->route('admin.manuscripts.index')->with('message','You have successfully uploaded a Manuscript. We shall get back to you in 14 days');
    }

    public function  show($id){
        $manuscript = Manuscript::findOrFail($id);
        return view('admin.manuscript.show',compact('manuscript'));
    }

    public function  edit($id){
        $manuscript = Manuscript::findOrFail($id);
        return view('admin.manuscript.edit',compact('manuscript'));
    }

    public function  update(Request $request,$id)
    {
        $data = $request->except(['_token','_method','comment']);

        if($request->status == 'Accepted'){
            $data['accepted_comment'] = nl2br($request->comment);

            if($request->cost != null){
                $data['cost'] = $request->cost;
            }

            Manuscript::where('id',$id)->update($data);

            $manuscript = Manuscript::findOrFail($id);
            $user = $manuscript->user;

            //Send Accepted Email to Member if subscribed
            if($user->active_subscription()){
                $user_email = $user->email;
                $messageData = ['user'=>$user,'manuscript' => $manuscript];
                Mail::send('emails.manuscript-accepted-subscribed',$messageData,function($message) use($user_email){
                    $message->to($user_email)->subject('Manuscript Accepted');
                });
            }
            else{// Send Accepted Email to Member if not subscribed
                $user_email = $user->email;
                $messageData = ['user'=>$user,'manuscript' => $manuscript];
                Mail::send('emails.manuscript-accepted',$messageData,function($message) use($user_email){
                    $message->to($user_email)->subject('Manuscript Accepted');
                });
            }




        }
        else if($request->status == 'Rejected'){
            $data['rejected_comment'] = nl2br($request->comment);
            Manuscript::where('id',$id)->update($data);

            $manuscript = Manuscript::findOrFail($id);
            $user = $manuscript->user;

            $user_email = $user->email;
            $messageData = ['user'=>$user,'manuscript' => $manuscript];
            Mail::send('emails.manuscript-rejected',$messageData,function($message) use($user_email){
                $message->to($user_email)->subject('Manuscript Rejected');
            });
        }
        else{
            Manuscript::where('id',$id)->update($data);
        }

        return redirect()->back()->with('message', 'Status has been updated');
    }

    public function destroy($id){
        $manuscript = Manuscript::findOrFail($id);
        if($manuscript->delete()){
            Session::flash('flash_message_success','Manuscript Successfully Deleted');
            return redirect()->back();
        }
    }
}
