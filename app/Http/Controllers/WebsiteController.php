<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Work;
use App\ElectronicSubscriptionDocument;
use App\Members;
use App\Website;
use App\WebsiteCategory;
use App\WebsiteIndustry;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $websites = Website::all();

        return view('admin.website.index',compact('websites'));
    }

    public function create(Request $request)
    {
        $works = Work::all();

        return view('admin.website.create',compact('works'));
    }

    public function edit(Request $request,$id)
    {
        $works = Work::all();

        $website = Website::findOrFail($id);

        $website_works =$website->works()->select('works.id as id')->pluck('id')->toArray();

        return view('admin.website.edit',compact('website','works','website_works'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'works']);
        // Insert a subscription
        $website = Website::create($data);
        //Add benefits to subscription
        if($request->has('works')) {
            foreach ($request->works as $work) {
                $website->works()->attach($work);
            }
        }

        return redirect()->route('admin.websites.index')->with('message', 'Your successfully added a Website.');
    }

    public function update(Request $request,$id)
    {
        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token', 'works','_method']);
        // Update a subscription
        Website::where('id',$id)->update($data);
        $website = Website::findOrFail($id);
        //Add benefits to subscription
        if($request->has('works')) {
            //delete all benefit first
            $website->works()->detach();
            foreach ($request->works as $work) {
                $website->works()->attach($work);

            }
        }


        return redirect()->route('admin.websites.index')->with('message', 'Host updated successfully.');
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = Website::find($id);
        //delete all Work first
        $deletes->works()->detach();

        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }
}
