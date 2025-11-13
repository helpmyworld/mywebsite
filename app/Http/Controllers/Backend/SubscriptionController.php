<?php

namespace App\Http\Controllers\Backend;

use App\Administrator;
use App\Benefit;
use App\ElectronicSubscriptionDocument;
use App\Members;
use App\Subscription;
use App\SubscriptionCategory;
use App\SubscriptionIndustry;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class SubscriptionController extends Controller
{

    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $subscriptions = Subscription::all();

        return view('admin.subscription.index',compact('subscriptions'));
    }

    public function create(Request $request)
    {
        $benefits = Benefit::all();

        return view('admin.subscription.create',compact('benefits'));
    }

    public function edit(Request $request,$id)
    {
        $benefits = Benefit::all();

        $subscription = Subscription::findOrFail($id);

        $subscription_benefits =$subscription->benefits()->select('benefits.id as id')->pluck('id')->toArray();

        return view('admin.subscription.edit',compact('subscription','benefits','subscription_benefits'));
    }

    public function store(Request $request)
    {

        $data = $request->except(['_token', 'benefits']);

        // Insert a subscription
        $subscription = Subscription::create($data);

        //Add benefits to subscription
        if($request->has('benefits')) {
            foreach ($request->benefits as $benefit) {

                $subscription->benefits()->attach($benefit);
            }
        }


        return redirect()->route('admin.subscriptions.index')->with('message', 'Your successfully added a subscription.');
    }

    public function update(Request $request,$id)
    {
        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token', 'benefits','_method']);
        // Update a subscription
        Subscription::where('id',$id)->update($data);
        $subscription = Subscription::findOrFail($id);
        //Add benefits to subscription
        if($request->has('benefits')) {
            //delete all benefit first
            $subscription->benefits()->detach();
            foreach ($request->benefits as $benefit) {
                $subscription->benefits()->attach($benefit);

            }
        }


        return redirect()->route('admin.subscriptions.index')->with('message', 'Subscription updated successfully.');
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = Subscription::find($id);
        //delete all benefit first
        $deletes->benefits()->detach();

        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }


}
