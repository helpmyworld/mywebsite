<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrator;
Use App\Website;
use App\Work;
use App\WorkCategory;
use App\WorkIndustry;
use App\User;
use App\Role;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $imageUploader;

    public function __construct() {
        $this->middleware('adminlogin');
    }


    public function index(Request $request)
    {
        $works = Work::all();

        return view('admin.work.index',compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('admin.work.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->except(['_token',]);


        // Insert a benefit
        $work = Work::create($data);

        return redirect()->route('admin.work.index')->with('message', 'Your successfully added a work.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $work = Work::findOrFail($id);

        return view('admin.works.edit',compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        //publication,image and sample_chapter is excepted from the request because they are files
        $data = $request->except(['_token','_method']);


        // Update a benefit
        Work::where('id',$id)->update($data);

        return redirect()->route('admin.works.index')->with('message', 'Work updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $deletes = Work::find($id);
        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }
}
