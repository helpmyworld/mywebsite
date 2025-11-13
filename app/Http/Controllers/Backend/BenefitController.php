<?php

namespace App\Http\Controllers\Backend;

use App\Administrator;

use App\Benefit;
use App\BenefitCategory;
use App\BenefitIndustry;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class BenefitController extends Controller
{
    public $imageUploader;

    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $benefits = Benefit::all();

        return view('admin.subscription.benefit.index',compact('benefits'));
    }

    public function create(Request $request)
    {

        return view('admin.subscription.benefit.create');
    }

    public function edit(Request $request,$id)
    {
        $benefit = Benefit::findOrFail($id);

        return view('admin.subscription.benefit.edit',compact('benefit'));
    }

    public function store(Request $request)
    {

        $data = $request->except(['_token',]);


        // Insert a benefit
        $benefit = Benefit::create($data);

        return redirect()->route('admin.subscription.benefits.index')->with('message', 'Your successfully added a benefit.');
    }

    public function update(Request $request,$id)
    {

        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token','_method']);


        // Update a benefit
        Benefit::where('id',$id)->update($data);

        return redirect()->route('admin.subscription.benefits.index')->with('message', 'Benefit updated successfully.');
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = Benefit::find($id);
        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }


}
