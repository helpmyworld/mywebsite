<?php

namespace App\Http\Controllers\Backend;

use App\Manuscript;
use App\Members;
use App\ManuscriptOrder;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class ManuscriptOrderController extends Controller
{
    public $imageUploader;

    public function __construct() {
        $this->middleware('adminlogin');
    }

    public function index(Request $request)
    {
        $orders = ManuscriptOrder::with('user')->get();

        return view('admin.manuscript.order.index',compact('orders'));
    }


    public function show($id)
    {
        $order = ManuscriptOrder::findOrFail($id);

        return view('admin.manuscript.order.show',compact('order'));
    }


    public function destroy(Request $request,$id)
    {
        //
        $deletes = ManuscriptOrder::find($request->id);
        $deletes->delete();
        Session::flash('message', 'Record deleted successfully!');
        return redirect()->back();
    }


}
