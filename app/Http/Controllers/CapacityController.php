<?php

namespace App\Http\Controllers;

use App\Capacity;
use Illuminate\Http\Request;
use App\Administrator;
Use App\Host;
use App\WorkCategory;
use App\WorkIndustry;
use App\User;
use App\Role;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CapacityController extends Controller
{
    public $imageUploader;

    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $capacities = Capacity::all();

        return view('admin.capacity.index',compact('capacities'));
    }

    public function create(Request $request)
    {

        return view('admin.capacity.create');
    }

    public function edit(Request $request,$id)
    {
        $capacity = Capacity::findOrFail($id);

        return view('admin.capacity.edit',compact('capacity'));
    }

    public function store(Request $request)
    {

        $data = $request->except(['_token',]);


        // Insert a benefit
        $capacity = Capacity::create($data);

        return redirect()->route('admin.capacity.index')->with('message', 'Your successfully added a benefit.');
    }

    public function update(Request $request,$id)
    {

        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token','_method']);


        // Update a benefit
        Capacity::where('id',$id)->update($data);

        return redirect()->route('admin.capacities.index')->with('message', 'Capacity updated successfully.');
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = Capacity::find($id);
        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }
}
