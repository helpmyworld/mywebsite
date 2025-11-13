<?php

namespace App\Http\Controllers\Author;

use App\Members;
use App\Order;
use App\OrderCategory;
use App\OrderIndustry;
use App\OrdersProduct;
use App\Product;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class ProductOrderController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request,$product_id)
    {

        $orders = auth()->user()->orders($product_id);
        return view('author.product.order.index',compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('author.product.order.show',compact('order'));
    }

    public function SendEbookLink($id)
    {

        $order_product = OrdersProduct::findOrFail($id);

        $order = Order::where('id', $order_product->order_id)->first();

        $product = Product::where('id', $order->product_id)->first();
        $email = $order->user_email;
        //generate token
        $token = base64_encode(json_encode($order_product));

        $order_product->download_link_token = $token;
        $order_product->is_link_expired = 1;
        $order_product->save();

        $messageData = [
            'name' => $order->name,
            'link' => route("product.download_ebook",["token" => $token]),
            'emails' => $order->user_email,
        ];


        Mail::send('emails.ebooklink', $messageData, function ($message) use ($email) {
            $message->to($email)->subject('Ebook Link');
        });

        return redirect()->back()->with('flash_message_success', 'Link has been sent added successfully');
    }





}
