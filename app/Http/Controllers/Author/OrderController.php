<?php

namespace App\Http\Controllers\Author;

use App\ManuscriptOrder;
use App\Members;
use App\Order;
use App\OrderCategory;
use App\OrderIndustry;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $orders = auth()->user()->manuscript_orders;
        return view('author.manuscript.order.index',compact('orders'));
    }

    public function show($id)
    {
        $order = ManuscriptOrder::findOrFail($id);

        return view('author.manuscript.order.show',compact('order'));
    }





}
