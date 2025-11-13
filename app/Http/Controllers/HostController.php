<?php

namespace App\Http\Controllers;


use App\Administrator;
use App\Capacity;
use App\ElectronicSubscriptionDocument;
use App\Members;
use App\Host;
use App\HostCategory;
use App\HostIndustry;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class HostController extends Controller
{
    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $hosts = Host::all();

        return view('admin.host.index',compact('hosts'));
    }

    public function create(Request $request)
    {
        $capacities = Capacity::all();

        return view('admin.host.create',compact('capacities'));
    }

    public function edit(Request $request,$id)
    {
        $capacities = Capacity::all();

        $host = Host::findOrFail($id);

        $host_capacities =$host->capacities()->select('capacities.id as id')->pluck('id')->toArray();

        return view('admin.host.edit',compact('host','capacities','host_capacities'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'capacities']);
        // Insert a subscription
        $host = Host::create($data);
        //Add benefits to subscription
        if($request->has('capacities')) {
            foreach ($request->capacities as $capacity) {
                $host->capacities()->attach($capacity);
            }
        }

        return redirect()->route('admin.hosts.index')->with('message', 'Your successfully added a Hosting.');
    }

    public function update(Request $request,$id)
    {
        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token', 'capacities','_method']);
        // Update a subscription
        Host::where('id',$id)->update($data);
        $host = Host::findOrFail($id);
        //Add benefits to subscription
        if($request->has('capacities')) {
            //delete all benefit first
            $host->capacities()->detach();
            foreach ($request->capacities as $capacity) {
                $host->capacities()->attach($capacity);

            }
        }


        return redirect()->route('admin.hosts.index')->with('message', 'Host updated successfully.');
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = Host::find($id);
        //delete all benefit first
        $deletes->capacities()->detach();

        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }
}
